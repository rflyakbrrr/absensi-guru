<x-admin-layout>
    <x-slot name="title">Rekap Bulanan</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">REKAP ABSENSI BULANAN</h1>
            <p class="text-sm text-slate-500 mt-1">Laporan akumulasi kehadiran bulanan per guru untuk bulan {{ $month->translatedFormat('F Y') }}.</p>
        </div>
        <a href="{{ route('admin.export.monthly', ['month' => $month->format('Y-m')]) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export Excel
        </a>
    </div>

    <!-- Month Filter -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <form action="{{ route('admin.rekap.monthly') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-60">
                <label for="month" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Bulan & Tahun</label>
                <input type="month" name="month" id="month" value="{{ $month->format('Y-m') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-colors">
                Tampilkan Rekap
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-6">Nama Guru</th>
                    <th class="py-4 px-4 text-center">🟢 Hadir</th>
                    <th class="py-4 px-4 text-center">🟡 Terlambat</th>
                    <th class="py-4 px-4 text-center">🔵 Izin</th>
                    <th class="py-4 px-4 text-center">🟣 Sakit</th>
                    <th class="py-4 px-4 text-center">🔴 Alpa</th>
                    <th class="py-4 px-6 text-center">Total Absen</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($summary as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-4 px-6 font-semibold text-slate-800">
                            <a href="{{ route('admin.rekap.monthly.detail', ['teacher' => $row['teacher']->id, 'month' => $month->format('Y-m')]) }}"
                               class="text-sky-600 hover:text-sky-700 hover:underline">
                                {{ $row['teacher']->name }}
                            </a>
                            <span class="block text-xs text-slate-400 font-normal">{{ $row['teacher']->position }}</span>
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-emerald-600">{{ $row['hadir'] }}</td>
                        <td class="py-4 px-4 text-center font-bold text-amber-600">{{ $row['terlambat'] }}</td>
                        <td class="py-4 px-4 text-center font-bold text-blue-600">{{ $row['izin'] }}</td>
                        <td class="py-4 px-4 text-center font-bold text-purple-600">{{ $row['sakit'] }}</td>
                        <td class="py-4 px-4 text-center font-bold text-rose-600">{{ $row['alpa'] }}</td>
                        <td class="py-4 px-6 text-center font-extrabold text-slate-800">{{ $row['total'] }}</td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.rekap.monthly.detail', ['teacher' => $row['teacher']->id, 'month' => $month->format('Y-m')]) }}"
                               class="px-3 py-1.5 bg-slate-50 hover:bg-sky-50 text-slate-600 hover:text-sky-600 border border-slate-200 hover:border-sky-200 rounded-lg text-xs font-semibold">
                                Detail Harian
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">Tidak ada data guru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
