<?php

namespace App\Exports;

use App\Models\Assessment;

class AssessmentsExport extends BaseExport
{
    protected $headings = [
        'Assessment ID',
        'Student ID',
        'Student Name',
        'Question ID',
        'Course Code',
        'Session',
        'Level',
        'Semester',
        'Score/Max Score',
        'Status',
        'Created At',
        'Updated At'
    ];

    /**
     * Get the data to be exported
     */
    protected function getData()
    {
        return Assessment::with(['student', 'question'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Map a single row of data
     */
    protected function mapRow($assessment): array
    {
        return [
            $assessment->id,
            $assessment->student_id,
            $assessment->student ? $assessment->student->firstname . ' ' . $assessment->student->lastname : '',
            $assessment->question_id,
            $assessment->question ? $assessment->question->course_code : '',
            $assessment->question ? $assessment->question->session : '',
            $assessment->question ? $assessment->question->level : '',
            $assessment->question ? $assessment->question->semester : '',
            $assessment->score . '/' . $assessment->question->max_total,
            $assessment->status,
            $assessment->created_at->format('Y-m-d H:i:s'),
            $assessment->updated_at->format('Y-m-d H:i:s')
        ];
    }
} 