<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;

class StudentsWithAssessmentsExport extends BaseExport
{
    protected $headings = [
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
    ];

    /**
     * Get the data to be exported
     */
    protected function getData()
    {
        return Student::with(['assessments' => function($query) {
            $query->with(['question', 'uploads']);
        }])->get();
    }

    /**
     * Map a single row of data
     */
    protected function mapRow($student): array
    {
        $rows = [];
        
        if ($student->assessments->count() > 0) {
            foreach ($student->assessments as $assessment) {
                $rows[] = [
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
                ];
            }
        } else {
            $rows[] = [
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
            ];
        }
        
        return $rows;
    }

    /**
     * Override the collection method to handle the nested structure
     */
    public function collection()
    {
        $students = $this->data ?? $this->getData();
        $exportData = collect();
        
        foreach ($students as $student) {
            if ($student->assessments->count() > 0) {
                foreach ($student->assessments as $assessment) {
                    $exportData->push([
                        'student' => $student,
                        'assessment' => $assessment
                    ]);
                }
            } else {
                $exportData->push([
                    'student' => $student,
                    'assessment' => null
                ]);
            }
        }
        
        return $exportData;
    }

    /**
     * Override the map method to handle the nested structure
     */
    public function map($row): array
    {
        $student = $row['student'];
        $assessment = $row['assessment'];
        
        if ($assessment) {
            return [
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
            ];
        } else {
            return [
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
            ];
        }
    }
} 