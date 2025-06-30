<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BaseExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportService
{
    /**
     * Export data to Excel
     */
    public function exportToExcel(BaseExport $export, string $filename, string $format = 'xlsx'): BinaryFileResponse
    {
        return Excel::download($export, $this->sanitizeFilename($filename) . '.' . $format);
    }

    /**
     * Export data to CSV
     */
    public function exportToCsv(BaseExport $export, string $filename): BinaryFileResponse
    {
        return Excel::download($export, $this->sanitizeFilename($filename) . '.csv');
    }

    /**
     * Export data with custom format
     */
    public function export(BaseExport $export, string $filename, string $format = 'xlsx'): BinaryFileResponse
    {
        return Excel::download($export, $this->sanitizeFilename($filename) . '.' . $format);
    }

    /**
     * Store export to disk
     */
    public function store(BaseExport $export, string $filename, string $disk = 'local', string $format = 'xlsx'): bool
    {
        return Excel::store($export, $this->sanitizeFilename($filename) . '.' . $format, $disk);
    }

    /**
     * Export with custom data
     */
    public function exportWithData(BaseExport $export, $data, string $filename, string $format = 'xlsx'): BinaryFileResponse
    {
        $export->setData($data);
        return $this->export($export, $filename, $format);
    }

    /**
     * Export with custom headings
     */
    public function exportWithHeadings(BaseExport $export, array $headings, string $filename, string $format = 'xlsx'): BinaryFileResponse
    {
        $export->setHeadings($headings);
        return $this->export($export, $filename, $format);
    }

    /**
     * Export with custom data and headings
     */
    public function exportWithDataAndHeadings(BaseExport $export, $data, array $headings, string $filename, string $format = 'xlsx'): BinaryFileResponse
    {
        $export->setData($data)->setHeadings($headings);
        return $this->export($export, $filename, $format);
    }

    private function sanitizeFilename(string $filename): string
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
} 