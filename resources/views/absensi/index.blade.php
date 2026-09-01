<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi Guru — MI TARBIYAH ISLAMIYAH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
        [x-cloak] { display: none !important; }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(56, 189, 248, 0.2); }
            50% { box-shadow: 0 0 35px rgba(56, 189, 248, 0.4); }
        }
        .glow-box { animation: pulseGlow 4s infinite ease-in-out; }
    </style>
</head>
<body class="min-h-screen text-slate-100 flex items-center justify-center p-4">

    <div x-data="absensiApp()" class="w-full max-w-md my-auto">

        <!-- Main Form Card -->
        <div x-show="step === 'form'" x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-slate-800/90 backdrop-blur-2xl rounded-3xl border border-slate-700/60 shadow-2xl p-6 sm:p-8">

            <!-- School Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-sky-500/20">
                    <img src="{{ asset('images/logo-mi-tarbiyah.png') }}" alt="Logo" class="w-12 h-12 object-contain" onerror="this.style.display='none'">
                </div>
                <h1 class="text-lg font-extrabold text-white tracking-tight uppercase">MI TARBIYAH ISLAMIYAH</h1>
                <p class="text-xs text-sky-400 font-semibold tracking-wider uppercase mt-0.5">Sistem Presensi Guru</p>
                <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-slate-900/60 rounded-full border border-slate-700 text-xs font-mono text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span x-text="currentTime"></span>
                </div>
            </div>

            <!-- Error Banner -->
            <div x-show="errorMessage" x-cloak class="mb-5 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-300 text-xs leading-relaxed font-medium">
                <div class="flex items-start gap-2.5">
                    <span class="text-base shrink-0">⚠️</span>
                    <div class="whitespace-pre-line" x-text="errorMessage"></div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitAbsensi" class="space-y-5">
                <!-- Choose Attendance Type (Masuk / Pulang) -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Jenis Presensi</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="type = 'check_in'"
                                :class="type === 'check_in' ? 'bg-sky-500 text-white border-sky-400 shadow-lg shadow-sky-500/20' : 'bg-slate-900/60 text-slate-400 border-slate-700 hover:text-slate-200'"
                                class="py-3 px-4 rounded-2xl border text-xs font-bold transition-all duration-200 flex items-center justify-center gap-2">
                            <span>☀️</span> Presensi Masuk
                        </button>
                        <button type="button" @click="type = 'check_out'"
                                :class="type === 'check_out' ? 'bg-indigo-500 text-white border-indigo-400 shadow-lg shadow-indigo-500/20' : 'bg-slate-900/60 text-slate-400 border-slate-700 hover:text-slate-200'"
                                class="py-3 px-4 rounded-2xl border text-xs font-bold transition-all duration-200 flex items-center justify-center gap-2">
                            <span>🏠</span> Presensi Pulang
                        </button>
                    </div>
                </div>

                <!-- Select Teacher -->
                <div>
                    <label for="teacher_id" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Pilih Nama Anda</label>
                    <select id="teacher_id" x-model="selectedTeacherId" required
                            class="w-full px-4 py-3.5 bg-slate-900/80 border border-slate-700 rounded-2xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200">
                        <option value="" disabled>-- Pilih Nama Guru --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->position }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- GPS Location Status Box -->
                <div class="p-4 bg-slate-900/60 rounded-2xl border border-slate-700/60">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span class="text-xs font-semibold text-slate-300">Status GPS / Lokasi</span>
                        </div>
                        <span x-text="gpsStatusText"
                              :class="gpsReady ? 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20' : 'text-amber-400 bg-amber-500/10 border-amber-500/20'"
                              class="text-[11px] font-bold px-2.5 py-1 rounded-full border"></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        :disabled="loading"
                        class="w-full py-4 bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-extrabold text-sm rounded-2xl shadow-xl shadow-sky-500/20 hover:shadow-sky-500/35 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    ABSEN SEKARANG
                </button>
            </form>
        </div>

        <!-- Processing Step -->
        <div x-show="step === 'processing'" x-cloak
             class="bg-slate-800/90 backdrop-blur-2xl rounded-3xl border border-slate-700/60 shadow-2xl p-8 text-center">
            <div class="w-16 h-16 rounded-full border-4 border-sky-400 border-t-transparent animate-spin mx-auto mb-6"></div>
            <h2 class="text-lg font-bold text-white mb-4">Memproses Absensi...</h2>
            <div class="space-y-3 text-left max-w-xs mx-auto text-xs text-slate-300">
                <div class="flex items-center gap-2" :class="processStep >= 1 ? 'text-emerald-400 font-semibold' : 'text-slate-500'">
                    <span x-text="processStep >= 1 ? '✓' : '○'"></span> Memeriksa lokasi GPS
                </div>
                <div class="flex items-center gap-2" :class="processStep >= 2 ? 'text-emerald-400 font-semibold' : 'text-slate-500'">
                    <span x-text="processStep >= 2 ? '✓' : '○'"></span> Memeriksa waktu & jadwal
                </div>
                <div class="flex items-center gap-2" :class="processStep >= 3 ? 'text-emerald-400 font-semibold' : 'text-slate-500'">
                    <span x-text="processStep >= 3 ? '✓' : '○'"></span> Menyimpan data absensi
                </div>
            </div>
        </div>

        <!-- Success Step -->
        <div x-show="step === 'success'" x-cloak
             class="bg-slate-800/90 backdrop-blur-2xl rounded-3xl border border-emerald-500/40 shadow-2xl p-8 text-center glow-box">
            <div class="w-20 h-20 bg-emerald-500/20 border-2 border-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl animate-bounce">
                🎉
            </div>
            <h2 class="text-xl font-black text-emerald-400 tracking-tight mb-1" x-text="successData.title"></h2>
            <p class="text-xs text-slate-400">Selamat datang & selamat bertugas!</p>

            <div class="my-6 p-4 bg-slate-900/80 rounded-2xl border border-slate-700/60 text-left space-y-2 text-xs">
                <div class="flex justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Nama Guru:</span>
                    <span class="font-bold text-white" x-text="successData.teacher_name"></span>
                </div>
                <div class="flex justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Waktu:</span>
                    <span class="font-mono font-bold text-sky-400" x-text="successData.time"></span>
                </div>
                <div class="flex justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Status:</span>
                    <span class="font-extrabold uppercase px-2 py-0.5 rounded text-[11px]"
                          :class="successData.status === 'Hadir' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-amber-500/20 text-amber-300 border border-amber-500/40'"
                          x-text="successData.status"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Lokasi:</span>
                    <span class="font-semibold text-emerald-400">Valid ✓</span>
                </div>
            </div>

            <button @click="resetForm()"
                    class="w-full py-3.5 bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs rounded-xl transition-all duration-200">
                Kembali ke Halaman Absensi
            </button>
        </div>

    </div>

    <script>
        function absensiApp() {
            return {
                step: 'form', // 'form', 'processing', 'success'
                type: 'check_in',
                selectedTeacherId: '',
                latitude: null,
                longitude: null,
                accuracy: null,
                gpsReady: false,
                gpsStatusText: 'Meminta lokasi...',
                loading: false,
                processStep: 0,
                errorMessage: '',
                currentTime: '',
                successData: {},

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.requestGPS();
                },

                updateClock() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                },

                requestGPS() {
                    if (!navigator.geolocation) {
                        this.gpsStatusText = 'GPS tidak didukung';
                        this.errorMessage = '❌ GPS tidak didukung di browser HP Anda.';
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.latitude = position.coords.latitude;
                            this.longitude = position.coords.longitude;
                            this.accuracy = position.coords.accuracy;
                            this.gpsReady = true;
                            this.gpsStatusText = 'Lokasi Terdeteksi ✓';
                        },
                        (error) => {
                            this.gpsReady = false;
                            this.gpsStatusText = 'GPS Belum Aktif';
                            this.errorMessage = '❌ GPS belum diaktifkan.\nSilakan aktifkan lokasi/GPS pada HP Anda lalu muat ulang halaman.';
                        },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                },

                async submitAbsensi() {
                    if (!this.selectedTeacherId) {
                        this.errorMessage = '❌ Silakan pilih nama Anda terlebih dahulu.';
                        return;
                    }

                    this.errorMessage = '';
                    this.step = 'processing';
                    this.processStep = 1;

                    await new Promise(r => setTimeout(r, 600));
                    this.processStep = 2;

                    await new Promise(r => setTimeout(r, 600));
                    this.processStep = 3;

                    try {
                        const response = await fetch('{{ route("absensi.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                teacher_id: this.selectedTeacherId,
                                type: this.type,
                                latitude: this.latitude,
                                longitude: this.longitude,
                                accuracy: this.accuracy
                            })
                        });

                        const res = await response.json();

                        if (res.success) {
                            this.successData = {
                                title: res.message,
                                teacher_name: res.data.teacher_name,
                                time: res.data.time,
                                status: res.data.status,
                            };
                            this.step = 'success';
                        } else {
                            this.step = 'form';
                            this.errorMessage = res.message;
                        }
                    } catch (e) {
                        this.step = 'form';
                        this.errorMessage = '❌ Terjadi kesalahan jaringan. Silakan coba lagi.';
                    }
                },

                resetForm() {
                    this.selectedTeacherId = '';
                    this.errorMessage = '';
                    this.step = 'form';
                    this.processStep = 0;
                }
            }
        }
    </script>
</body>
</html>
