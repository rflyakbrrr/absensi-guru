<?php

namespace App\Exports;

use App\Models\Attendance;
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

class YearlyAttendanceSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function array(): array
    {
        $rows = [];

        for ($m = 1; $m <= 12; $m++) {
            $attendances = Attendance::whereYear('date', $this->year)
                ->whereMonth('date', $m)
                ->get();

            $rows[] = [
                Carbon::create($this->year, $m, 1)->translatedFormat('F'),
                $attendances->where('status', 'Hadir')->count(),
                $attendances->where('status', 'Terlambat')->count(),
                $attendances->where('status', 'Izin')->count(),
                $attendances->where('status', 'Sakit')->count(),
                $attendances->where('status', 'Alpa')->count(),
                $attendances->count(),
            ];
        }

        // Total row
        $allAttendances = Attendance::whereYear('date', $this->year)->get();
        $rows[] = [
            'TOTAL',
            $allAttendances->where('status', 'Hadir')->count(),
            $allAttendances->where('status', 'Terlambat')->count(),
            $allAttendances->where('status', 'Izin')->count(),
            $allAttendances->where('status', 'Sakit')->count(),
            $allAttendances->where('status', 'Alpa')->count(),
            $allAttendances->count(),
        ];

        return $rows;
    }

    public function headings(): array
    {
        return ['Bulan', 'Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa', 'Total'];
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
            'A' => 18,
            'B' => 10,
            'C' => 12,
            'D' => 10,
            'E' => 10,
            'F' => 10,
            'G' => 10,
        ];
    }

    public function title(): string
    {
        return 'Ringkasan ' . $this->year;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Insert 2 title rows at the top first
                $sheet->insertNewRowBefore(1, 2);

                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                // 2. Add title rows content and style
                $sheet->setCellValue('A1', 'REKAP ABSENSI TAHUNAN');
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

                // 3. Add borders to header & data table (Row 3 to lastRow)
                $sheet->getStyle("A3:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D1D5DB'],
                        ],
                    ],
                ]);

                // 4. Center data columns (Row 4 to lastRow)
                if ($lastRow >= 4) {
                    $sheet->getStyle("B4:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Bold total row
                    $sheet->getStyle("A{$lastRow}:G{$lastRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 11],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
                    ]);
                }

                // 5. Create Native Excel Table (Row 3 is header, 4..lastRow is data)
                if ($lastRow >= 4) {
                    $table = new Table();
                    $table->setName('TableYearlySummary');
                    $table->setRange("A3:{$lastCol}{$lastRow}");
                    $tableStyle = new TableStyle();
                    $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM4);
                    $tableStyle->setShowRowStripes(true);
                    $table->setStyle($tableStyle);
                    $sheet->addTable($table);
                }

                // 6. Freeze header row (Row 3)
                $sheet->freezePane('A4');
            },
        ];
    }
}
