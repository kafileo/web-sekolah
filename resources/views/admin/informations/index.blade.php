@extends('layouts.admin', [
    'title' => 'Kelola Informasi Sekolah',
    'pageHeader' => 'Manajemen Informasi & Pengumuman'
])

@section('content')
<div class="space-y-6">
    <!-- Top Action & Search Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Search & Filter Form -->
        <form action="{{ route('admin.informations.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <!-- Search Input -->
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul atau isi pengumuman..."
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50"
                >
            </div>

            <!-- Filter Kategori -->
            <select name="category" class="py-2 px-3 rounded-xl border border-slate-200 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Status -->
            <select name="status" class="py-2 px-3 rounded-xl border border-slate-200 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil)</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Draft)</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.informations.index') }}" class="px-3 py-2 text-xs text-rose-600 hover:underline">
                    Reset Filter
                </a>
            @endif
        </form>

        <!-- Tambah Baru Button -->
        <a href="{{ route('admin.informations.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition shadow-md shadow-indigo-600/30 whitespace-nowrap self-start lg:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Informasi Baru</span>
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-5 w-12 text-center">No</th>
                        <th class="py-3.5 px-5">Judul & Ringkasan</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Tanggal Terbit</th>
                        <th class="py-3.5 px-5">Status Siswa</th>
                        <th class="py-3.5 px-5 text-right w-44">Aksi Pengelolaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($informations as $index => $info)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-5 text-center text-xs text-slate-400">
                                {{ $informations->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-5">
                                <a href="{{ route('admin.informations.show', $info) }}" class="font-bold text-slate-800 hover:text-indigo-600 block">
                                    {{ $info->title }}
                                </a>
                                <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $info->excerpt }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 inline-block">Penulis: {{ $info->author->name ?? 'Admin' }} &bull; Dilihat: {{ $info->views_count }} kali</span>
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $info->category->name }}
                                </span>
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap text-xs text-slate-500">
                                {{ $info->published_date->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap">
                                <form action="{{ route('admin.informations.toggle-status', $info) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    @if($info->is_active)
                                        <button type="submit" title="Klik untuk menonaktifkan" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition cursor-pointer">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif (Tampil)
                                        </button>
                                    @else
                                        <button type="submit" title="Klik untuk mengaktifkan" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 transition cursor-pointer">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Nonaktif (Draft)
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail View -->
                                    <a href="{{ route('admin.informations.show', $info) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <!-- Edit View -->
                                    <a href="{{ route('admin.informations.edit', $info) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.informations.destroy', $info) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi \'{{ addslashes($info->title) }}\'? Data yang dihapus tidak akan ditampilkan lagi kepada user.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Informasi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="max-w-sm mx-auto text-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-slate-700">Tidak ada informasi yang ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Silakan sesuaikan kata kunci filter pencarian atau tambahkan informasi baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($informations->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $informations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
