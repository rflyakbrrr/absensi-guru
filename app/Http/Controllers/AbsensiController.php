<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Show the attendance page (accessed via QR scan).
     */
    public function index()
    {
        $setting = Setting::first();

        if (!$setting || !$setting->qr_active) {
            return view('absensi.disabled');
        }

        $teachers = Teacher::active()->orderBy('name')->get();

        return view('absensi.index', [
            'setting' => $setting,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Get active teachers list (API for AJAX).
     */
    public function getTeachers()
    {
        $teachers = Teacher::active()->orderBy('name')->get(['id', 'name', 'position']);
        return response()->json($teachers);
    }

    /**
     * Process attendance submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'accuracy' => 'nullable|string',
            'type' => 'required|in:check_in,check_out',
        ]);

        $setting = Setting::first();
        $teacher = Teacher::findOrFail($request->teacher_id);
        $now = Carbon::now();
        $today = $now->toDateString();

        if (!$teacher->status) {
            return response()->json([
                'success' => false,
                'message' => 'Guru ini sedang nonaktif dan tidak dapat melakukan absensi.',
            ], 422);
        }

        // Validate GPS if enabled
        $distance = null;
        if ($setting->gps_enabled) {
            if (!$request->latitude || !$request->longitude) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ GPS belum diaktifkan. Silakan aktifkan lokasi pada HP Anda.',
                ], 422);
            }

            $distance = $this->calculateDistance(
                $request->latitude, $request->longitude,
                $setting->latitude, $setting->longitude
            );

            if ($distance > $setting->radius) {
                return response()->json([
                    'success' => false,
                    'message' => "❌ Anda berada di luar area sekolah.\nJarak Anda: " . round($distance) . " meter.\nRadius yang diizinkan: {$setting->radius} meter.",
                ], 422);
            }
        }

        $existingAttendance = Attendance::where('teacher_id', $teacher->id)
            ->whereDate('date', $today)
            ->first();

        if ($request->type === 'check_in') {
            // Check if already checked in today
            if ($existingAttendance && $existingAttendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Anda sudah melakukan absensi masuk hari ini.',
                ], 422);
            }

            // Check time window
            $checkInStart = Carbon::parse($today . ' ' . $setting->check_in_start);
            $checkInEnd = Carbon::parse($today . ' ' . $setting->check_in_end);
            $lateAfter = Carbon::parse($today . ' ' . $setting->late_after);

            if ($now->lt($checkInStart)) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Absensi belum dapat dilakukan. Jam absensi masuk dimulai pukul ' . $setting->check_in_start,
                ], 422);
            }

            // Determine status
            $status = $now->lte($lateAfter) ? Attendance::STATUS_HADIR : Attendance::STATUS_TERLAMBAT;

            Attendance::create([
                'teacher_id' => $teacher->id,
                'date' => $today,
                'check_in' => $now->toTimeString(),
                'status' => $status,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $request->accuracy,
                'distance' => $distance ? round($distance, 2) : null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '🎉 ABSENSI MASUK BERHASIL',
                'data' => [
                    'teacher_name' => $teacher->name,
                    'time' => $now->format('H:i'),
                    'status' => $status,
                    'distance' => $distance ? round($distance) . ' meter' : '-',
                ],
            ]);

        } else {
            // Check out
            if (!$existingAttendance || !$existingAttendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Anda belum melakukan absensi masuk hari ini.',
                ], 422);
            }

            if ($existingAttendance->check_out) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Anda sudah melakukan absensi pulang hari ini.',
                ], 422);
            }

            $checkOutStart = Carbon::parse($today . ' ' . $setting->check_out_start);

            if ($now->lt($checkOutStart)) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Absensi pulang belum dapat dilakukan. Jam pulang dimulai pukul ' . $setting->check_out_start,
                ], 422);
            }

            $existingAttendance->update([
                'check_out' => $now->toTimeString(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '🎉 ABSENSI PULANG BERHASIL',
                'data' => [
                    'teacher_name' => $teacher->name,
                    'time' => $now->format('H:i'),
                    'status' => 'Pulang',
                    'distance' => $distance ? round($distance) . ' meter' : '-',
                ],
            ]);
        }
    }

    /**
     * Calculate distance between two GPS coordinates in meters (Haversine formula).
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
