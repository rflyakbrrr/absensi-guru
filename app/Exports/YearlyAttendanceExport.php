<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Teacher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class YearlyAttendanceExport implements WithMultipleSheets
{
    protected $year;

    public function __construct($year)
    {
        $this->year = (int) $year;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Summary per month
        $sheets[] = new YearlyAttendanceSummarySheet($this->year);

        // Sheet 2: Detail per teacher
        $sheets[] = new YearlyAttendanceDetailSheet($this->year);

        return $sheets;
    }
}
