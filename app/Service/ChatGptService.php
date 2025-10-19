<?php

namespace App\Service;

use App\Service\Interface\LLMInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatGptService implements LLMInterface
{
	public function generateResponse($data): void
	{
		$contents = [];
		$labels = [];
		$order = 1;
		Log::info("Generating response for chatgpt");
		foreach ($data->uploads as $upload) {
			$filePath = storage_path('app/public/' . $upload->url);
			$fileContents = file_get_contents($filePath);
			$base64Data = base64_encode($fileContents);
			$mimeType = $this->getMimeType($filePath);
			$labels[] = "File {$order}: Student Assessment File";
			$contents[] = [
				'type' => 'image_url',
				'image_url' => [
					'url' => 'data:' . $mimeType . ';base64,' . $base64Data,
				],
			];
			$order++;
		}

		$prompt = "You are a helpful assistant that can help tutors grade written assessments.";

		if ($data->question->question_file) {
			$filePath = storage_path('app/public/' . $data->question->question_file);
			$fileContents = file_get_contents($filePath);
			$base64Data = base64_encode($fileContents);
			$mimeType = $this->getMimeType($filePath);
			$labels[] = 'question_image';
			$contents[] = [
				'type' => 'image_url',
				'image_url' => [
					'url' => 'data:' . $mimeType . ';base64,' . $base64Data,
				],
			];
			$labels[] = "File {$order}: Question File";
			$order++;
			$prompt .= "- You are given question file.";
		} else {
			$prompt .= "- You are given question as follows: {$data->question->question_text}.";
		}

		if ($data->question->answerUpload) {
			$filePath = storage_path('app/public/' . $data->question->answerUpload->url);
			$fileContents = file_get_contents($filePath);
			$base64Data = base64_encode($fileContents);
			$mimeType = $this->getMimeType($filePath);
			$labels[] = 'answer_image';
			$contents[] = [
				'type' => 'image_url',
				'image_url' => [
					'url' => 'data:' . $mimeType . ';base64,' . $base64Data,
				],
			];
			$labels[] = "File {$order}: Answer File";
			$order++;
			$prompt .= "- You are given an answer file. The answer file is the correct answer to the question. Grade the student's answer based on the answer file with a little bit of your own judgement.";
		}

		$prompt .= "\n\n- You will need to grade the assessments based on the question and the uploaded assessments.\n- You will need to return a JSON with key 'score' (maximum score no more than {$data->question->max_total}),\n- You will grade the assessment based on strictness level supplied which can be 'strict', 'medium' or 'lenient', the strictness level is the strictness level of the question.\n- The strictness level is {$data->question->difficulty}.\n- key 'student_id' extracted from the handwritten assessment, if not found return student_id as null,\n- key 'percentage' for your grading accuracy (max 100%),\n- and a nested object 'response' with keys 'student_id' and 'analysis of the student answer', 'explanation' explaining the grade and 'area to improve on'.\nYou must return a valid JSON with these keys.\n- The Files are in this order: " . implode(', ', $labels);

		array_unshift($contents, [
			'type' => 'text',
			'text' => $prompt,
		]);

		try {
			$response = Http::withToken(env('OPENAI_API_KEY'))
				->withHeaders([
					'Content-Type' => 'application/json',
				])
				->post('https://api.openai.com/v1/chat/completions', [
					'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
					'messages' => [
						[
							'role' => 'user',
							'content' => $contents,
						],
					],
					'response_format' => [ 'type' => 'json_object' ],
					'temperature' => 0.2,
				]);

			$responseData = $response->json();
			Log::info('OpenAI Response:', $responseData);

			// Check for API errors in the response
			if (isset($responseData['error'])) {
				$error = $responseData['error'];
				$errorMessage = $error['message'] ?? 'Unknown OpenAI API error';
				$errorType = $error['type'] ?? 'unknown';
				$errorCode = $error['code'] ?? 'unknown';
				
				Log::error("OpenAI API Error - Type: {$errorType}, Code: {$errorCode}, Message: {$errorMessage}");
				
				$data->status = 'failed';
				$data->response = json_encode([
					'error' => $errorMessage,
					'type' => $errorType,
					'code' => $errorCode
				]);
				$data->save();
				return;
			}

			if ($response->failed()) {
				Log::error('OpenAI API HTTP Error: ' . $response->status() . ' - ' . $response->body());
				$data->status = 'failed';
				$data->response = json_encode(['error' => 'HTTP ' . $response->status() . ': ' . $response->body()]);
				$data->save();
				return;
			}

			// Check if response has the expected structure
			if (!isset($responseData['choices'][0]['message']['content'])) {
				Log::error('OpenAI API: Unexpected response structure', $responseData);
				$data->status = 'failed';
				$data->response = json_encode(['error' => 'Unexpected response structure from OpenAI API']);
				$data->save();
				return;
			}

			$content = $responseData['choices'][0]['message']['content'];
			$parsedData = json_decode($content, true);

			// Validate that we got valid JSON
			if (json_last_error() !== JSON_ERROR_NONE) {
				Log::error('OpenAI API: Invalid JSON response - ' . json_last_error_msg());
				Log::error('Raw content: ' . $content);
				$data->status = 'failed';
				$data->response = json_encode(['error' => 'Invalid JSON response from OpenAI: ' . json_last_error_msg()]);
				$data->save();
				return;
			}

			$data->status = 'completed';
			$data->percentage = $parsedData['percentage'] ?? null;
			
			// Only set student_id if it's provided and the student exists
			if (isset($parsedData['student_id']) && $parsedData['student_id']) {
				$studentExists = \App\Models\Student::where('student_id', $parsedData['student_id'])->exists();
				if ($studentExists) {
					$data->student_id = $parsedData['student_id'];
				}
			}
			
			$data->score = $parsedData['score'] ?? null;
			$data->response = $parsedData['response'] ?? null;

			$data->save();
		} catch (ConnectionException $e) {
			Log::error('OpenAI API Connection Error: ' . $e->getMessage());
			$data->status = 'failed';
			$data->response = json_encode(['error' => 'Connection error: ' . $e->getMessage()]);
			$data->save();
			return;
		} catch (\Exception $e) {
			Log::error('OpenAI Service Error: ' . $e->getMessage());
			$data->status = 'failed';
			$data->response = json_encode(['error' => 'Service error: ' . $e->getMessage()]);
			$data->save();
			return;
		}
	}

	private function getMimeType(string $filePath): string
	{
		$extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

		return match ($extension) {
			'pdf' => 'application/pdf',
			'png' => 'image/png',
			'jpg', 'jpeg' => 'image/jpeg',
			default => 'application/octet-stream',
		};
	}
}


