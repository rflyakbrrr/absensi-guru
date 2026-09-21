<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;

// Landing page redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman publik absensi guru (diakses via QR Code)
Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('index');
    Route::get('/teachers', [AbsensiController::class, 'getTeachers'])->name('teachers');
    Route::post('/store', [AbsensiController::class, 'store'])->name('store');
});

// Rute khusus Admin yang sudah login
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Guru
    Route::resource('teachers', TeacherController::class);

    // Absensi Hari Ini
    Route::get('/attendances/today', [AttendanceController::class, 'today'])->name('attendances.today');
    Route::get('/attendances/manual/create', [AttendanceController::class, 'createManual'])->name('attendances.create-manual');
    Route::post('/attendances/manual', [AttendanceController::class, 'storeManual'])->name('attendances.store-manual');
    Route::post('/attendances/{id}/status', [AttendanceController::class, 'updateStatus'])->name('attendances.update-status');
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');

    // Rekap
    Route::get('/rekap/daily', [AttendanceController::class, 'daily'])->name('rekap.daily');
    Route::get('/rekap/monthly', [AttendanceController::class, 'monthly'])->name('rekap.monthly');
    Route::get('/rekap/monthly/{teacher}', [AttendanceController::class, 'monthlyDetail'])->name('rekap.monthly.detail');
    Route::get('/rekap/yearly', [AttendanceController::class, 'yearly'])->name('rekap.yearly');

    // Export Laporan
    Route::get('/export/daily', [AttendanceController::class, 'exportDaily'])->name('export.daily');
    Route::get('/export/monthly', [AttendanceController::class, 'exportMonthly'])->name('export.monthly');
    Route::get('/export/yearly', [AttendanceController::class, 'exportYearly'])->name('export.yearly');

    // QR Code
    Route::get('/qrcode', [QrCodeController::class, 'index'])->name('qrcode.index');
    Route::get('/qrcode/print', [QrCodeController::class, 'print'])->name('qrcode.print');
    Route::post('/qrcode/regenerate', [QrCodeController::class, 'regenerate'])->name('qrcode.regenerate');
    Route::post('/qrcode/toggle', [QrCodeController::class, 'toggle'])->name('qrcode.toggle');

    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

});

// Rute Profil Admin
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Override Breeze dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';