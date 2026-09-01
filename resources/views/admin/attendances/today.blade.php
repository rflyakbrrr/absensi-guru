<x-admin-layout>
    <x-slot name="title">Absensi Hari Ini</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Absensi Hari Ini</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar kehadiran guru pada {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-sky-50 border border-sky-100 rounded-xl text-sky-700 text-xs font-semibold">
                Guru Absen: <span class="font-extrabold text-sky-800">{{ $todayCount }} / {{ $totalTeachers }}</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <form action="{{ route('admin.attendances.today') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Cari Nama Guru</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200"
                       placeholder="Cari nama guru...">
            </div>

            <div class="w-full md:w-48">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Attendance::statuses() as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-colors duration-200">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.attendances.today') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors duration-200">Reset</a>
                @endif
            </div>
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
                    <th class="py-4 px-6">Jarak GPS</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($attendances as $att)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-4 px-6 font-semibold text-slate-800">{{ $att->teacher->name ?? '-' }}</td>
                        <td class="py-4 px-6 font-mono text-slate-600 font-medium">{{ $att->check_in ? substr($att->check_in, 0, 5) : '-' }}</td>
                        <td class="py-4 px-6 font-mono text-slate-600 font-medium">{{ $att->check_out ? substr($att->check_out, 0, 5) : '-' }}</td>
                        <td class="py-4 px-6">
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
                        <td class="py-4 px-6 text-slate-500 text-xs font-mono">
                            {{ $att->distance ? $att->distance . ' m' : '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.attendances.show', $att) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 hover:bg-sky-50 text-slate-600 hover:text-sky-600 rounded-lg text-xs font-semibold border border-slate-200 hover:border-sky-200 transition-all duration-200">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            Belum ada data absensi untuk hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $attendances->links() }}
    </div>
</x-admin-layout>
