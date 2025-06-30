<?php

namespace App\Exports;

use App\Models\Student;

class StudentsExport extends BaseExport
{
    protected $headings = [
        'Student ID',
        'First Name',
        'Last Name',
        'Other Name',
        'Email',
        'Created At',
        'Updated At'
    ];

    /**
     * Get the data to be exported
     */
    protected function getData()
    {
        return Student::orderBy('created_at', 'desc')->get();
    }

    /**
     * Map a single row of data
     */
    protected function mapRow($student): array
    {
        return [
            $student->student_id,
            $student->firstname,
            $student->lastname,
            $student->othername ?? '',
            $student->email,
            $student->created_at->format('Y-m-d H:i:s'),
            $student->updated_at->format('Y-m-d H:i:s')
        ];
    }
} 