<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::instance();

        return view('admin.settings.index', [
            'title' => 'Pengaturan Sistem',
            'setting' => $setting,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'nullable|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'radius' => 'required|integer|min:10|max:10000',
            'check_in_start' => 'required',
            'check_in_end' => 'required',
            'late_after' => 'required',
            'check_out_start' => 'required',
            'check_out_end' => 'required',
            'selfie_enabled' => 'boolean',
            'gps_enabled' => 'boolean',
            'qr_active' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        $setting = Setting::instance();

        $setting->update([
            'school_name' => $request->school_name,
            'school_address' => $request->school_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'check_in_start' => $request->check_in_start,
            'check_in_end' => $request->check_in_end,
            'late_after' => $request->late_after,
            'check_out_start' => $request->check_out_start,
            'check_out_end' => $request->check_out_end,
            'selfie_enabled' => $request->has('selfie_enabled'),
            'gps_enabled' => $request->has('gps_enabled'),
            'qr_active' => $request->has('qr_active'),
            'maintenance_mode' => $request->has('maintenance_mode'),
        ]);

        return back()->with('success', 'Pengaturan sekolah & absensi berhasil diperbarui!');
    }
}
