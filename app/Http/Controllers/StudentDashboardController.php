<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $assessments = Assessment::with(['question'])
            ->where('student_id', $student->student_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_assessments' => $assessments->count(),
            'average_score' => $assessments->avg('score') ?? 0,
            'average_percentage' => $assessments->avg('percentage') ?? 0,
            'highest_score' => $assessments->max('score') ?? 0,
            'lowest_score' => $assessments->min('score') ?? 0,
        ];

        return view('student.dashboard', compact('student', 'assessments', 'stats'));
    }

    public function assessments()
    {
        $student = Auth::guard('student')->user();
        $assessments = Assessment::with(['question'])
            ->where('student_id', $student->student_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.assessments', compact('student', 'assessments'));
    }

    public function showAssessment(Assessment $assessment)
    {
        $student = Auth::guard('student')->user();
        
        // Ensure the assessment belongs to the logged-in student
        if ($assessment->student_id !== $student->student_id) {
            abort(403, 'Unauthorized access to this assessment.');
        }

        $assessment->load(['question', 'uploads']);

        return view('student.assessment-details', compact('student', 'assessment'));
    }
}