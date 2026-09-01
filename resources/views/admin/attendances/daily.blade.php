<x-admin-layout>
    <x-slot name="title">Rekap Harian</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">REKAP ABSENSI HARIAN</h1>
            <p class="text-sm text-slate-500 mt-1">Laporan harian kehadiran seluruh guru.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <form action="{{ route('admin.rekap.daily') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-60">
                <label for="date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ $date->format('Y-m-d') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400">
            </div>

            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Cari Nama Guru</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400"
                       placeholder="Cari guru...">
            </div>

            <div class="w-full md:w-48">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Attendance::statuses() as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-colors">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-6">Nama Guru</th>
                    <th class="py-4 px-6">Jam Masuk</th>
                    <th class="py-4 px-6">Jam Pulang</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($attendances as $att)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-4 px-6 font-semibold text-slate-800">{{ $att->teacher->name ?? '-' }}</td>
                        <td class="py-4 px-6 font-mono text-slate-600">{{ $att->check_in ?? '-' }}</td>
                        <td class="py-4 px-6 font-mono text-slate-600">{{ $att->check_out ?? '-' }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                                {{ $att->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                {{ $att->status === 'Terlambat' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                {{ $att->status === 'Izin' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                {{ $att->status === 'Sakit' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                {{ $att->status === 'Alpa' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                                {{ $att->status_emoji }} {{ $att->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.attendances.show', $att) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-700">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">Tidak ada rekap absensi untuk tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $attendances->links() }}
    </div>
</x-admin-layout>
