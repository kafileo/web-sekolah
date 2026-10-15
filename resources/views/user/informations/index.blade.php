@extends('layouts.user', ['title' => 'Daftar Pengumuman & Informasi Sekolah'])

@section('content')
<!-- Hero Section with Search -->
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-200 text-xs font-semibold border border-indigo-400/20 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Informasi Terkini Siswa
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Pusat Pengumuman & Informasi Resmi
            </h1>
            <p class="mt-3 text-indigo-100/90 text-sm sm:text-base leading-relaxed">
                Akses seluruh agenda akademik, jadwal ujian, kegiatan ekstrakurikuler, dan informasi kesiswaan terpercaya yang langsung dikelola oleh pihak sekolah.
            </p>

            <!-- Search Bar in Hero -->
            <form action="{{ route('user.informasi.index') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-2 max-w-xl">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari pengumuman, ujian, jadwal..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-white text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-lg"
                    >
                </div>
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-500 hover:bg-indigo-400 text-white font-bold text-sm shadow-lg shadow-indigo-500/30 transition flex items-center justify-center gap-2">
                    <span>Cari</span>
                </button>
            </form>
        </div>
    </div>
    <!-- Decorative Circle Blur -->
    <div class="absolute right-0 top-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
</div>

<!-- Main Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
    <!-- Category Filter Pills Card -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-md">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kategori:</span>
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 flex-1">
                <!-- All Categories Pill -->
                <a 
                    href="{{ route('user.informasi.index', request()->only('search')) }}" 
                    class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap {{ !request('category') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}"
                >
                    Semua
                </a>

                @foreach($categories as $cat)
                    <a 
                        href="{{ route('user.informasi.index', array_merge(request()->only('search'), ['category' => $cat->slug])) }}" 
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap flex items-center gap-1.5 {{ request('category') === $cat->slug ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}"
                    >
                        <span>{{ $cat->name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('category') === $cat->slug ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $cat->informations_count }}
                        </span>
                    </a>
                @endforeach
            </div>

            @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('user.informasi.index') }}" class="text-xs text-rose-600 font-semibold hover:underline">
                    Reset Filter
                </a>
            @endif
        </div>
    </div>

    <!-- Active Search/Category Feedback -->
    @if(request('search') || $selectedCategory)
        <div class="mt-6 flex items-center gap-2 text-sm text-slate-600">
            <span>Menampilkan hasil</span>
            @if(request('search'))
                <span>untuk pencarian <strong class="text-slate-900">"{{ request('search') }}"</strong></span>
            @endif
            @if($selectedCategory)
                <span>dalam kategori <strong class="text-indigo-600">"{{ $selectedCategory->name }}"</strong></span>
            @endif
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($informations as $info)
            <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group hover:-translate-y-1">
                <!-- Card Header with Accent Bar -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <!-- Meta: Category & Date -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $info->category->name }}
                        </span>
                        <span class="text-xs text-slate-400">
                            {{ $info->published_date->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition leading-snug line-clamp-2">
                        <a href="{{ route('user.informasi.show', $info->slug) }}">
                            {{ $info->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-xs text-slate-500 mt-2.5 line-clamp-3 leading-relaxed flex-1">
                        {{ $info->excerpt }}
                    </p>

                    <!-- Card Footer: Author, Views & Button -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[11px] text-slate-400 flex items-center gap-2">
                            <span>Admin Sekolah</span>
                            <span>&bull;</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $info->views_count }}
                            </span>
                        </div>

                        <a 
                            href="{{ route('user.informasi.show', $info->slug) }}" 
                            class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition group-hover:translate-x-0.5"
                        >
                            <span>Baca Lengkap</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak Ada Pengumuman Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Belum ada informasi aktif yang cocok dengan kriteria pencarian Anda. Silakan coba kata kunci lain atau pilih semua kategori.
                </p>
                <div class="mt-4">
                    <a href="{{ route('user.informasi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold shadow-md">
                        Tampilkan Semua Pengumuman
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if($informations->hasPages())
        <div class="mt-10">
            {{ $informations->links() }}
        </div>
    @endif
</div>
@endsection
