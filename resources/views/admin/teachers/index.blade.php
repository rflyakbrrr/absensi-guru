<x-admin-layout>
    <x-slot name="title">Data Guru</x-slot>

    <div x-data="{ deleteModalOpen: false, deleteId: null, deleteName: '' }">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Guru</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data guru dan status keaktifan mereka untuk absensi.</p>
            </div>
            <div>
                <a href="{{ route('admin.teachers.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm rounded-xl shadow-lg shadow-sky-500/20 hover:shadow-sky-500/30 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Guru Baru
                </a>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
            <form action="{{ route('admin.teachers.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200"
                               placeholder="Cari berdasarkan nama atau NIP...">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" id="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-400/20 focus:border-sky-400 focus:bg-white transition-all duration-200">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit"
                            class="flex-1 md:flex-none px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm rounded-xl transition-colors duration-200">
                        Cari
                    </button>
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.teachers.index') }}"
                           class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors duration-200 text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card (Desktop) -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Guru</th>
                        <th class="py-4 px-6">NIP / NUPTK</th>
                        <th class="py-4 px-6">Jabatan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                            <td class="py-4 px-6 font-semibold text-slate-800">{{ $teacher->name }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ $teacher->nip ?? '-' }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ $teacher->position }}</td>
                            <td class="py-4 px-6">
                                @if($teacher->status)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 hover:bg-sky-50 text-slate-600 hover:text-sky-600 rounded-lg text-xs font-semibold border border-slate-200 hover:border-sky-200 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                        Edit
                                    </a>

                                    <button type="button"
                                            @click="deleteModalOpen = true; deleteId = {{ $teacher->id }}; deleteName = '{{ addslashes($teacher->name) }}'"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold border border-rose-200 transition-all duration-200 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <span class="font-medium text-slate-500">Tidak ada data guru</span>
                                    <span class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter Anda.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="md:hidden space-y-4">
            @forelse($teachers as $teacher)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div>
                            <h3 class="font-bold text-slate-800 leading-snug">{{ $teacher->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1">NIP: {{ $teacher->nip ?? '-' }}</p>
                        </div>
                        @if($teacher->status)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-3 mt-3 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-medium">Jabatan: <span class="text-slate-600 font-semibold">{{ $teacher->position }}</span></span>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                               class="px-3 py-1.5 bg-slate-50 hover:bg-sky-50 text-slate-600 hover:text-sky-600 border border-slate-200 hover:border-sky-200 rounded-lg text-xs font-bold transition-all duration-200">
                                Edit
                            </a>

                            <button type="button"
                                    @click="deleteModalOpen = true; deleteId = {{ $teacher->id }}; deleteName = '{{ addslashes($teacher->name) }}'"
                                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 text-center text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span class="font-medium text-slate-500 block">Tidak ada data guru</span>
                    <span class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter Anda.</span>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $teachers->links() }}
        </div>

        <!-- In-Page Tailwind Modal Delete Confirmation -->
        <div x-show="deleteModalOpen" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="deleteModalOpen = false"></div>

            <div class="relative bg-white rounded-3xl border border-slate-100 shadow-2xl p-6 sm:p-8 w-full max-w-md text-center z-10 space-y-4"
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <div class="w-14 h-14 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-center text-rose-500 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">Konfirmasi Hapus Guru</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data guru <span class="font-bold text-slate-800" x-text="deleteName"></span>? Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="deleteModalOpen = false"
                            class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                        Batal
                    </button>
                    <form :action="'/admin/teachers/' + deleteId" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-500/20 transition-all">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>