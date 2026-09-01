<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Dashboard Presensi Guru</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan statistik kehadiran & aktivitas presensi hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 text-xs font-semibold shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- 4 Key Metric Cards (Requirement 9) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Guru -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all duration-200 border-l-4 border-l-sky-500">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">TOTAL GURU</span>
                    <span class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalTeachers }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Hadir Hari Ini -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all duration-200 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">HADIR HARI INI</span>
                    <span class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $hadir }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Terlambat -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all duration-200 border-l-4 border-l-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">TERLAMBAT</span>
                    <span class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $terlambat }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Tidak Hadir / Alpa -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all duration-200 border-l-4 border-l-rose-500">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">TIDAK HADIR</span>
                    <span class="text-3xl font-extrabold text-rose-600 tracking-tight">{{ $alpa }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section (Requirement 9) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Chart 1: Donut Chart Status Hari Ini -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 mb-4">Persentase Kehadiran Hari Ini</h2>
            <div class="relative flex items-center justify-center h-64">
                <canvas id="todayStatusChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Bar Chart Tren Mingguan -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 mb-4">Statistik Kehadiran 7 Hari Terakhir</h2>
            <div class="relative h-64">
                <canvas id="weeklyTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800">Aktivitas Presensi Terbaru Hari Ini</h2>
            <a href="{{ route('admin.attendances.today') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700">Lihat Semua &rarr;</a>
        </div>
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-3.5 px-6">Nama Guru</th>
                    <th class="py-3.5 px-6">Jam Masuk</th>
                    <th class="py-3.5 px-6">Jam Pulang</th>
                    <th class="py-3.5 px-6">Status</th>
                    <th class="py-3.5 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($recentAttendances as $att)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3.5 px-6 font-semibold text-slate-800">{{ $att->teacher->name ?? '-' }}</td>
                        <td class="py-3.5 px-6 font-mono text-slate-600">{{ $att->check_in ? substr($att->check_in, 0, 5) : '-' }}</td>
                        <td class="py-3.5 px-6 font-mono text-slate-600">{{ $att->check_out ? substr($att->check_out, 0, 5) : '-' }}</td>
                        <td class="py-3.5 px-6">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold
                                {{ $att->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                {{ $att->status === 'Terlambat' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                {{ $att->status === 'Pulang' ? 'bg-sky-50 text-sky-700 border border-sky-100' : '' }}
                                {{ $att->status === 'Izin' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                {{ $att->status === 'Sakit' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                {{ $att->status === 'Alpa' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                                {{ $att->status_emoji }} {{ $att->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-right">
                            <a href="{{ route('admin.attendances.show', $att) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-700">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada aktivitas presensi masuk hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Donut Chart Today Status
            const ctxToday = document.getElementById('todayStatusChart').getContext('2d');
            new Chart(ctxToday, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Belum Absen'],
                    datasets: [{
                        data: [{{ $hadir }}, {{ $terlambat }}, {{ $izin }}, {{ $sakit }}, {{ $alpa }}],
                        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#8b5cf6', '#f43f5e'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { family: 'Inter', size: 11 } } }
                    },
                    cutout: '70%'
                }
            });

            // Bar Chart Weekly Trends
            const weeklyData = @json($weeklyStats);
            const ctxWeekly = document.getElementById('weeklyTrendsChart').getContext('2d');
            new Chart(ctxWeekly, {
                type: 'bar',
                data: {
                    labels: weeklyData.map(d => d.date + ' (' + d.day + ')'),
                    datasets: [
                        {
                            label: 'Hadir',
                            data: weeklyData.map(d => d.hadir),
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                        },
                        {
                            label: 'Terlambat',
                            data: weeklyData.map(d => d.terlambat),
                            backgroundColor: '#f59e0b',
                            borderRadius: 6,
                        },
                        {
                            label: 'Tidak Hadir',
                            data: weeklyData.map(d => d.absent),
                            backgroundColor: '#f43f5e',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { boxWidth: 12, font: { family: 'Inter', size: 11 } } }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { stepSize: 5 } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>