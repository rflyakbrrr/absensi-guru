<x-admin-layout>
    <x-slot name="title">Rekap Tahunan</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">REKAP ABSENSI TAHUNAN</h1>
            <p class="text-sm text-slate-500 mt-1">Statistik kehadiran seluruh guru selama tahun {{ $year }}.</p>
        </div>
        <a href="{{ route('admin.export.yearly', ['year' => $year]) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export Excel
        </a>
    </div>

    <!-- Year Filter -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <form action="{{ route('admin.rekap.yearly') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-48">
                <label for="year" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Tahun</label>
                <select name="year" id="year" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-colors">
                Tampilkan Rekap
            </button>
        </form>
    </div>

    <!-- Monthly Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($monthlyStats as $stat)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-base">{{ $stat['month'] }}</h3>
                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 font-extrabold text-xs rounded-full border border-sky-100">
                        {{ $stat['total'] }} absensi
                    </span>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">🟢 Hadir:</span>
                        <span class="font-bold text-emerald-600">{{ $stat['hadir'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">🟡 Terlambat:</span>
                        <span class="font-bold text-amber-600">{{ $stat['terlambat'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">🔵 Izin:</span>
                        <span class="font-bold text-blue-600">{{ $stat['izin'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">🟣 Sakit:</span>
                        <span class="font-bold text-purple-600">{{ $stat['sakit'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">🔴 Alpa:</span>
                        <span class="font-bold text-rose-600">{{ $stat['alpa'] }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.rekap.monthly', ['month' => $year . '-' . sprintf('%02d', $stat['month_num'])]) }}"
                   class="mt-4 pt-3 border-t border-slate-100 text-center text-xs font-semibold text-sky-600 hover:text-sky-700 block">
                    Lihat Rekap Bulan Ini &rarr;
                </a>
            </div>
        @endforeach
    </div>
</x-admin-layout>
