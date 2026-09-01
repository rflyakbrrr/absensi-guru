<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/logo-mi-tarbiyah.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-mi-tarbiyah.png') }}">

        <title>{{ config('app.name', 'MITARBIYAH') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{ $slot }}

        <!-- Offline / Online Detection Banner -->
        <div id="offline-banner" style="display:none;"
             class="fixed top-0 left-0 right-0 z-[9999] bg-gradient-to-r from-rose-600 to-rose-500 text-white py-3 px-4 text-center shadow-lg transition-all duration-300 transform -translate-y-full">
            <div class="flex items-center justify-center gap-2 text-sm font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 010 12.728M5.636 5.636a9 9 0 000 12.728M8.464 15.536a5 5 0 010-7.072M15.536 8.464a5 5 0 010 7.072M13 12a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
                <span>⚠️ Koneksi internet terputus — Anda sedang offline</span>
            </div>
        </div>
        <div id="online-banner" style="display:none;"
             class="fixed top-0 left-0 right-0 z-[9999] bg-gradient-to-r from-emerald-600 to-emerald-500 text-white py-3 px-4 text-center shadow-lg transition-all duration-300 transform -translate-y-full">
            <div class="flex items-center justify-center gap-2 text-sm font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>✅ Koneksi internet kembali terhubung!</span>
            </div>
        </div>

        <script>
            (function() {
                const offlineBanner = document.getElementById('offline-banner');
                const onlineBanner = document.getElementById('online-banner');
                let wasOffline = false;
                function showBanner(el) {
                    el.style.display = 'block';
                    requestAnimationFrame(() => { el.classList.remove('-translate-y-full'); el.classList.add('translate-y-0'); });
                }
                function hideBanner(el) {
                    el.classList.remove('translate-y-0'); el.classList.add('-translate-y-full');
                    setTimeout(() => el.style.display = 'none', 300);
                }
                window.addEventListener('offline', function() { wasOffline = true; hideBanner(onlineBanner); showBanner(offlineBanner); });
                window.addEventListener('online', function() {
                    hideBanner(offlineBanner);
                    if (wasOffline) { showBanner(onlineBanner); setTimeout(() => hideBanner(onlineBanner), 4000); wasOffline = false; }
                });
                if (!navigator.onLine) { wasOffline = true; showBanner(offlineBanner); }
            })();
        </script>
    </body>
</html>
