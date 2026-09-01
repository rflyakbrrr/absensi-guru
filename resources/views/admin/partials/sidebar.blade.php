<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 border-r border-slate-800 px-6 pb-4">
    <!-- Header/Brand -->
    <div class="flex h-20 shrink-0 items-center gap-3 border-b border-slate-800/60">
        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-lg shadow-sky-500/10 overflow-hidden">
    <img src="{{ asset('images/logo-mi-tarbiyah.png') }}" alt="Logo MI Tarbiyah" class="w-full h-full object-contain p-1">
</div>
        <div>
            <h1 class="text-white text-sm font-bold tracking-wider leading-none">MI TARBIYAH</h1>
            <span class="text-[10px] text-slate-500 font-semibold tracking-wide uppercase mt-1 block">PRESENSI GURU</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    @php
                        $menus = [
                            [
                                'name' => 'Dashboard',
                                'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
                                'route' => 'admin.dashboard',
                                'active' => 'admin.dashboard'
                            ],
                            [
                                'name' => 'Data Guru',
                                'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
                                'route' => 'admin.teachers.index',
                                'active' => 'admin.teachers.*'
                            ],
                            [
                                'name' => 'Absensi Hari Ini',
                                'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
                                'route' => 'admin.attendances.today',
                                'active' => 'admin.attendances.today'
                            ],
                            [
                                'name' => 'Rekap Harian',
                                'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z',
                                'route' => 'admin.rekap.daily',
                                'active' => 'admin.rekap.daily'
                            ],
                            [
                                'name' => 'Rekap Bulanan',
                                'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
                                'route' => 'admin.rekap.monthly',
                                'active' => 'admin.rekap.monthly*'
                            ],
                            [
                                'name' => 'Rekap Tahunan',
                                'icon' => 'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0h.008v.008h-.008v-.008zm-6.5 0h.008v.008H12v-.008z',
                                'route' => 'admin.rekap.yearly',
                                'active' => 'admin.rekap.yearly*'
                            ],
                            [
                                'name' => 'QR Code',
                                'icon' => 'M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z',
                                'route' => 'admin.qrcode.index',
                                'active' => 'admin.qrcode.*'
                            ],
                            [
                                'name' => 'Pengaturan',
                                'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z',
                                'route' => 'admin.settings.index',
                                'active' => 'admin.settings.*'
                            ],
                        ];
                    @endphp

                    @foreach($menus as $menu)
                        @php
                            $isActive = request()->routeIs($menu['active']);
                        @endphp
                        <li>
                            <a href="{{ route($menu['route']) }}"
                               class="group flex gap-x-3 rounded-xl p-3 text-sm font-medium transition-all duration-200
                                      {{ $isActive
                                         ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/20 font-semibold'
                                         : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                                <svg class="h-5 w-5 shrink-0 transition-colors duration-200
                                            {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-100' }}"
                                     fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}" />
                                </svg>
                                {{ $menu['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>
</div>