<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Action\UploadService;

class QuestionBankController extends Controller
{
    public function __construct(
        private UploadService $uploadService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with(['questionUpload', 'answerUpload']);
        if(auth()->user()->role != 'admin') {
            $questions = $questions->where('user_id', auth()->user()->id);
        }
        $questions = $questions->orderBy('created_at', 'desc')->get();
        return view('dashboard.question-manager', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create-question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        try {
            DB::beginTransaction();
            if ($request->hasFile('question_file')) {
                $upload = $this->uploadService->execute($validated['question_file'], 'questions/');
                $validated['question_upload_id'] = $upload->id;
            }
            if ($request->hasFile('answer_file')) {
                $upload = $this->uploadService->execute($validated['answer_file'], 'answers/');
                $validated['answer_upload_id'] = $upload->id;
            }
            Question::create($validated);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->route('question-bank.index')->with('error', 'Question creation failed');
        }
        return redirect()->route('question-bank.index')->with('success', 'Question created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        if (auth()->user()->role !== 'admin' && $question->user_id !== auth()->user()->id) {
            return redirect()->route('question-bank.index')->with('error', 'You do not have permission to view this question.');
        }
        
        return view('dashboard.question-edit', compact('question'));
    }

    public function edit(Question $question)
    {
        if (auth()->user()->role !== 'admin' && $question->user_id !== auth()->user()->id) {
            return redirect()->route('question-bank.index')->with('error', 'You do not have permission to edit this question.');
        }
        
        return view('dashboard.question-edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        if (auth()->user()->role !== 'admin' && $question->user_id !== auth()->user()->id) {
            return redirect()->route('question-bank.index')->with('error', 'You do not have permission to update this question.');
        }

        $validated = $request->validate([
            'course_code' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'max_total' => 'required|numeric|min:1',
            'difficulty' => 'required|string|in:strict,medium,lenient',
            'question_text' => 'nullable|string',
            'question_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'answer_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            DB::beginTransaction();
            
            if ($request->hasFile('question_file')) {
                if ($question->question_upload_id && $question->questionUpload) {
                    $question->questionUpload->delete();
                }
                $upload = $this->uploadService->execute($validated['question_file'], 'questions/');
                $validated['question_upload_id'] = $upload->id;
            }
            
            if ($request->hasFile('answer_file')) {
                if ($question->answer_upload_id && $question->answerUpload) {
                    $question->answerUpload->delete();
                }
                $upload = $this->uploadService->execute($validated['answer_file'], 'answers/');
                $validated['answer_upload_id'] = $upload->id;
            }
            
            $question->update($validated);
            DB::commit();
            
            return redirect()->route('question-bank.index')->with('success', 'Question updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->route('question-bank.index')->with('error', 'Question update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        if (auth()->user()->role !== 'admin' && $question->user_id !== auth()->user()->id) {
            return redirect()->route('question-bank.index')->with('error', 'You do not have permission to delete this question.');
        }

        try {
            DB::beginTransaction();
            
            $question->delete();
            
            DB::commit();
            return redirect()->route('question-bank.index')->with('success', 'Question and all related assessments deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->route('question-bank.index')->with('error', 'Question deletion failed');
        }
    }
}
