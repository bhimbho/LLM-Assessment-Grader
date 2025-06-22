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

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessment.show', $assessment->question->id)->with('success', 'Assessment deleted successfully');
    }
}
