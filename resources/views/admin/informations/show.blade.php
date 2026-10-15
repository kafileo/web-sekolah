@extends('layouts.admin', [
    'title' => 'Detail Informasi: ' . $information->title,
    'pageHeader' => 'Detail Informasi & Pratinjau'
])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action Nav -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.informations.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Daftar</span>
        </a>

        <div class="flex items-center gap-2">
            @if($information->is_active)
                <a href="{{ route('user.informasi.show', $information->slug) }}" target="_blank" class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold transition border border-emerald-200 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span>Buka Tampilan Siswa</span>
                </a>
            @endif

            <a href="{{ route('admin.informations.edit', $information) }}" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Data</span>
            </a>

            <form action="{{ route('admin.informations.destroy', $information) }}" method="POST" class="inline" onsubmit="return confirm('Hapus informasi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold transition border border-rose-200 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Article Preview Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-10">
        <!-- Metadata Header -->
        <div class="flex flex-wrap items-center gap-3 pb-6 border-b border-slate-100">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                Kategori: {{ $information->category->name }}
            </span>
            <span class="text-xs text-slate-400">&bull;</span>
            <span class="text-xs text-slate-500">
                Terbit: {{ $information->published_date->format('d F Y') }}
            </span>
            <span class="text-xs text-slate-400">&bull;</span>
            <span class="text-xs text-slate-500">
                Oleh: {{ $information->author->name ?? 'Administrator' }}
            </span>
            <div class="ml-auto">
                @if($information->is_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Status: Aktif (Tampil di User)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Status: Draft (Tidak Tampil di User)
                    </span>
                @endif
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 mt-6 leading-tight">
            {{ $information->title }}
        </h1>

        <!-- Excerpt Callout -->
        <div class="mt-4 p-4 rounded-xl bg-slate-50 border-l-4 border-indigo-600 text-slate-700 text-sm font-medium italic">
            "{{ $information->excerpt }}"
        </div>

        <!-- Article Body -->
        <div class="mt-8 prose prose-slate max-w-none text-slate-700 leading-relaxed whitespace-pre-line text-sm lg:text-base">
            {{ $information->content }}
        </div>
    </div>
</div>
@endsection
