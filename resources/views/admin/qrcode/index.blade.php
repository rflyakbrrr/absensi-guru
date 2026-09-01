<x-admin-layout>
    <x-slot name="title">QR Code Absensi</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">QR Code Absensi Permanen</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola QR Code permanen untuk absensi guru MI Tarbiyah Islamiyah.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.qrcode.print') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
                </svg>
                Cetak Poster QR
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @if(isset($isLocalhost) && $isLocalhost)
        <div class="lg:col-span-3 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-xl shadow-sm mb-2">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-amber-800">Peringatan Akses Lokal (localhost)</h3>
                    <div class="mt-2 text-sm text-amber-700">
                        <p>
                            Anda mengakses halaman ini melalui alamat <code>localhost</code> atau <code>127.0.0.1</code>. 
                            QR Code yang dihasilkan akan mengarah ke perangkat ini, sehingga tidak dapat di-scan dari HP atau perangkat lain.<br>
                            <strong>Solusi:</strong> Silakan akses aplikasi ini menggunakan alamat IP komputer Anda pada jaringan Wi-Fi/LAN (misalnya: <code>http://192.168.1.x/</code>).
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- QR Display Card -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex flex-col items-center text-center">
            <!-- Status Badge -->
            <div class="mb-4">
                @if($setting->qr_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Status QR: AKTIF
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Status QR: NONAKTIF
                    </span>
                @endif
            </div>

            <!-- QR Container -->
            <div class="p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl mb-6 relative group flex justify-center items-center">
                <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                    {!! $qrCodeSvg !!}
                </div>

                @if(!$setting->qr_active)
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs rounded-3xl flex flex-col items-center justify-center text-white p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-rose-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-200">QR Nonaktif</span>
                    </div>
                @endif
            </div>

            <!-- QR URL -->
            <div class="w-full bg-slate-50 rounded-xl p-3 border border-slate-200 mb-6">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Target URL Absensi</span>
                <a href="{{ $qrUrl }}" target="_blank" class="text-xs font-mono font-semibold text-sky-600 hover:text-sky-700 break-all">
                    {{ $qrUrl }}
                </a>
            </div>

            <!-- Download Button -->
            <a href="{{ route('admin.qrcode.print') }}" target="_blank"
               class="w-full py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm rounded-xl shadow-lg shadow-sky-500/20 transition-all duration-200 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
                </svg>
                Buka Halaman Cetak Poster
            </a>
        </div>

        <!-- Controls & Information Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Information Box -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-slate-800 mb-2">Sistem QR Code Permanen</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Sistem ini menggunakan 1 QR Code yang dipasang di area sekolah (misalnya papan pengumuman/gerbang). Guru hanya perlu menembak/scan QR Code tersebut menggunakan smartphone tanpa perlu login.
                </p>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-sky-50/50 rounded-xl border border-sky-100">
                        <span class="block text-xs font-bold text-sky-800 mb-1">🎯 Tanpa Akun Guru</span>
                        <span class="text-xs text-sky-600 leading-relaxed">Guru memilih nama sendiri dari daftar yang aktif saat scan QR.</span>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <span class="block text-xs font-bold text-emerald-800 mb-1">📍 Keamanan GPS & Radius</span>
                        <span class="text-xs text-emerald-600 leading-relaxed">Absensi hanya berhasil bila lokasi HP guru berada dalam radius sekolah.</span>
                    </div>
                </div>
            </div>

            <!-- Action Controls -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-6">
                <h2 class="text-base font-bold text-slate-800">Tindakan Keamanan Admin</h2>

                <!-- Toggle Active -->
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">
                            {{ $setting->qr_active ? 'Nonaktifkan QR Code' : 'Aktifkan QR Code' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $setting->qr_active ? 'Gunakan ini jika terjadi penyalahgunaan atau diluar jam absensi.' : 'Aktifkan kembali agar guru dapat melakukan absensi.' }}
                        </p>
                    </div>
                    <form action="{{ route('admin.qrcode.toggle') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200
                                       {{ $setting->qr_active ? 'bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200' }}">
                            {{ $setting->qr_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>

                <!-- Regenerate QR -->
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Regenerate Token QR</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Memperbarui token QR untuk menyegarkan URL jika perlu.
                        </p>
                    </div>
                    <form action="{{ route('admin.qrcode.regenerate') }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin memperbarui Token QR Code?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl text-xs font-semibold transition-all duration-200">
                            Regenerate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
