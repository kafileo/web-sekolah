@extends('layouts.admin', [
    'title' => 'Ubah Informasi',
    'pageHeader' => 'Ubah Data Informasi'
])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Link & Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.informations.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Daftar Informasi</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8">
        <div class="mb-6 pb-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Ubah Data Informasi</h2>
                <p class="text-xs text-slate-500 mt-1">Perbarui judul, kategori, status aktif, atau konten pengumuman sekolah.</p>
            </div>
            <span class="text-xs text-slate-400">ID: #{{ $information->id }}</span>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                <p class="font-bold mb-1">Periksa kembali data yang dimasukkan:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.informations.update', $information) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Informasi -->
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Judul Pengumuman / Informasi <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $information->title) }}" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <!-- Grid: Kategori, Tanggal, Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id" 
                        required 
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $information->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Terbit -->
                <div>
                    <label for="published_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="published_date" 
                        id="published_date" 
                        value="{{ old('published_date', $information->published_date->format('Y-m-d')) }}" 
                        required 
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>

                <!-- Status Publikasi -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-4 pt-1.5">
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', $information->is_active ? '1' : '0') == '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-emerald-700 font-semibold text-xs">Aktif (Tampil)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', $information->is_active ? '1' : '0') == '0' ? 'checked' : '' }} class="w-4 h-4 text-slate-500 focus:ring-slate-400">
                            <span class="text-slate-600 text-xs">Draft (Nonaktif)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Ringkasan / Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Ringkasan Singkat (Excerpt) <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="excerpt" 
                    id="excerpt" 
                    rows="2" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >{{ old('excerpt', $information->excerpt) }}</textarea>
            </div>

            <!-- Konten Lengkap -->
            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Konten Pengumuman Lengkap <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="9" 
                    required 
                    class="w-full p-4 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-sans leading-relaxed"
                >{{ old('content', $information->content) }}</textarea>
            </div>

            <!-- Submit & Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.informations.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-md shadow-indigo-600/30 transition">
                    Perbarui Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
