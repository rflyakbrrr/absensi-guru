<x-admin-layout>
    <x-slot name="title">Tambah Guru</x-slot>

    <div class="max-w-3xl mx-auto mb-8">
        <div class="mb-6">
            <a href="{{ route('admin.teachers.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Guru
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-3">Tambah Guru Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Daftarkan guru baru ke dalam sistem absensi sekolah.</p>
        </div>

        <form action="{{ route('admin.teachers.store') }}" method="POST">
            @csrf
            @include('admin.teachers._form')
        </form>
    </div>
</x-admin-layout>