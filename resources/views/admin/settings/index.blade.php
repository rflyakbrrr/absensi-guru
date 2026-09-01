<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Sistem & Sekolah</h1>
            <p class="text-sm text-slate-500 mt-1">Konfigurasi profil sekolah, koordinat GPS, radius, serta jadwal jam absensi.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8 max-w-4xl">
        @csrf

        <!-- Profil Sekolah Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <span>🏫</span> Profil Sekolah & Lokasi GPS
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="school_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Sekolah</label>
                    <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $setting->school_name) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div class="md:col-span-2">
                    <label for="school_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap Sekolah</label>
                    <input type="text" name="school_address" id="school_address" value="{{ old('school_address', $setting->school_address) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20"
                           placeholder="Contoh: Jl. Kyai Haji Hasyim Ashari, Benda, Kota Tangerang">
                </div>

                <div>
                    <label for="latitude" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Latitude GPS Sekolah</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $setting->latitude) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="longitude" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Longitude GPS Sekolah</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $setting->longitude) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="radius" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Radius Absensi Diizinkan (Meter)</label>
                    <input type="number" name="radius" id="radius" value="{{ old('radius', $setting->radius) }}" required min="10" max="10000"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                    <p class="text-[11px] text-slate-400 mt-1">Jarak maksimum HP guru dari koordinat sekolah.</p>
                </div>
            </div>
        </div>

        <!-- Jam Absensi Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <span>⏰</span> Jam Jadwal Absensi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="check_in_start" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Mulai Masuk</label>
                    <input type="time" name="check_in_start" id="check_in_start" value="{{ old('check_in_start', $setting->check_in_start) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="check_in_end" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Batas Akhir Masuk</label>
                    <input type="time" name="check_in_end" id="check_in_end" value="{{ old('check_in_end', $setting->check_in_end) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="late_after" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dianggap Terlambat Setelah</label>
                    <input type="time" name="late_after" id="late_after" value="{{ old('late_after', $setting->late_after) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="check_out_start" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Mulai Pulang</label>
                    <input type="time" name="check_out_start" id="check_out_start" value="{{ old('check_out_start', $setting->check_out_start) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>

                <div>
                    <label for="check_out_end" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Batas Akhir Pulang</label>
                    <input type="time" name="check_out_end" id="check_out_end" value="{{ old('check_out_end', $setting->check_out_end) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                </div>
            </div>
        </div>

        <!-- Keamanan & Fitur Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <span>🛡️</span> Keamanan & Fitur Absensi
            </h2>

            <div class="space-y-4">
                <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-200 cursor-pointer">
                    <input type="checkbox" name="gps_enabled" value="1" {{ $setting->gps_enabled ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-slate-300 text-sky-500 focus:ring-sky-400">
                    <div>
                        <span class="block text-sm font-bold text-slate-800">Aktifkan Validasi GPS / Lokasi</span>
                        <span class="text-xs text-slate-500">Mewajibkan HP guru berada dalam radius sekolah saat absensi.</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-200 cursor-pointer">
                    <input type="checkbox" name="qr_active" value="1" {{ $setting->qr_active ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-slate-300 text-sky-500 focus:ring-sky-400">
                    <div>
                        <span class="block text-sm font-bold text-slate-800">Sistem QR Code Absensi Aktif</span>
                        <span class="text-xs text-slate-500">Jika dinonaktifkan, halaman absensi publik tidak dapat diakses guru.</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 bg-rose-50 rounded-2xl border border-rose-200 cursor-pointer transition-colors hover:bg-rose-100">
                    <input type="checkbox" name="maintenance_mode" value="1" {{ $setting->maintenance_mode ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-rose-300 text-rose-500 focus:ring-rose-400">
                    <div>
                        <span class="block text-sm font-bold text-rose-700">Mode Maintenance (Pemeliharaan)</span>
                        <span class="text-xs text-rose-600/80">Jika aktif, sistem akan menampilkan halaman offline untuk publik. Admin tetap bisa login.</span>
                    </div>
                </label>
            </div>
        </div>

        <button type="submit"
                class="w-full py-4 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-sm rounded-2xl shadow-xl shadow-sky-500/20 transition-all duration-200">
            Simpan Seluruh Pengaturan
        </button>
    </form>
</x-admin-layout>
