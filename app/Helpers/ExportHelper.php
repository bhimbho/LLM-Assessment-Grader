<?php

namespace App\Helpers;

class ExportHelper
{
    public static function generateFilename(string $prefix, array $parts = [], string $suffix = ''): string
    {
        $filename = $prefix;
        
        if (!empty($parts)) {
            $filename .= '_' . implode('_', array_filter($parts));
        }
        
        if (!empty($suffix)) {
            $filename .= '_' . $suffix;
        }
        
        $filename .= '_' . date('Y-m-d_H-i-s');
        
        return self::sanitizeFilename($filename);
    }

    public static function sanitizeFilename(string $filename): string
    {
        $filename = preg_replace('/[\/\\:*?"<>|]/', '_', $filename);
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = trim($filename, '_');
        
        if (empty($filename)) {
            $filename = 'export';
        }
        
        if (strlen($filename) > 200) {
            $filename = substr($filename, 0, 200);
        }
        
        return $filename;
    }

    public static function studentFilename(string $type = 'students'): string
    {
        return self::generateFilename($type);
    }

    public static function assessmentFilename(string $courseCode, string $session, string $level): string
    {
        return self::generateFilename('assessments', [
            $courseCode,
            $session,
            'level',
            $level
        ]);
    }

    public static function questionAssessmentFilename(string $courseCode, string $session, string $level): string
    {
        return self::generateFilename('question_assessments', [
            $courseCode,
            $session,
            'level',
            $level
        ]);
    }
} 