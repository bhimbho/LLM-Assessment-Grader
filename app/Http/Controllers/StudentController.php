<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Assessment;
use App\Exports\StudentsWithAssessmentsExport;
use App\Exports\StudentsExport;
use App\Traits\HasExport;
use App\Helpers\ExportHelper;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    use HasExport;
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
        return view('dashboard.create-student');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $student = Student::create($request->validated());
            
            DB::commit();
            
            return redirect()->route('student-management.index')
                ->with('success', 'Student added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add student. Please try again.');
        }
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
        if (Auth::check() && Auth::user()->role !== 'admin') {
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
        $export = new StudentsWithAssessmentsExport();
        $filename = ExportHelper::studentFilename('students_with_assessments');
        
        return $this->exportToExcel($export, $filename);
    }

    public function exportStudents()
    {
        $export = new StudentsExport();
        $filename = ExportHelper::studentFilename('students');
        
        return $this->exportToExcel($export, $filename);
    }

    public function exportToCsv()
    {
        $export = new StudentsWithAssessmentsExport();
        $filename = ExportHelper::studentFilename('students_with_assessments');
        
        return $this->getExportService()->exportToCsv($export, $filename);
    }
}
