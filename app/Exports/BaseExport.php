<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class BaseExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $headings = [];

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Get the collection that should be exported
     */
    public function collection()
    {
        return $this->data ?? $this->getData();
    }

    /**
     * Get the headings for the export
     */
    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * Map the data for the export
     */
    public function map($row): array
    {
        return $this->mapRow($row);
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }

    /**
     * Get the data to be exported
     */
    abstract protected function getData();

    /**
     * Map a single row of data
     */
    abstract protected function mapRow($row): array;

    /**
     * Set the data for the export
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the headings for the export
     */
    public function setHeadings(array $headings)
    {
        $this->headings = $headings;
        return $this;
    }
} 