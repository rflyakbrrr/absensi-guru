<x-admin-layout>
    <x-slot name="title">Detail Absensi</x-slot>

    <div class="max-w-3xl mx-auto mb-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.attendances.today') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Absensi
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-8">
            <div class="border-b border-slate-100 pb-6 mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">DETAIL ABSENSI</h1>
                    <p class="text-xs text-slate-400 mt-0.5">ID Rekam Absensi: #{{ $attendance->id }}</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider
                    {{ $attendance->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                    {{ $attendance->status === 'Terlambat' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                    {{ $attendance->status === 'Pulang' ? 'bg-sky-50 text-sky-700 border border-sky-100' : '' }}
                    {{ $attendance->status === 'Izin' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                    {{ $attendance->status === 'Sakit' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                    {{ $attendance->status === 'Alpa' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                    {{ $attendance->status_emoji }} {{ $attendance->status }}
                </span>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Guru</span>
                    <span class="font-bold text-slate-800 text-base">{{ $attendance->teacher->name ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal</span>
                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Masuk</span>
                    <span class="font-mono font-semibold text-slate-800">{{ $attendance->check_in ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Pulang</span>
                    <span class="font-mono font-semibold text-slate-800">{{ $attendance->check_out ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Latitude</span>
                    <span class="font-mono text-slate-600">{{ $attendance->latitude ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Longitude</span>
                    <span class="font-mono text-slate-600">{{ $attendance->longitude ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jarak Dari Sekolah</span>
                    <span class="font-semibold text-sky-600">{{ $attendance->distance ? $attendance->distance . ' meter' : '-' }}</span>
                </div>

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">IP Address</span>
                    <span class="font-mono text-slate-600">{{ $attendance->ip_address ?? '-' }}</span>
                </div>

                <div class="sm:col-span-2">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Perangkat / User Agent</span>
                    <span class="text-xs text-slate-600 font-mono bg-slate-50 p-2.5 rounded-xl border border-slate-100 block break-all">
                        {{ $attendance->user_agent ?? '-' }}
                    </span>
                </div>

                @if($attendance->notes)
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan / Keterangan</span>
                        <p class="text-sm text-slate-700 bg-amber-50/50 p-3 rounded-xl border border-amber-100">{{ $attendance->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Manual Edit Status Form for Admin -->
            <div class="mt-8 pt-6 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Ubah Status Manual (Khusus Admin)</h3>
                <form action="{{ route('admin.attendances.update-status', $attendance->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <select name="status" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                        @foreach(\App\Models\Attendance::statuses() as $st)
                            <option value="{{ $st }}" {{ $attendance->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="notes" placeholder="Alasan perubahan (opsional)..." value="{{ $attendance->notes }}"
                           class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20">
                    <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-xs rounded-xl transition-colors">
                        Simpan Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
