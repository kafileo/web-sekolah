@extends('layouts.admin', [
    'title' => 'Dashboard Ringkasan Admin',
    'pageHeader' => 'Dashboard Ringkasan Sistem'
])

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-indigo-800 to-slate-900 p-6 lg:p-8 text-white shadow-xl">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-indigo-200 mb-3 border border-white/10">
                Sistem Informasi Sekolah v1.0
            </span>
            <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="mt-2 text-indigo-100 text-sm leading-relaxed">
                Halaman dashboard ini memberikan gambaran ringkas mengenai data yang terdapat pada sistem. Anda dapat memantau status publikasi pengumuman sekolah dan mengelola konten secara langsung.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.informations.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 hover:bg-indigo-50 font-semibold text-xs transition shadow-md shadow-black/10">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Informasi Baru</span>
                </a>
                <a href="{{ route('admin.informations.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition border border-white/15">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>Kelola Seluruh Informasi</span>
                </a>
            </div>
        </div>
        <!-- Decorative Glow -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Informasi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Informasi</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalInformasi }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Keseluruhan pengumuman</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Informasi Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Informasi Aktif</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalAktif }}</h3>
                    <p class="text-[11px] text-emerald-600 mt-1 font-medium">● Tampil di halaman siswa</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Informasi Nonaktif / Draft -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Nonaktif / Draft</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalNonaktif }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Disembunyikan dari siswa</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Kategori Informasi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-600">Kategori Aktif</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalKategori }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">{{ $totalSiswa }} Akun siswa terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table of Recent Announcements -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Informasi Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pengumuman terakhir yang dimasukkan ke dalam sistem</p>
            </div>
            <a href="{{ route('admin.informations.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 self-start sm:self-auto">
                <span>Lihat Seluruh Data</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5">Judul Informasi</th>
                        <th class="py-3 px-5">Kategori</th>
                        <th class="py-3 px-5">Tanggal Terbit</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentInformations as $info)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-5">
                                <a href="{{ route('admin.informations.show', $info) }}" class="font-semibold text-slate-800 hover:text-indigo-600 block line-clamp-1">
                                    {{ $info->title }}
                                </a>
                                <span class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $info->excerpt }}</span>
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $info->category->name }}
                                </span>
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap text-xs text-slate-500">
                                {{ $info->published_date->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap">
                                @if($info->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif (User)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Draft (Sembunyi)
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.informations.show', $info) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.informations.edit', $info) }}" class="p-1.5 text-slate-400 hover:text-amber-600 transition" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm">Belum ada data informasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
