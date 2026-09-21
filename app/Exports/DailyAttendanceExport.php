<?php

namespace App\Exports;

use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
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

class DailyAttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $date;
    protected $status;
    protected $search;
    protected $rowNumber = 0;

    public function __construct($date, $status = null, $search = null)
    {
        $this->date = Carbon::parse($date);
        $this->status = $status;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Attendance::with('teacher')->whereDate('date', $this->date);

        if ($this->status) {
            $query->where('status', $this->status);
        }
        if ($this->search) {
            $query->whereHas('teacher', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
        }

        return $query->orderBy('check_in', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Guru',
            'Jabatan',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
            'Jarak (m)',
            'Keterangan',
        ];
    }

    public function map($attendance): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $attendance->teacher->name ?? '-',
            $attendance->teacher->position ?? '-',
            $attendance->check_in ?? '-',
            $attendance->check_out ?? '-',
            $attendance->status,
            $attendance->distance ? round($attendance->distance) . ' m' : '-',
            $attendance->notes ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 25,
            'D' => 12,
            'E' => 12,
            'F' => 12,
            'G' => 12,
            'H' => 20,
        ];
    }

    public function title(): string
    {
        return 'Rekap Harian ' . $this->date->format('d-m-Y');
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
                $sheet->setCellValue('A1', 'REKAP ABSENSI HARIAN');
                $sheet->setCellValue('A2', 'Tanggal: ' . $this->date->translatedFormat('l, d F Y'));
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
                    $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("D4:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // 5. Create Native Excel Table (Row 3 is header, 4..lastRow is data)
                if ($lastRow >= 4) {
                    $table = new Table();
                    $table->setName('TableDaily');
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
