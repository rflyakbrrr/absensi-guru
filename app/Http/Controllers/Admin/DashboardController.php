<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Teacher;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $totalTeachers = Teacher::active()->count();
        $todayAttendances = Attendance::whereDate('date', $today)->get();

        $hadir = $todayAttendances->where('status', 'Hadir')->count();
        $terlambat = $todayAttendances->where('status', 'Terlambat')->count();
        $izin = $todayAttendances->where('status', 'Izin')->count();
        $sakit = $todayAttendances->where('status', 'Sakit')->count();
        $alpa = $totalTeachers - $todayAttendances->whereIn('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit'])->count();

        // Weekly stats (last 7 days)
        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayAttendances = Attendance::whereDate('date', $date)->get();
            $weeklyStats[] = [
                'date' => $date->format('d/m'),
                'day' => $date->translatedFormat('D'),
                'hadir' => $dayAttendances->where('status', 'Hadir')->count(),
                'terlambat' => $dayAttendances->where('status', 'Terlambat')->count(),
                'absent' => $totalTeachers - $dayAttendances->whereIn('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit'])->count(),
            ];
        }

        // Recent attendances today
        $recentAttendances = Attendance::with('teacher')
            ->whereDate('date', $today)
            ->orderBy('check_in', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'totalTeachers' => $totalTeachers,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => max(0, $alpa),
            'weeklyStats' => $weeklyStats,
            'recentAttendances' => $recentAttendances,
        ]);
    }
}
