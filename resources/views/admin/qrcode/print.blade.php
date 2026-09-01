<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Absensi — MI TARBIYAH ISLAMIYAH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-card { shadow: none !important; border: 4px solid #0f172a !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-4 sm:p-8">

    <!-- Action Bar -->
    <div class="no-print mb-6 flex gap-4">
        <button onclick="window.print()"
                class="px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm rounded-xl shadow-lg shadow-sky-500/20 transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            Cetak Poster Sekarang
        </button>
        <a href="{{ route('admin.qrcode.index') }}"
           class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl border border-slate-200 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Printable Poster Card -->
    <div class="print-card w-full max-w-xl bg-white rounded-3xl border-4 border-slate-900 shadow-2xl p-8 sm:p-12 text-center flex flex-col items-center">
    
        @if(isset($isLocalhost) && $isLocalhost)
        <div class="no-print w-full bg-amber-50 border-l-4 border-amber-500 p-4 rounded-xl shadow-sm mb-6 text-left">
            <h3 class="text-sm font-bold text-amber-800">Peringatan: URL Localhost</h3>
            <p class="mt-1 text-sm text-amber-700">
                Anda mengakses halaman ini melalui <code>localhost</code>. QR Code ini <strong>TIDAK BISA</strong> di-scan dari HP. Silakan akses web ini menggunakan alamat IP Wi-Fi komputer Anda sebelum mencetak.
            </p>
        </div>
        @endif

        <!-- School Logo & Header -->
        <div class="flex items-center gap-4 mb-6 border-b-2 border-slate-100 pb-6 w-full justify-center">
            <img src="{{ asset('images/logo-mi-tarbiyah.png') }}" alt="Logo MI Tarbiyah"
                 class="w-16 h-16 object-contain"
                 onerror="this.style.display='none'">
            <div class="text-left">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    MI TARBIYAH ISLAMIYAH
                </h1>
                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-widest mt-1">
                    Benda, Kota Tangerang — Banten
                </p>
            </div>
        </div>

        <!-- Title Banner -->
        <div class="w-full bg-slate-900 text-white rounded-2xl py-3 px-6 mb-8 shadow-md">
            <h2 class="text-xl sm:text-2xl font-black tracking-widest uppercase">
                ABSENSI GURU
            </h2>
        </div>

        <!-- QR Code Frame -->
        <div class="p-6 bg-slate-50 rounded-3xl border-4 border-slate-900 mb-8 shadow-inner flex justify-center items-center">
            <div class="bg-white p-2 rounded-xl">
                {!! $qrCodeSvg !!}
            </div>
        </div>

        <!-- Instruction Text -->
        <div class="space-y-3 w-full">
            <p class="text-lg sm:text-xl font-bold text-slate-800 tracking-wide">
                Scan QR untuk melakukan absensi
            </p>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-full text-amber-800 text-xs sm:text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Mohon aktifkan lokasi/GPS pada HP Anda
            </div>
        </div>

        <!-- Footer Notice -->
        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mt-8 border-t border-slate-100 pt-4 w-full">
            Sistem Presensi Guru Berbasis QR Code & GPS &copy; {{ date('Y') }} MI Tarbiyah Islamiyah
        </p>
    </div>

</body>
</html>
