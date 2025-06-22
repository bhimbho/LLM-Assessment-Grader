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
        $questions = Question::with('uploads');
        if(auth()->user()->role != 'admin') {
            $questions = $questions->where('user_id', auth()->user()->id);
        }
        $questions = $questions->orderBy('created_at', 'desc')->get();
        // dd(Question::count());
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
        return view('dashboard.create-question', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('dashboard.question-edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request = $request->validated();
        $question->update($request->validated());
        return redirect()->route('question-bank.index')->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('question-bank.index')->with('success', 'Question deleted successfully');
    }
}
