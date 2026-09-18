<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Teacher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

class YearlyAttendanceDetailSheet implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function array(): array
    {
        $teachers = Teacher::orderBy('name')->get();
        $rows = [];
        $no = 0;

        foreach ($teachers as $teacher) {
            $no++;
            $attendances = Attendance::where('teacher_id', $teacher->id)
                ->whereYear('date', $this->year)
                ->get();

            $rows[] = [
                $no,
                $teacher->name,
                $teacher->position,
                $attendances->where('status', 'Hadir')->count(),
                $attendances->where('status', 'Terlambat')->count(),
                $attendances->where('status', 'Izin')->count(),
                $attendances->where('status', 'Sakit')->count(),
                $attendances->where('status', 'Alpa')->count(),
                $attendances->count(),
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['No', 'Nama Guru', 'Jabatan', 'Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa', 'Total'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 25,
            'D' => 10,
            'E' => 12,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
        ];
    }

    public function title(): string
    {
        return 'Detail Per Guru ' . $this->year;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                // Borders
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D1D5DB'],
                        ],
                    ],
                ]);

                // Create Native Excel Table
                $newLastRow = $lastRow + 2; // offset by inserted rows
                if ($newLastRow > 3) {
                    $table = new Table();
                    $table->setName('TableYearlyDetail');
                    $table->setRange("A3:{$lastCol}{$newLastRow}");
                    $tableStyle = new TableStyle();
                    $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM4);
                    $tableStyle->setShowRowStripes(true);
                    $table->setStyle($tableStyle);
                    $sheet->addTable($table);
                }

                // Center number columns
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D2:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Title rows
                $sheet->insertNewRowBefore(1, 2);
                $sheet->setCellValue('A1', 'DETAIL ABSENSI TAHUNAN PER GURU');
                $sheet->setCellValue('A2', 'Tahun: ' . $this->year);
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '059669']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['size' => 11, 'color' => ['rgb' => '64748B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->freezePane('A4');
            },
        ];
    }
}
