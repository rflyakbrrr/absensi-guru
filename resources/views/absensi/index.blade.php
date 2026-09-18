<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Presensi Guru MI Tarbiyah Islamiyah - Absensi digital berbasis QR Code & GPS">
    <meta name="theme-color" content="#e6f7f2">
    <title>Presensi Guru — MI TARBIYAH ISLAMIYAH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        
        :root {
            --safe-bottom: env(safe-area-inset-bottom, 0px);
            --safe-top: env(safe-area-inset-top, 0px);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            min-height: 100dvh;
            background: linear-gradient(135deg, #e8f7f2 0%, #d5f0e6 40%, #e0f2fe 100%);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            padding-top: var(--safe-top);
            padding-bottom: var(--safe-bottom);
            position: relative;
        }

        [x-cloak] { display: none !important; }

        /* Background 3D Scene Styling */
        .scene-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        /* 3D School Building Graphic (Left Background) */
        .bg-school-building {
            position: absolute;
            bottom: 60px;
            left: 2%;
            width: 320px;
            height: 220px;
            opacity: 0.85;
            transform: perspective(800px) rotateY(12deg);
        }

        /* 3D Stacked Books (Bottom Left Foreground) */
        .clay-book {
            height: 22px;
            border-radius: 4px 10px 10px 4px;
            box-shadow: 2px 4px 8px rgba(0, 70, 50, 0.2), inset 0 2px 0 rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            padding-left: 16px;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: 1.5px;
            color: #ffffff;
            position: relative;
        }
        .clay-book::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            background: rgba(0,0,0,0.15);
            border-radius: 4px 0 0 4px;
        }

        /* Floating 3D Glass Badges (Right/Left) */
        .floating-3d-tile {
            background: linear-gradient(145deg, rgba(255,255,255,0.7) 0%, rgba(204,251,241,0.5) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1.5px solid rgba(255, 255, 255, 0.9);
            box-shadow: 
                0 20px 35px rgba(6, 78, 59, 0.12),
                inset 0 2px 4px rgba(255, 255, 255, 0.8);
            border-radius: 1.25rem;
            animation: floatSlow 6s ease-in-out infinite;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        /* Central 3D Card Platform (Pedestal) */
        .pedestal-ring-1 {
            width: 440px;
            height: 90px;
            background: linear-gradient(180deg, rgba(167, 243, 208, 0.7) 0%, rgba(52, 211, 153, 0.3) 100%);
            border-radius: 50%;
            box-shadow: 
                0 15px 30px rgba(5, 150, 105, 0.25),
                inset 0 3px 6px rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.6);
        }
        .pedestal-ring-2 {
            width: 360px;
            height: 70px;
            background: linear-gradient(180deg, #34d399 0%, #059669 100%);
            border-radius: 50%;
            box-shadow: 
                0 10px 20px rgba(5, 150, 105, 0.3),
                inset 0 3px 5px rgba(255, 255, 255, 0.6);
        }

        /* 3D Claymorphic Main Card */
        .clay-card-3d {
            background: linear-gradient(165deg, rgba(255, 255, 255, 0.98) 0%, rgba(243, 253, 248, 0.96) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 1);
            border-radius: 2rem; /* Reduced from 2.75rem for wider feel on mobile */
            box-shadow: 
                0 30px 60px -12px rgba(13, 148, 136, 0.22),
                0 18px 36px -18px rgba(15, 23, 42, 0.12),
                inset 0 3px 6px rgba(255, 255, 255, 1),
                inset 0 -4px 8px rgba(16, 185, 129, 0.08);
            position: relative;
        }

        /* 3D Inset Container (Inputs & Segmented Control) */
        .clay-inset-pill {
            background: #edf7f4;
            border: 1.5px solid #d3ebd6;
            border-radius: 1.25rem;
            box-shadow: 
                inset 0 3px 6px rgba(6, 78, 59, 0.08),
                inset 0 -1px 2px rgba(255, 255, 255, 0.8),
                0 2px 4px rgba(255, 255, 255, 0.9);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom 3D Select Input */
        .clay-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10L12 15L17 10' stroke='%23059669' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            background-size: 20px;
        }
        .clay-select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 
                inset 0 2px 4px rgba(6, 78, 59, 0.06),
                0 0 0 4px rgba(16, 185, 129, 0.2);
        }

        /* 3D Segmented Control Buttons */
        .segmented-tray-3d {
            background: #e2f2ed;
            padding: 6px;
            border-radius: 1.25rem;
            box-shadow: 
                inset 0 3px 6px rgba(5, 150, 105, 0.12),
                inset 0 -1px 2px rgba(255, 255, 255, 0.8);
            display: flex;
            gap: 6px;
        }
        .segmented-btn-3d {
            flex: 1;
            padding: 14px 0; /* Increased from 12px */
            font-size: 14px; /* Increased from 13px */
            font-weight: 800;
            letter-spacing: 0.5px;
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #4b6b61;
            border: 1px solid transparent;
            -webkit-tap-highlight-color: transparent;
        }
        .segmented-btn-3d.active-in {
            color: #047857;
            background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
            border-color: #d1fae5;
            box-shadow: 
                0 8px 18px rgba(5, 150, 105, 0.18),
                0 2px 4px rgba(0, 0, 0, 0.04),
                inset 0 2px 0 #ffffff;
            transform: translateY(-2px);
        }
        .segmented-btn-3d.active-out {
            color: #0f766e;
            background: linear-gradient(180deg, #ffffff 0%, #f0fdfa 100%);
            border-color: #ccfbf1;
            box-shadow: 
                0 8px 18px rgba(13, 148, 136, 0.18),
                0 2px 4px rgba(0, 0, 0, 0.04),
                inset 0 2px 0 #ffffff;
            transform: translateY(-2px);
        }

        /* 3D Primary Glossy Button */
        .btn-3d-emerald {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            border-radius: 1.25rem;
            border: 1px solid #34d399;
            box-shadow: 
                0 14px 28px -6px rgba(16, 185, 129, 0.55),
                0 4px 0 #047857,
                inset 0 2px 0 rgba(255, 255, 255, 0.4),
                inset 0 -2px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            -webkit-tap-highlight-color: transparent;
        }
        .btn-3d-emerald:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 
                0 18px 34px -6px rgba(16, 185, 129, 0.65),
                0 6px 0 #047857,
                inset 0 2px 0 rgba(255, 255, 255, 0.5);
        }
        .btn-3d-emerald:active:not(:disabled) {
            transform: translateY(3px);
            box-shadow: 
                0 6px 14px -4px rgba(16, 185, 129, 0.4),
                0 1px 0 #047857,
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-3d-teal {
            background: linear-gradient(180deg, #14b8a6 0%, #0d9488 100%);
            border-radius: 1.25rem;
            border: 1px solid #2dd4bf;
            box-shadow: 
                0 14px 28px -6px rgba(20, 184, 166, 0.55),
                0 4px 0 #0f766e,
                inset 0 2px 0 rgba(255, 255, 255, 0.4),
                inset 0 -2px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            -webkit-tap-highlight-color: transparent;
        }
        .btn-3d-teal:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 
                0 18px 34px -6px rgba(20, 184, 166, 0.65),
                0 6px 0 #0f766e,
                inset 0 2px 0 rgba(255, 255, 255, 0.5);
        }
        .btn-3d-teal:active:not(:disabled) {
            transform: translateY(3px);
            box-shadow: 
                0 6px 14px -4px rgba(20, 184, 166, 0.4),
                0 1px 0 #0f766e,
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
        }

        /* 3D Logo Badge */
        .logo-tile-3d {
            width: 72px;
            height: 72px;
            background: linear-gradient(145deg, #a7f3d0 0%, #34d399 50%, #059669 100%);
            border-radius: 1.5rem;
            border: 3px solid #ffffff;
            box-shadow: 
                0 12px 24px rgba(5, 150, 105, 0.3),
                inset 0 3px 6px rgba(255, 255, 255, 0.8),
                inset 0 -3px 6px rgba(4, 120, 87, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Status Dot */
        .status-dot-3d {
            position: relative;
            width: 10px; height: 10px;
        }
        .status-dot-3d::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: currentColor;
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
            opacity: 0.5;
        }
        .status-dot-3d::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 8px currentColor;
        }

        .spinner {
            border: 4px solid rgba(16, 185, 129, 0.15);
            border-top-color: #10b981;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        @keyframes successPop {
            0% { transform: scale(0.7) rotate(-5deg); opacity: 0; }
            60% { transform: scale(1.08) rotate(2deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .animate-success-pop {
            animation: successPop 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-3 py-6 sm:p-6 lg:p-8">

    {{-- ==================== 3D ENVIRONMENT SCENE BACKGROUND ==================== --}}
    <div class="scene-bg">
        {{-- Left: 3D School Building Graphic --}}
        <div class="hidden lg:block bg-school-building">
            <svg viewBox="0 0 280 180" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full filter drop-shadow-xl">
                <!-- Flagpole -->
                <rect x="50" y="20" width="3" height="120" fill="#94a3b8" />
                <!-- Flag -->
                <path d="M53 22H80V38H53V22Z" fill="#ef4444" />
                <path d="M53 38H80V54H53V38Z" fill="#ffffff" />
                <!-- Building Main Body -->
                <path d="M30 110 L140 70 L250 110 V170 H30 Z" fill="#ffffff" />
                <!-- Roof Green -->
                <path d="M20 110 L140 60 L260 110 L250 118 L140 72 L30 118 Z" fill="#059669" />
                <!-- Columns -->
                <rect x="60" y="125" width="12" height="45" rx="3" fill="#10b981" />
                <rect x="100" y="125" width="12" height="45" rx="3" fill="#10b981" />
                <rect x="160" y="125" width="12" height="45" rx="3" fill="#10b981" />
                <rect x="200" y="125" width="12" height="45" rx="3" fill="#10b981" />
                <!-- Sign Header -->
                <rect x="70" y="95" width="140" height="22" rx="4" fill="#047857" />
                <text x="140" y="110" font-family="'Plus Jakarta Sans', sans-serif" font-size="10" font-weight="900" fill="#ffffff" text-anchor="middle">MI TARBIYAH ISLAMIYAH</text>
            </svg>
        </div>

        {{-- Left Bottom: 3D Stacked Books & Pencil Cup --}}
        <div class="hidden md:flex absolute bottom-8 left-10 items-end gap-5">
            <div class="flex flex-col gap-1 w-44 transform -rotate-3">
                <div class="clay-book" style="background: linear-gradient(90deg, #10b981, #34d399);">ILMU</div>
                <div class="clay-book" style="background: linear-gradient(90deg, #059669, #10b981);">AKHLAK</div>
                <div class="clay-book" style="background: linear-gradient(90deg, #047857, #059669);">PRESTASI</div>
            </div>
            <!-- Pencil Cup -->
            <div class="w-14 h-20 bg-gradient-to-b from-white to-emerald-50 rounded-b-2xl rounded-t-lg border-2 border-white shadow-lg flex flex-col items-center justify-start pt-2 relative">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center border border-emerald-300">
                    <span class="text-[9px] font-black text-emerald-700">MI</span>
                </div>
                <!-- 3D Pencils -->
                <div class="absolute -top-6 left-3 w-2 h-10 bg-emerald-600 rounded-t-sm transform -rotate-12"></div>
                <div class="absolute -top-7 left-7 w-2 h-11 bg-teal-500 rounded-t-sm transform rotate-6"></div>
                <div class="absolute -top-5 left-10 w-2 h-9 bg-emerald-700 rounded-t-sm transform rotate-12"></div>
            </div>
        </div>

        {{-- Right Top: Floating 3D Tiles & Quote --}}
        <div class="hidden lg:block absolute top-16 right-16 text-right max-w-xs">
            <p class="text-xs font-extrabold text-emerald-800 uppercase tracking-widest leading-relaxed">
                Disiplin Hari Ini<br/>
                <span class="text-emerald-600 font-medium">Untuk Masa Depan</span><br/>
                <span class="text-teal-700 font-black text-sm">Yang Lebih Baik</span>
            </p>
            <div class="w-24 h-1 bg-emerald-400 rounded-full ml-auto mt-2 opacity-80"></div>
        </div>

        <div class="hidden md:block absolute top-28 right-24 floating-3d-tile p-4" style="animation-delay: 0s;">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
            </div>
        </div>

        <div class="hidden md:block absolute top-60 right-12 floating-3d-tile p-3.5" style="animation-delay: 2s;">
            <div class="w-9 h-9 rounded-xl bg-teal-400 text-white flex items-center justify-center shadow-lg shadow-teal-400/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856a9.375 9.375 0 0113.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.001.001-.002.001a.75.75 0 01-1.056 0l-.002-.001-.001-.001a.75.75 0 010-1.056l.001-.001.002-.001a.75.75 0 011.056 0l.002.001.001.001a.75.75 0 010 1.056z" />
                </svg>
            </div>
        </div>

        {{-- Right Bottom: 3D Digital Desk Clock --}}
        <div class="hidden md:flex absolute bottom-10 right-16 items-end gap-3">
            <div class="bg-gradient-to-br from-emerald-800 to-teal-900 text-emerald-300 font-mono font-black text-xl px-5 py-3 rounded-2xl border-2 border-emerald-500/40 shadow-xl flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>15:48</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 border-2 border-white shadow-md"></div>
        </div>
    </div>


    {{-- ==================== MAIN APP CONTAINER ==================== --}}
    <div x-data="absensiApp()" class="w-full max-w-md relative z-10 my-auto">

        {{-- Pedestal Reflection Platform --}}
        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center pointer-events-none opacity-90 scale-95 sm:scale-100">
            <div class="pedestal-ring-1"></div>
            <div class="pedestal-ring-2 -mt-16"></div>
        </div>

        {{-- ==================== FORM STEP ==================== --}}
        <div x-show="step === 'form'"
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="clay-card-3d px-5 py-8 sm:px-9 sm:py-10 flex flex-col justify-start relative overflow-hidden">

            <div class="flex-1 flex flex-col justify-start w-full">
                
                {{-- Header & 3D Logo --}}
                <div class="text-center mb-7 flex flex-col items-center">
                    <div class="logo-tile-3d mb-4 transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/logo-mi-tarbiyah.png') }}" alt="Logo" class="w-12 h-12 object-contain filter drop-shadow-md"
                             onerror="this.outerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'w-10 h-10 text-white filter drop-shadow\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\' stroke-width=\'2\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5h-15V21\' /></svg>'">
                    </div>

                    <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-tight">
                        Sistem Presensi
                    </h1>
                    <p class="text-[11px] font-extrabold text-emerald-600 tracking-widest uppercase mt-1">MI TARBIYAH ISLAMIYAH</p>

                    {{-- 3D Clock Pill --}}
                    <div class="mt-5 inline-flex items-center gap-2.5 px-4 py-2 bg-[#e5f4ef] border border-[#d2eadf] rounded-full shadow-inner">
                        <div class="status-dot-3d text-emerald-500"></div>
                        <span x-text="currentDate" class="text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span x-text="currentTime" class="text-sm font-black font-mono text-emerald-950 tracking-widest"></span>
                    </div>
                </div>

                {{-- Error Alert --}}
                <div x-show="errorMessage" x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mb-6 p-3.5 bg-red-50/90 border border-red-200 rounded-2xl flex items-start gap-3 shadow-inner">
                    <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <p class="text-red-700 text-xs leading-relaxed font-bold whitespace-pre-line pt-0.5" x-text="errorMessage"></p>
                </div>

                {{-- Form Content --}}
                <form @submit.prevent="submitAbsensi" class="flex flex-col gap-6 w-full">
                    
                    {{-- 1. Select Identitas --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            PILIH IDENTITAS
                        </label>
                        <div class="relative">
                            <select id="teacher_id" x-model="selectedTeacherId" required
                                    class="clay-inset-pill clay-select w-full px-5 py-4 text-slate-800 text-base font-bold">
                                <option value="" disabled class="text-slate-400">Siapa nama Anda?</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. Tipe Presensi (Segmented Control) --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-[11px] font-extrabold text-emerald-800 uppercase tracking-wider ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            TIPE PRESENSI
                        </label>
                        <div class="segmented-tray-3d">
                            <button type="button" @click="type = 'check_in'"
                                    :class="type === 'check_in' ? 'active-in' : ''"
                                    class="segmented-btn-3d">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                MASUK
                            </button>
                            <button type="button" @click="type = 'check_out'"
                                    :class="type === 'check_out' ? 'active-out' : ''"
                                    class="segmented-btn-3d">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                PULANG
                            </button>
                        </div>
                    </div>

                    {{-- 3. GPS Status Pill --}}
                    <div>
                        <div class="clay-inset-pill px-4 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                                     :class="gpsReady ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-white'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-800 tracking-wide">Status Lokasi</p>
                                    <p class="text-[10px] font-bold mt-0.5" 
                                       :class="gpsReady ? 'text-emerald-600' : 'text-amber-600'" 
                                       x-text="gpsReady ? 'Akurasi GPS Terverifikasi' : 'Mencari sinyal GPS...'"></p>
                                </div>
                            </div>
                            <div class="status-dot-3d" :class="gpsReady ? 'text-emerald-500' : 'text-amber-500'"></div>
                        </div>
                    </div>

                    {{-- 4. Action Button --}}
                    <div class="mt-4">
                        <button type="submit"
                                :disabled="loading"
                                :class="type === 'check_out' ? 'btn-3d-teal' : 'btn-3d-emerald'"
                                class="w-full py-4 px-6 text-white font-black text-base tracking-wider flex items-center justify-center gap-2.5 disabled:opacity-50 h-[60px]">
                            <span x-show="!loading" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="type === 'check_in' ? 'CATAT KEHADIRAN' : 'CATAT KEPULANGAN'"></span>
                            </span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                MEMPROSES...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 pt-4 text-center border-t border-emerald-100/60 w-full">
                <p class="text-[10px] text-emerald-800 font-extrabold uppercase tracking-widest opacity-70">
                    &copy; {{ date('Y') }} HAK CIPTA DILINDUNGI
                </p>
            </div>
        </div>

        {{-- ==================== PROCESSING STEP ==================== --}}
        <div x-show="step === 'processing'" x-cloak
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="clay-card-3d px-6 py-12 sm:px-10 sm:py-16 text-center flex flex-col justify-center items-center">
            
            <div class="relative w-24 h-24 mx-auto mb-6">
                <div class="absolute inset-0 spinner"></div>
                <div class="absolute inset-2 spinner" style="animation-direction: reverse; border-top-color: #34d399; animation-duration: 1.2s;"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                             x-show="type === 'check_in'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                             x-show="type === 'check_out'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-black text-slate-800 mb-1">Memproses Absensi</h2>
            <p class="text-xs font-extrabold text-emerald-600 uppercase tracking-wider mb-8">Mohon tunggu sebentar...</p>

            <div class="space-y-3.5 w-full max-w-xs mx-auto">
                <template x-for="(label, idx) in ['Memeriksa koordinat GPS', 'Memvalidasi waktu & jadwal', 'Menyimpan data absensi']" :key="idx">
                    <div class="flex items-center gap-3.5 p-3.5 rounded-2xl transition-all duration-500 border"
                         :class="processStep > idx ? 'bg-emerald-100/70 border-emerald-300 shadow-sm' : (processStep === idx ? 'bg-white border-emerald-400 shadow-md' : 'bg-slate-50/50 border-slate-200/60')">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-500"
                             :class="processStep > idx ? 'bg-emerald-500 text-white' : (processStep === idx ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-400')">
                            <template x-if="processStep > idx">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </template>
                            <template x-if="processStep === idx">
                                <div class="w-3.5 h-3.5 spinner border-2 border-emerald-200 border-t-emerald-600"></div>
                            </template>
                            <template x-if="processStep < idx">
                                <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                            </template>
                        </div>
                        <span class="text-xs font-bold tracking-wide text-left"
                              :class="processStep > idx ? 'text-emerald-900 font-black' : (processStep === idx ? 'text-slate-900 font-extrabold' : 'text-slate-400')"
                              x-text="label"></span>
                    </div>
                </template>
            </div>
        </div>

        {{-- ==================== SUCCESS STEP ==================== --}}
        <div x-show="step === 'success'" x-cloak
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             class="clay-card-3d px-6 py-10 sm:px-10 sm:py-14 text-center flex flex-col justify-center items-center">

            <div class="w-full max-w-xs mx-auto">
                {{-- 3D Success Icon --}}
                <div class="w-20 h-20 mx-auto mb-5 relative animate-success-pop">
                    <div class="relative w-20 h-20 rounded-3xl bg-gradient-to-tr from-emerald-500 to-emerald-400 shadow-xl shadow-emerald-500/40 flex items-center justify-center border-4 border-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white filter drop-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-1" x-text="successData.title"></h2>
                <p class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest mb-6" x-text="type === 'check_in' ? 'Selamat bertugas!' : 'Terima kasih untuk hari ini!'"></p>

                {{-- Detail Inset Box --}}
                <div class="mb-8 clay-inset-pill p-5 text-left relative overflow-hidden">
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Nama Guru</p>
                            <p class="text-sm font-black text-slate-800 truncate" x-text="successData.teacher_name"></p>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Waktu</p>
                                <p class="text-sm font-black font-mono text-emerald-700" x-text="successData.time"></p>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Status</p>
                                <span class="inline-flex text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-lg border shadow-sm"
                                      :class="successData.status === 'Hadir' ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : (successData.status === 'Pulang' ? 'bg-teal-100 text-teal-800 border-teal-300' : 'bg-amber-100 text-amber-800 border-amber-300')"
                                      x-text="successData.status"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Back Button --}}
                <button @click="resetForm()"
                        class="w-full py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-extrabold text-xs rounded-2xl transition-all duration-200 border-2 border-slate-200 shadow-md active:translate-y-0.5 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    KEMBALI KE BERANDA
                </button>
            </div>
        </div>

    </div>

    <script>
        function absensiApp() {
            return {
                step: 'form',
                type: 'check_in',
                selectedTeacherId: '',
                latitude: null,
                longitude: null,
                accuracy: null,
                gpsReady: false,
                gpsStatusText: 'Meminta...',
                loading: false,
                processStep: 0,
                errorMessage: '',
                currentTime: '',
                currentDate: '',
                successData: {},

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.requestGPS();
                },

                updateClock() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
                },

                requestGPS() {
                    if (!navigator.geolocation) {
                        this.gpsStatusText = 'Tidak Didukung';
                        this.errorMessage = 'GPS tidak didukung di browser Anda. Gunakan Chrome atau Safari.';
                        return;
                    }
                    this.gpsStatusText = 'Meminta...';
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            this.latitude = pos.coords.latitude;
                            this.longitude = pos.coords.longitude;
                            this.accuracy = pos.coords.accuracy;
                            this.gpsReady = true;
                            this.gpsStatusText = 'Terdeteksi ✓';
                        },
                        () => {
                            this.gpsReady = false;
                            this.gpsStatusText = 'Belum Aktif';
                            this.errorMessage = '📍 GPS belum aktif.\nAktifkan lokasi di perangkat Anda, lalu refresh halaman ini.';
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                },

                async submitAbsensi() {
                    if (!this.selectedTeacherId) {
                        this.errorMessage = 'Silakan pilih identitas Anda terlebih dahulu.';
                        return;
                    }
                    this.errorMessage = '';
                    this.loading = true;
                    
                    await new Promise(r => setTimeout(r, 400));
                    
                    this.step = 'processing';
                    this.processStep = 0;

                    await new Promise(r => setTimeout(r, 600));
                    this.processStep = 1;
                    await new Promise(r => setTimeout(r, 700));
                    this.processStep = 2;

                    try {
                        const res = await fetch('/absensi/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                teacher_id: this.selectedTeacherId,
                                type: this.type,
                                latitude: this.latitude ? String(this.latitude) : null,
                                longitude: this.longitude ? String(this.longitude) : null,
                                accuracy: this.accuracy ? String(this.accuracy) : null
                            })
                        });

                        await new Promise(r => setTimeout(r, 500));
                        this.processStep = 3;
                        await new Promise(r => setTimeout(r, 600));

                        const data = await res.json();
                        if (data.success) {
                            this.successData = {
                                title: data.message,
                                teacher_name: data.data.teacher_name,
                                time: data.data.time,
                                status: data.data.status,
                            };
                            this.step = 'success';
                        } else {
                            this.step = 'form';
                            this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Terjadi kesalahan sistem.');
                        }
                    } catch (e) {
                        this.step = 'form';
                        this.errorMessage = 'Kesalahan jaringan: ' + e.message;
                    } finally {
                        this.loading = false;
                    }
                },

                resetForm() {
                    this.selectedTeacherId = '';
                    this.errorMessage = '';
                    this.step = 'form';
                    this.processStep = 0;
                    this.loading = false;
                }
            }
        }
    </script>
</body>
</html>

