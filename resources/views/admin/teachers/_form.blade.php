<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8 space-y-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Informasi Lengkap Guru</h2>
        <p class="text-sm text-slate-500 mt-1">Lengkapi data pribadi dan jabatan profesional guru di bawah ini.</p>
    </div>

    <div class="grid grid-cols-1 gap-y-6">
        <!-- Nama Lengkap -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Guru</label>
            <input type="text" name="name" id="name" value="{{ old('name', $teacher->name ?? '') }}" required
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200"
                   placeholder="Masukkan nama lengkap beserta gelar (contoh: Siti Mudrikah, S.Pd)">
            @error('name') 
                <p class="mt-2 text-xs text-rose-500 font-semibold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- NIP / NUPTK -->
        <div>
            <label for="nip" class="block text-sm font-semibold text-slate-700 mb-2">NIP / NUPTK <span class="text-slate-400 font-normal">(Opsional)</span></label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip ?? '') }}"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200"
                   placeholder="Masukkan Nomor Induk Pegawai (contoh: 198212102009122003)">
            @error('nip') 
                <p class="mt-2 text-xs text-rose-500 font-semibold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Jabatan -->
        <div>
            <label for="position" class="block text-sm font-semibold text-slate-700 mb-2">Jabatan / Peran</label>
            <input type="text" name="position" id="position" value="{{ old('position', $teacher->position ?? '') }}" required
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200"
                   placeholder="Masukkan jabatan guru (contoh: Guru Kelas III, Guru PJOK, Kepala Sekolah)">
            @error('position') 
                <p class="mt-2 text-xs text-rose-500 font-semibold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status Keaktifan</label>
            <select name="status" id="status"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200">
                <option value="1" {{ old('status', $teacher->status ?? true) == 1 ? 'selected' : '' }}>Aktif (Dapat melakukan absensi)</option>
                <option value="0" {{ old('status', $teacher->status ?? true) == 0 ? 'selected' : '' }}>Nonaktif (Tidak dapat melakukan absensi)</option>
            </select>
            @error('status') 
                <p class="mt-2 text-xs text-rose-500 font-semibold flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <a href="{{ route('admin.teachers.index') }}"
       class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors duration-200">
        Batal
    </a>
    <button type="submit"
            class="px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm rounded-xl shadow-lg shadow-sky-500/10 hover:shadow-sky-500/25 transition-all duration-200">
        Simpan Perubahan
    </button>
</div>