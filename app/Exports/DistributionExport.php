<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class DistributionExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $distributions;

    public function __construct(Collection $distributions)
    {
        $this->distributions = $distributions;
    }

    public function collection()
    {
        return $this->distributions;
    }

    public function headings(): array
    {
        return [
            'Tanggal Penyaluran',
            'Nama Kegiatan',
            'Program Wakaf',
            'Kategori',
            'Nominal',
            'Dicatat Oleh',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
