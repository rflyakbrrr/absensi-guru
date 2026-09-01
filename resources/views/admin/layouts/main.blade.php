<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-mi-tarbiyah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-mi-tarbiyah.png') }}">
    <title>{{ $title ?? 'Dashboard Admin' }} — MI TARBIYAH ISLAMIYAH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .toast-enter { animation: slideInRight 0.3s ease-out; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>
</head>
<body class="h-full bg-slate-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-full">

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen" x-cloak style="display: none;" class="relative z-50 lg:hidden">
            <div x-show="sidebarOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 @click="sidebarOpen = false"></div>
            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen"
                     class="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out"
                     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @include('admin.partials.sidebar')
                </div>
            </div>
        </div>

        {{-- Desktop sidebar --}}
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            @include('admin.partials.sidebar')
        </div>

        {{-- Main content area --}}
        <div class="lg:pl-72">
            {{-- Top bar --}}
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/80 backdrop-blur-xl px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-slate-700 lg:hidden" @click="sidebarOpen = true">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="h-6 w-px bg-slate-200 lg:hidden"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6 justify-end items-center">
                    <div class="flex items-center gap-x-4">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Administrator</span>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-rose-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Page content --}}
            <main class="py-8">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{-- Success toast --}}
                    @if(session('success'))
                        <div class="toast-enter mb-6 flex items-center gap-3 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 shadow-sm"
                             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="toast-enter mb-6 flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-800 shadow-sm"
                             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

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
                requestAnimationFrame(() => {
                    el.classList.remove('-translate-y-full');
                    el.classList.add('translate-y-0');
                });
            }
            function hideBanner(el) {
                el.classList.remove('translate-y-0');
                el.classList.add('-translate-y-full');
                setTimeout(() => el.style.display = 'none', 300);
            }

            window.addEventListener('offline', function() {
                wasOffline = true;
                hideBanner(onlineBanner);
                showBanner(offlineBanner);
            });

            window.addEventListener('online', function() {
                hideBanner(offlineBanner);
                if (wasOffline) {
                    showBanner(onlineBanner);
                    setTimeout(() => hideBanner(onlineBanner), 4000);
                    wasOffline = false;
                }
            });

            // Check on load
            if (!navigator.onLine) {
                wasOffline = true;
                showBanner(offlineBanner);
            }
        })();
    </script>
</body>
</html>