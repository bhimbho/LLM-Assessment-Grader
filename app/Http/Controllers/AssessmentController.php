<?php

namespace App\Http\Controllers;

use App\Action\UploadService;
use App\Http\Requests\AssessmentStoreRequest;
use App\Jobs\AssessmentJob;
use App\Models\Assessment;
use App\Models\AssessmentUpload;
use App\Models\Question;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class AssessmentController extends Controller
{
    public function __construct(private UploadService $uploadService){}
    /**
     * Display a listing of the resource.
     */
    public function show(Question $question)
    {
        $assessments = Assessment::with(['question', 'question.user'])->whereRelation('question', 'id', $question->id)->paginate(15);
        return view('dashboard.assessment', compact('assessments', 'question'));
    }

    public function create(Question $question)
    {
        return view('dashboard.create-assessment', compact('question'));
    }

    public function store(AssessmentStoreRequest $request, Question $question)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            
            $createdAssessments = [];
            
            foreach ($validated['students'] as $studentIndex => $studentData) {
                $assessment = Assessment::create([
                    'question_id' => $question->id,
                    'status' => 'pending',
                ]);
                
                foreach ($studentData['assessment_files'] as $file) {
                    $upload = $this->uploadService->execute($file, 'assessments/');
                    $assessment->uploads()->attach($upload->id);
                }
                
                $assessment = $assessment->load('uploads', 'question', 'question.answerUpload');
                $createdAssessments[] = $assessment;
                
                AssessmentJob::dispatch($assessment, $validated['llm_model']);
            }
            
            DB::commit();
            
            $studentCount = count($createdAssessments);
            $message = $studentCount === 1 
                ? 'Assessment uploaded successfully' 
                : "{$studentCount} student assessments uploaded successfully";
                
            return redirect()->route('assessment.show', $question->id)->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->route('assessment.show', $question->id)->with('error', 'Assessment upload failed');
        }
    }

    public function export(Question $question)
    {
        $assessments = Assessment::with(['question', 'uploads'])
            ->where('question_id', $question->id)
            ->get();

        $filename = "assessments_{$question->course_code}_{$question->session}_level_{$question->level}_" . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($assessments) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'S/N',
                'Course Code',
                'Session',
                'Level',
                'Student ID',
                'Student Name',
                'Score',
                'Max Score',
                'Percentage',
                'Strictness Level',
                'Status',
                'AI Analysis',
                'Areas to Improve',
                'Uploaded Files',
                'Created Date'
            ]);

            foreach ($assessments as $index => $assessment) {
                $response = json_decode($assessment->response, true);
                $studentId = $response['student_id'] ?? 'AI Could not Determine Student ID';
                $analysis = $response['your analysis of the student\'s answer'] ?? '';
                $improvements = $response['area to improve on'] ?? '';
                
                $student = null;
                if ($studentId && $studentId !== 'AI Could not Determine Student ID') {
                    $student = \App\Models\Student::where('student_id', $studentId)->first();
                }
                
                $studentName = $student ? $student->full_name : 'Not Found';
                $uploadedFiles = $assessment->uploads->pluck('url')->implode(', ');
                
                fputcsv($file, [
                    $index + 1,
                    $assessment->question->course_code,
                    $assessment->question->session,
                    $assessment->question->level,
                    $studentId,
                    $studentName,
                    $assessment->score ?? 0,
                    $assessment->question->max_total,
                    $assessment->percentage ?? 0,
                    $assessment->question->difficulty,
                    $assessment->status,
                    $analysis,
                    $improvements,
                    $uploadedFiles,
                    $assessment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessment.show', $assessment->question->id)->with('success', 'Assessment deleted successfully');
    }
}
