<?php

namespace App\Exports;

use App\Models\Assessment;
use App\Models\Question;
use App\Models\Student;

class QuestionAssessmentsExport extends BaseExport
{
    protected $question;

    public function __construct(Question $question = null)
    {
        $this->question = $question;
        parent::__construct();
    }

    protected $headings = [
        'S/N',
        'Course Code',
        'Session',
        'Level',
        'Student ID',
        'Student Name',
        'Score',
        'Max Score',
        'Percentage',
        'Strictness Level',
        'Status',
        'AI Analysis',
        'Areas to Improve',
        'Uploaded Files',
        'Created Date'
    ];

    /**
     * Get the data to be exported
     */
    protected function getData()
    {
        if ($this->question) {
            return Assessment::with(['question', 'uploads'])
                ->where('question_id', $this->question->id)
                ->get();
        }
        
        return collect();
    }

    /**
     * Map a single row of data
     */
    protected function mapRow($assessment): array
    {
        $response = json_decode($assessment->response, true);
        $studentId = $response['student_id'] ?? 'AI Could not Determine Student ID';
        $analysis = $response['your analysis of the student\'s answer'] ?? '';
        $improvements = $response['area to improve on'] ?? '';
        
        $student = null;
        if ($studentId && $studentId !== 'AI Could not Determine Student ID') {
            $student = Student::where('student_id', $studentId)->first();
        }
        
        $studentName = $student ? $student->full_name : 'Not Found';
        $uploadedFiles = $assessment->uploads->pluck('url')->implode(', ');
        
        return [
            $this->getRowNumber($assessment),
            $assessment->question->course_code,
            $assessment->question->session,
            $assessment->question->level,
            $studentId,
            $studentName,
            $assessment->score ?? 0,
            $assessment->question->max_total,
            $assessment->percentage ?? 0,
            $assessment->question->difficulty,
            $assessment->status,
            $analysis,
            $improvements,
            $uploadedFiles,
            $assessment->created_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Override the collection method to handle the row numbering
     */
    public function collection()
    {
        $assessments = $this->data ?? $this->getData();
        $exportData = collect();
        
        foreach ($assessments as $index => $assessment) {
            $exportData->push([
                'assessment' => $assessment,
                'rowNumber' => $index + 1
            ]);
        }
        
        return $exportData;
    }

    /**
     * Override the map method to handle the row numbering
     */
    public function map($row): array
    {
        $assessment = $row['assessment'];
        $response = json_decode($assessment->response, true);
        $studentId = $response['student_id'] ?? 'AI Could not Determine Student ID';
        $analysis = $response['your analysis of the student\'s answer'] ?? '';
        $improvements = $response['area to improve on'] ?? '';
        
        $student = null;
        if ($studentId && $studentId !== 'AI Could not Determine Student ID') {
            $student = Student::where('student_id', $studentId)->first();
        }
        
        $studentName = $student ? $student->full_name : 'Not Found';
        $uploadedFiles = $assessment->uploads->pluck('url')->implode(', ');
        
        return [
            $row['rowNumber'],
            $assessment->question->course_code,
            $assessment->question->session,
            $assessment->question->level,
            $studentId,
            $studentName,
            $assessment->score ?? 0,
            $assessment->question->max_total,
            $assessment->percentage ?? 0,
            $assessment->question->difficulty,
            $assessment->status,
            $analysis,
            $improvements,
            $uploadedFiles,
            $assessment->created_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Get row number for the assessment
     */
    private function getRowNumber($assessment): int
    {
        static $rowNumber = 1;
        return $rowNumber++;
    }

    /**
     * Set the question for the export
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
        return $this;
    }
} 