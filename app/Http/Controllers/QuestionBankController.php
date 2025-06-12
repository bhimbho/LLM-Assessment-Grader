<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentStoreRequest;
use App\Models\Assignment;
use App\Models\Question;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Assign;

class QuestionBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('uploads')->paginate(15);
        return view('dashboard.question-manager', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentStoreRequest $request)
    {
        $request = $request->validated();
        $request['user_id'] = auth()->user()->id;
        $question = Question::create($request->validated());
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
