<?php

namespace App\Traits;

use App\Services\ExportService;
use App\Exports\BaseExport;

trait HasExport
{
    protected ?ExportService $exportService = null;

    protected function getExportService(): ExportService
    {
        if ($this->exportService === null) {
            $this->exportService = new ExportService();
        }
        return $this->exportService;
    }

    /**
     * Export data using the provided export class
     */
    protected function exportData(BaseExport $export, string $filename, string $format = 'xlsx')
    {
        return $this->getExportService()->export($export, $filename, $format);
    }

    /**
     * Export data to Excel
     */
    protected function exportToExcel(BaseExport $export, string $filename)
    {
        return $this->getExportService()->exportToExcel($export, $filename);
    }

    /**
     * Export data to CSV
     */
    protected function exportToCsv(BaseExport $export, string $filename)
    {
        return $this->getExportService()->exportToCsv($export, $filename);
    }

    /**
     * Export data with custom data
     */
    protected function exportWithData(BaseExport $export, $data, string $filename, string $format = 'xlsx')
    {
        return $this->getExportService()->exportWithData($export, $data, $filename, $format);
    }

    /**
     * Export data with custom headings
     */
    protected function exportWithHeadings(BaseExport $export, array $headings, string $filename, string $format = 'xlsx')
    {
        return $this->getExportService()->exportWithHeadings($export, $headings, $filename, $format);
    }

    /**
     * Export data with custom data and headings
     */
    protected function exportWithDataAndHeadings(BaseExport $export, $data, array $headings, string $filename, string $format = 'xlsx')
    {
        return $this->getExportService()->exportWithDataAndHeadings($export, $data, $headings, $filename, $format);
    }

    /**
     * Store export to disk
     */
    protected function storeExport(BaseExport $export, string $filename, string $disk = 'local', string $format = 'xlsx'): bool
    {
        return $this->getExportService()->store($export, $filename, $disk, $format);
    }
} 