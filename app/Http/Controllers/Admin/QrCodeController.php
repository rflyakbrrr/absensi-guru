<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::instance();
        $qrUrl = route('absensi.index');
        
        $isLocalhost = in_array($request->getHost(), ['localhost', '127.0.0.1']);
        $qrCodeSvg = QrCode::size(260)->generate($qrUrl);

        return view('admin.qrcode.index', [
            'title' => 'QR Code Absensi',
            'setting' => $setting,
            'qrUrl' => $qrUrl,
            'isLocalhost' => $isLocalhost,
            'qrCodeSvg' => $qrCodeSvg,
        ]);
    }

    public function print(Request $request)
    {
        $setting = Setting::instance();
        $qrUrl = route('absensi.index');
        
        $isLocalhost = in_array($request->getHost(), ['localhost', '127.0.0.1']);
        $qrCodeSvg = QrCode::size(320)->generate($qrUrl);

        return view('admin.qrcode.print', [
            'title' => 'Cetak QR Absensi',
            'setting' => $setting,
            'qrUrl' => $qrUrl,
            'isLocalhost' => $isLocalhost,
            'qrCodeSvg' => $qrCodeSvg,
        ]);
    }

    public function regenerate()
    {
        $setting = Setting::instance();
        $setting->update([
            'qr_token' => Str::random(32),
        ]);

        return back()->with('success', 'QR Code berhasil di-regenerate dengan token baru!');
    }

    public function toggle()
    {
        $setting = Setting::instance();
        $newValue = !$setting->qr_active;
        $setting->update([
            'qr_active' => $newValue,
        ]);

        $statusText = $newValue ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Sistem QR Code Absensi berhasil {$statusText}.");
    }
}
