<x-admin-layout>
    <x-slot name="title">Detail Rekap {{ $teacher->name }}</x-slot>

    <div class="max-w-4xl mx-auto mb-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.rekap.monthly', ['month' => $month->format('Y-m')]) }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Rekap Bulanan
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 mb-6">
            <div class="border-b border-slate-100 pb-6 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">{{ $teacher->name }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">NIP: {{ $teacher->nip ?? '-' }} | Jabatan: {{ $teacher->position }}</p>
                </div>
                <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-200 text-xs font-bold text-slate-700">
                    Bulan: {{ $month->translatedFormat('F Y') }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Jam Masuk</th>
                            <th class="py-3 px-4">Jam Pulang</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Jarak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($att->date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $att->check_in ?? '-' }}</td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $att->check_out ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold
                                        {{ $att->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                        {{ $att->status === 'Terlambat' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                        {{ $att->status === 'Izin' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                        {{ $att->status === 'Sakit' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                        {{ $att->status === 'Alpa' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                                        {{ $att->status_emoji }} {{ $att->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-mono text-xs text-slate-500">{{ $att->distance ? $att->distance . ' m' : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                    Tidak ada catatan absensi untuk guru ini di bulan {{ $month->translatedFormat('F Y') }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
