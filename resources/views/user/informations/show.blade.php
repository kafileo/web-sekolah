@extends('layouts.user', ['title' => $information->title])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="{{ route('user.informasi.index') }}" class="hover:text-indigo-600 transition">Portal Informasi</a>
        <span>/</span>
        <a href="{{ route('user.informasi.index', ['category' => $information->category->slug]) }}" class="hover:text-indigo-600 transition">
            {{ $information->category->name }}
        </a>
        <span>/</span>
        <span class="text-slate-600 font-medium truncate max-w-xs">{{ $information->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Article Column (2 Cols) -->
        <article class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10">
            <!-- Category & Metadata Header -->
            <div class="flex flex-wrap items-center gap-3 pb-6 border-b border-slate-100">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                    {{ $information->category->name }}
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $information->published_date->format('d F Y') }}
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Diterbitkan oleh {{ $information->author->name ?? 'Admin Sekolah' }}
                </span>
                <span class="text-xs text-slate-300 ml-auto hidden sm:inline">&bull;</span>
                <span class="text-xs text-slate-400 flex items-center gap-1 hidden sm:flex">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ $information->views_count }} tayangan
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-6 leading-tight">
                {{ $information->title }}
            </h1>

            <!-- Excerpt Highlight Box -->
            <div class="mt-6 p-4 sm:p-5 rounded-2xl bg-indigo-50/60 border border-indigo-100 text-indigo-950 text-sm sm:text-base font-medium leading-relaxed">
                <span class="font-bold text-indigo-700 block mb-1 text-xs uppercase tracking-wider">Ringkasan Pengumuman:</span>
                "{{ $information->excerpt }}"
            </div>

            <!-- Full Article Content -->
            <div class="mt-8 text-slate-700 text-sm sm:text-base leading-relaxed whitespace-pre-line space-y-4">
                {{ $information->content }}
            </div>

            <!-- Back Button & Share Info -->
            <div class="mt-12 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('user.informasi.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Daftar Pengumuman</span>
                </a>
            </div>
        </article>

        <!-- Sidebar: Related Announcements (1 Col) -->
        <aside class="space-y-6">
            <!-- Category Info Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Tentang Kategori</h3>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 mb-3">
                    <span class="font-bold text-indigo-600 text-sm block">{{ $information->category->name }}</span>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $information->category->description }}</p>
                </div>
                <a href="{{ route('user.informasi.index', ['category' => $information->category->slug]) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>Lihat semua dalam kategori ini</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Related Announcements List -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Pengumuman Terkait</h3>
                <div class="space-y-4">
                    @forelse($relatedInformations as $rel)
                        <div class="pb-4 border-b border-slate-100 last:border-b-0 last:pb-0">
                            <span class="text-[10px] text-slate-400 block">{{ $rel->published_date->format('d M Y') }}</span>
                            <a href="{{ route('user.informasi.show', $rel->slug) }}" class="font-semibold text-slate-800 hover:text-indigo-600 text-xs mt-1 block line-clamp-2 transition">
                                {{ $rel->title }}
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada pengumuman terkait lainnya.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
