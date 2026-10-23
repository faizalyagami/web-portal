<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UserTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $type;
    protected $headings;
    protected $example;

    public function __construct($type)
    {
        $this->type = $type;

        $this->headings = match ($type) {
            'mahasiswa' => ['name', 'email', 'identifier', 'fakultas', 'program_studi', 'angkatan'],
            'dosen'     => ['name', 'email', 'nik', 'fakultas', 'program_studi', 'jabatan'],
            'staff'     => ['name', 'email', 'nik', 'fakultas', 'jabatan'],
            'admin'     => ['name', 'email', 'identifier', 'jabatan'],
            default     => ['name', 'email', 'identifier', 'fakultas', 'program_studi', 'jabatan'],
        };

        $this->example = match ($type) {
            'mahasiswa' => ['Ahmad Fauzi', 'ahmad.fauzi@student.unisba.ac.id', '10012345', 'Psikologi', 'Psikologi', '2021'],
            'dosen'     => ['Dr. Rina Marlina, M.Psi.', 'rina.marlina@unisba.ac.id', '0412345678', 'Psikologi', 'Psikologi', 'Lektor Kepala'],
            'staff'     => ['Dewi Lestari, S.Kom.', 'dewi.lestari@unisba.ac.id', '3273012345670001', 'Psikologi', 'Staf Akademik'],
            'admin'     => ['Administrator', 'admin@unisba.ac.id', 'ADMIN-001', 'Kepala PSITEK'],
            default     => ['Nama Lengkap', 'email@unisba.ac.id', '12345678', 'Psikologi', 'Psikologi', 'Jabatan'],
        };
    }

    public function array(): array
    {
        return [
            $this->example
        ];
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Style header tabel (baris pertama)
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF6B56A5'], // Warna Purple Fakultas Psikologi
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ]);
    }
}
