<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::withCount('assessments')->orderBy('created_at', 'desc')->get();
        return view('dashboard.student-management', compact('students'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $assessments = Assessment::with(['question', 'uploads'])
            ->where('student_id', $student->student_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.student-details', compact('student', 'assessments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('student-management.index')->with('error', 'You do not have permission to delete students.');
        }

        try {
            DB::beginTransaction();
            
            $student->delete();
            
            DB::commit();
            return redirect()->route('student-management.index')->with('success', 'Student deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('student-management.index')->with('error', 'Student deletion failed');
        }
    }

    public function export()
    {
        $students = Student::with(['assessments' => function($query) {
            $query->with(['question', 'uploads']);
        }])->get();

        $filename = 'students_with_assessments_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Student ID',
                'First Name',
                'Last Name',
                'Other Name',
                'Email',
                'Course Code',
                'Session',
                'Level',
                'Semester',
                'Score',
                'Status',
                'Assessment Date'
            ]);

            foreach ($students as $student) {
                if ($student->assessments->count() > 0) {
                    foreach ($student->assessments as $assessment) {
                        fputcsv($file, [
                            $student->student_id,
                            $student->firstname,
                            $student->lastname,
                            $student->othername ?? '',
                            $student->email,
                            $assessment->question ? $assessment->question->course_code : '',
                            $assessment->question ? $assessment->question->session : '',
                            $assessment->question ? $assessment->question->level : '',
                            $assessment->question ? $assessment->question->semester : '',
                            $assessment->score,
                            $assessment->status,
                            $assessment->created_at->format('Y-m-d H:i:s')
                        ]);
                    }
                } else {
                    fputcsv($file, [
                        $student->student_id,
                        $student->firstname,
                        $student->lastname,
                        $student->othername ?? '',
                        $student->email,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        ''
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
