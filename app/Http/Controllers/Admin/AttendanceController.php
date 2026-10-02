<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Exports\DailyAttendanceExport;
use App\Exports\MonthlyAttendanceExport;
use App\Exports\YearlyAttendanceExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function today(Request $request)
    {
        $today = Carbon::today();
        $query = Attendance::with('teacher')->whereDate('date', $today);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('teacher', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $attendances = $query->orderBy('check_in', 'desc')->paginate(20)->withQueryString();
        $teachers = Teacher::active()->count();
        $todayCount = Attendance::whereDate('date', $today)->count();

        return view('admin.attendances.today', [
            'title' => 'Absensi Hari Ini',
            'attendances' => $attendances,
            'totalTeachers' => $teachers,
            'todayCount' => $todayCount,
            'date' => $today,
        ]);
    }

    public function createManual(Request $request)
    {
        $teachers = Teacher::active()->orderBy('name')->get();
        return view('admin.attendances.create-manual', [
            'title' => 'Input Absensi Manual',
            'teachers' => $teachers,
            'defaultDate' => $request->date ?? Carbon::today()->format('Y-m-d'),
        ]);
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if attendance already exists for this date
        $exists = Attendance::where('teacher_id', $request->teacher_id)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data absensi untuk guru ini pada tanggal tersebut sudah ada! Silakan edit data yang sudah ada.');
        }

        Attendance::create([
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes,
            // Automatically set time for Hadir/Terlambat to avoid nulls if needed, or leave null for manual entry
            'check_in' => in_array($request->status, ['Hadir', 'Terlambat']) ? '07:00:00' : null,
            'check_out' => in_array($request->status, ['Hadir', 'Terlambat']) ? '15:00:00' : null,
        ]);

        return back()->with('success', 'Data absensi manual berhasil ditambahkan!');
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('teacher');
        return view('admin.attendances.show', [
            'title' => 'Detail Absensi',
            'attendance' => $attendance,
        ]);
    }

    public function daily(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : Carbon::today();

        $query = Attendance::with('teacher')->whereDate('date', $date);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('teacher', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $attendances = $query->orderBy('check_in', 'asc')->paginate(20)->withQueryString();

        return view('admin.attendances.daily', [
            'title' => 'Rekap Harian',
            'attendances' => $attendances,
            'date' => $date,
        ]);
    }

    public function monthly(Request $request)
    {
        $month = $request->filled('month') ? Carbon::parse($request->month . '-01') : Carbon::now()->startOfMonth();

        $teachers = Teacher::orderBy('name')->get();
        $summary = [];

        foreach ($teachers as $teacher) {
            $attendances = Attendance::where('teacher_id', $teacher->id)
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->get();

            $summary[] = [
                'teacher' => $teacher,
                'hadir' => $attendances->where('status', 'Hadir')->count(),
                'terlambat' => $attendances->where('status', 'Terlambat')->count(),
                'izin' => $attendances->where('status', 'Izin')->count(),
                'sakit' => $attendances->where('status', 'Sakit')->count(),
                'alpa' => $attendances->where('status', 'Alpa')->count(),
                'total' => $attendances->count(),
            ];
        }

        return view('admin.attendances.monthly', [
            'title' => 'Rekap Bulanan',
            'summary' => $summary,
            'month' => $month,
        ]);
    }

    public function monthlyDetail(Teacher $teacher, Request $request)
    {
        $month = $request->filled('month') ? Carbon::parse($request->month . '-01') : Carbon::now()->startOfMonth();

        $attendances = Attendance::where('teacher_id', $teacher->id)
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->orderBy('date')
            ->get();

        return view('admin.attendances.monthly-detail', [
            'title' => 'Detail Rekap ' . $teacher->name,
            'teacher' => $teacher,
            'attendances' => $attendances,
            'month' => $month,
        ]);
    }

    public function yearly(Request $request)
    {
        $year = $request->filled('year') ? (int) $request->year : Carbon::now()->year;
        $monthlyStats = [];

        for ($m = 1; $m <= 12; $m++) {
            $attendances = Attendance::whereYear('date', $year)
                ->whereMonth('date', $m)
                ->get();

            $monthlyStats[] = [
                'month' => Carbon::create($year, $m, 1)->translatedFormat('F'),
                'month_num' => $m,
                'hadir' => $attendances->where('status', 'Hadir')->count(),
                'terlambat' => $attendances->where('status', 'Terlambat')->count(),
                'izin' => $attendances->where('status', 'Izin')->count(),
                'sakit' => $attendances->where('status', 'Sakit')->count(),
                'alpa' => $attendances->where('status', 'Alpa')->count(),
                'total' => $attendances->count(),
            ];
        }

        return view('admin.attendances.yearly', [
            'title' => 'Rekap Tahunan',
            'monthlyStats' => $monthlyStats,
            'year' => $year,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Terlambat,Pulang,Izin,Sakit,Alpa',
            'notes' => 'nullable|string|max:500',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Status absensi berhasil diperbarui.');
    }

    public function exportDaily(Request $request)
    {
        $date = $request->filled('date') ? $request->date : Carbon::today()->format('Y-m-d');
        $filename = 'Rekap-Harian-' . $date . '.xlsx';

        if (ob_get_length() > 0) { ob_end_clean(); }

        return Excel::download(
            new DailyAttendanceExport($date, $request->status, $request->search),
            $filename,
            \Maatwebsite\Excel\Excel::XLSX,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function exportMonthly(Request $request)
    {
        $month = $request->filled('month') ? $request->month : Carbon::now()->format('Y-m');
        $filename = 'Rekap-Bulanan-' . $month . '.xlsx';

        if (ob_get_length() > 0) { ob_end_clean(); }

        return Excel::download(
            new MonthlyAttendanceExport($month),
            $filename,
            \Maatwebsite\Excel\Excel::XLSX,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function exportYearly(Request $request)
    {
        $year = $request->filled('year') ? $request->year : Carbon::now()->year;
        $filename = 'Rekap-Tahunan-' . $year . '.xlsx';

        if (ob_get_length() > 0) { ob_end_clean(); }

        return Excel::download(
            new YearlyAttendanceExport($year),
            $filename,
            \Maatwebsite\Excel\Excel::XLSX,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}

