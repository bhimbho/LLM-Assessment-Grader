<?php

namespace App\Service;

use App\Models\Student;
use App\Service\Interface\LLMInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService implements LLMInterface
{
    public function generateResponse($data): void
    {
        $inlineData = [];
        $label = [];
        $order = 1;
        foreach ($data->uploads as $upload) {
            $filePath = storage_path('app/public/' . $upload->url);
            $fileContents = file_get_contents($filePath);
            $base64Data = base64_encode($fileContents);
            $mimeType = $this->getMimeType($filePath);
            $label[] = "File {$order}: Student Assessment File";
            $inlineData[] = [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $base64Data
                ]
            ];
            $order++;
        }
        $prompt = "You are a helpful assistant that can help tutors grade written assessments.";

        if ($data->question->question_file) {
            $filePath = storage_path('app/public/' . $data->question->question_file);
            $fileContents = file_get_contents($filePath);
            $base64Data = base64_encode($fileContents);
            $mimeType = $this->getMimeType($filePath);
            $label[] = 'question_image';
            $inlineData[] = [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $base64Data
                ]
            ];
            $label[] = "File {$order}: Question File";
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
            $label[] = 'answer_image';
            $inlineData[] = [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $base64Data
                ]
            ];
            $label[] = "File {$order}: Answer File";
            $order++;
            $prompt .= "- You are given an answer file. The answer file is the correct answer to the question. Grade the student's answer based on the answer file with a little bit of your own judgement.";
        }

        $prompt .= "
        - You will need to grade the assessments based on the question and the uploaded assessments.
        - You will need to return a JSON with key 'score' (maximum score no more than {$data->question->max_total}),
        - You will grade the assessment based on strictness level supplied which can be 'strict', 'medium' or 'lenient', the strictness level is the strictness level of the question.
        - The strictness level is {$data->question->difficulty}.
        - key 'student_id' extracted from the handwritten assessment, if not found return student_id as null,
        - key 'percentage' for your grading accuracy (max 100%),
        and a nested object 'response' with keys 'student_id' and 'analysis of the student answer', 'explanation' explaining the grade and 'area to improve on'.
        You must return a valid JSON with these keys.
        - The Files are in this order: " . implode(', ', $label);

        try {
            $response = Http::timeout(120) 
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post(env('GEMINI_API_URL').env('GEMINI_API_KEY'), [
                    'contents' => [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                            ...$inlineData
                        ]
                    ]
                ]);
            Log::info($response->json());

            if ($response->failed()) {
                Log::error('Gemini API Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'assessment_id' => $data->id
                ]);
                $data->status = 'failed';
                $data->response = json_encode([
                    'error' => 'API request failed',
                    'status' => $response->status(),
                    'details' => $response->body()
                ]);
                $data->save();
                return;
            }
            $text = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            $cleanedJson = preg_replace('/^```json|```$/m', '', trim($text));

            $parsedData = json_decode($cleanedJson, true);

            $data->status = 'completed';
            $data->percentage = $parsedData['percentage'] ?? null;
            
            // Only set student_id if it's provided and the student exists
            if (isset($parsedData['student_id']) && $parsedData['student_id']) {
                $studentExists = Student::where('student_id', $parsedData['student_id'])->exists();
                if ($studentExists) {
                    $data->student_id = $parsedData['student_id'];
                }
            }
            
            $data->score = $parsedData['score'] ?? null;
            $data->response = $parsedData['response'] ?? null;

            $data->save();
            
            // Send notification to student if assessment is completed and student is identified
            if ($data->student_id && $data->student) {
                try {
                    $data->student->notify(new \App\Notifications\AssessmentCompletedNotification($data));
                    Log::info('Assessment completion notification sent successfully', [
                        'assessment_id' => $data->id,
                        'student_id' => $data->student_id
                    ]);
                } catch (\Exception $notificationError) {
                    // Log notification failure but don't fail the assessment
                    Log::error('Failed to send assessment notification', [
                        'assessment_id' => $data->id,
                        'student_id' => $data->student_id,
                        'error' => $notificationError->getMessage()
                    ]);
                }
            }
        } catch (ConnectionException $e) {
            Log::error('Gemini API Connection Error', [
                'message' => $e->getMessage(),
                'assessment_id' => $data->id,
                'error_type' => 'timeout/connection'
            ]);
            $data->status = 'failed';
            $data->response = json_encode([
                'error' => 'Connection timeout',
                'message' => 'The AI grading service took too long to respond. Please try again.',
                'technical_details' => $e->getMessage()
            ]);
            $data->save();
            return;
        } catch (\Exception $e) {
            Log::error('Gemini Service Error', [
                'message' => $e->getMessage(),
                'assessment_id' => $data->id,
                'trace' => $e->getTraceAsString()
            ]);
            $data->status = 'failed';
            $data->response = json_encode([
                'error' => 'Service error',
                'message' => 'An unexpected error occurred during grading.',
                'technical_details' => $e->getMessage()
            ]);
            $data->save();
            return;
        }
    }

    /**
     * Helper to convert file extension to proper mime type
     */
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