<x-guest-layout>
    <div class="min-h-screen relative flex items-center justify-center px-4 sm:px-6 py-10 overflow-hidden bg-emerald-50/60">

        <!-- Glowing Mesh Background Orbs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full opacity-40 blur-3xl"
                 style="background: radial-gradient(circle, #34d399, #10b981 70%, transparent);"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full opacity-30 blur-3xl"
                 style="background: radial-gradient(circle, #059669, #047857 70%, transparent);"></div>
            <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full opacity-20 blur-2xl"
                 style="background: radial-gradient(circle, #6ee7b7, transparent 70%);"></div>
        </div>

        <!-- Subtle Geometric Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
             style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23047857&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        <!-- Top Badge Bar -->
        <div class="absolute top-6 right-6 z-10 hidden sm:flex items-center gap-2">
            <div class="flex items-center gap-2 bg-white/80 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-semibold text-emerald-800 border border-emerald-100 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                MI TARBIYAH ISLAMIYAH
            </div>
        </div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-md" style="animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl shadow-emerald-900/10 border border-white p-7 sm:p-10">

                <!-- Header & School Logo -->
                <div class="text-center mb-8">
                    <div class="inline-flex p-3 rounded-2xl bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/25 mb-4 transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/logo-mi-tarbiyah.png') }}" alt="Logo MI Tarbiyah"
                             class="w-14 h-14 object-contain rounded-xl bg-white p-1"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-14 h-14 items-center justify-center text-white font-black text-xl hidden">
                            MI
                        </div>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight uppercase">
                        PRESENSI GURU
                    </h1>
                    <p class="text-xs sm:text-sm font-medium text-emerald-700 mt-1">
                        MI Tarbiyah Islamiyah — Benda, Tangerang
                    </p>
                    <div class="h-1 w-12 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full mx-auto mt-3"></div>
                </div>

                <!-- Sub-heading -->
                <div class="mb-6">
                    <h2 class="text-base font-bold text-slate-800">Selamat Datang Kembali! 👋</h2>
                    <p class="text-xs text-slate-500 mt-1">Silakan masuk menggunakan NIP atau Email akun Admin Anda.</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- NIP / Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP / Email</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   class="w-full pl-11 pr-4 py-3 bg-emerald-50/40 border border-slate-200 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white
                                          transition-all duration-200"
                                   placeholder="Masukkan NIP atau Email Anda">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <!-- Password Input -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                                   class="w-full pl-11 pr-11 py-3 bg-emerald-50/40 border border-slate-200 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white
                                          transition-all duration-200"
                                   placeholder="Masukkan kata sandi">
                            <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2 text-slate-600 cursor-pointer select-none font-medium">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0">
                            Ingat Saya
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-emerald-700 hover:text-emerald-800 font-semibold transition-colors" href="{{ route('password.request') }}">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white font-extrabold text-sm
                                   shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0
                                   transition-all duration-200 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25" />
                        </svg>
                        MASUK KE SISTEM
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <p class="text-center text-xs font-medium text-slate-500 mt-6">
                &copy; {{ date('Y') }} Presensi Guru — MI Tarbiyah Islamiyah
            </p>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-guest-layout>