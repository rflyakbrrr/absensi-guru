<x-admin-layout>
    <x-slot name="title">Input Absensi Manual</x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Input Absensi Manual</h1>
            <p class="text-sm text-slate-500 mt-1">Tambahkan data absensi (Hadir, Izin, Sakit, Alpa) secara manual untuk guru.</p>
        </div>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.attendances.today') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-semibold">
            ❌ {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-semibold">
            ❌ Terjadi kesalahan pada form. Silakan periksa kembali isian Anda.
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6 max-w-2xl">
        <form action="{{ route('admin.attendances.store-manual') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Guru -->
            <div>
                <label for="teacher_id" class="block text-sm font-bold text-slate-700 mb-2">Nama Guru <span class="text-rose-500">*</span></label>
                <select name="teacher_id" id="teacher_id" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 transition-colors">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} ({{ $teacher->position }})
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div>
                    <label for="date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Absensi <span class="text-rose-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', $defaultDate) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 transition-colors">
                    @error('date')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 transition-colors">
                        <option value="">-- Pilih Status --</option>
                        @foreach(\App\Models\Attendance::statuses() as $st)
                            @if($st !== 'Pulang')
                                <option value="{{ $st }}" {{ old('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label for="notes" class="block text-sm font-bold text-slate-700 mb-2">Catatan Keterangan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 transition-colors"
                          placeholder="Misal: Sakit demam berdarah, atau Alasan Izin...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition-all duration-200 shadow-sm shadow-emerald-600/20 hover:shadow-emerald-600/40">
                    Simpan Absensi Manual
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
