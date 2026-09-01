<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa',
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
        return back()->with('success', 'Fitur export dalam pengembangan.');
    }

    public function exportMonthly(Request $request)
    {
        return back()->with('success', 'Fitur export dalam pengembangan.');
    }

    public function exportYearly(Request $request)
    {
        return back()->with('success', 'Fitur export dalam pengembangan.');
    }
}
