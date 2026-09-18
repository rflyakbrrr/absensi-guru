<?php

use App\Exports\DailyAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

try {
    $date = Carbon::today()->format('Y-m-d');
    Excel::store(new DailyAttendanceExport($date), 'test-export.xlsx', 'local');
    echo "Success!\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
