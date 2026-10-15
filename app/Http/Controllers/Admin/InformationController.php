<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InformationController extends Controller
{
    /**
     * Menampilkan daftar semua informasi yang dikelola oleh Admin.
     */
    public function index(Request $request)
    {
        $query = Information::with(['category', 'author']);

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $informations = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.informations.index', compact('informations', 'categories'));
    }

    /**
     * Menampilkan formulir penambahan informasi baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.informations.create', compact('categories'));
    }

    /**
     * Menyimpan informasi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'published_date' => ['required', 'date'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ], [
            'title.required' => 'Judul informasi wajib diisi.',
            'category_id.required' => 'Kategori informasi wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'published_date.required' => 'Tanggal terbit wajib diisi.',
            'excerpt.required' => 'Ringkasan informasi wajib diisi.',
            'content.required' => 'Isi lengkap informasi wajib diisi.',
            'is_active.required' => 'Status publikasi informasi wajib ditentukan.',
        ]);

        // Buat slug unik
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Information::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $information = new Information($validated);
        $information->slug = $slug;
        $information->user_id = auth()->id();
        $information->views_count = 0;
        $information->save();

        return redirect()->route('admin.informations.index')
            ->with('success', "Informasi '{$information->title}' berhasil dibuat dan disimpan ke database.");
    }

    /**
     * Menampilkan detail informasi untuk pratinjau Admin.
     */
    public function show(Information $information)
    {
        $information->load(['category', 'author']);
        return view('admin.informations.show', compact('information'));
    }

    /**
     * Menampilkan formulir pembaruan data informasi.
     */
    public function edit(Information $information)
    {
        $categories = Category::all();
        return view('admin.informations.edit', compact('information', 'categories'));
    }

    /**
     * Memperbarui data informasi di database.
     */
    public function update(Request $request, Information $information)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'published_date' => ['required', 'date'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ], [
            'title.required' => 'Judul informasi wajib diisi.',
            'category_id.required' => 'Kategori informasi wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'published_date.required' => 'Tanggal terbit wajib diisi.',
            'excerpt.required' => 'Ringkasan informasi wajib diisi.',
            'content.required' => 'Isi lengkap informasi wajib diisi.',
            'is_active.required' => 'Status publikasi informasi wajib ditentukan.',
        ]);

        // Jika judul berubah, perbarui slug secara unik
        if ($validated['title'] !== $information->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Information::where('slug', $slug)->where('id', '!=', $information->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $information->slug = $slug;
        }

        $information->fill($validated);
        $information->save();

        return redirect()->route('admin.informations.index')
            ->with('success', "Informasi '{$information->title}' berhasil diperbarui.");
    }

    /**
     * Menghapus data informasi dari sistem.
     */
    public function destroy(Information $information)
    {
        $title = $information->title;
        $information->delete();

        return redirect()->route('admin.informations.index')
            ->with('success', "Informasi '{$title}' berhasil dihapus dan tidak lagi ditampilkan kepada user.");
    }

    /**
     * Mengubah status aktif/nonaktif informasi secara cepat.
     */
    public function toggleStatus(Information $information)
    {
        $information->is_active = !$information->is_active;
        $information->save();

        $statusText = $information->is_active ? 'diaktifkan (dapat dilihat siswa)' : 'dinonaktifkan (disembunyikan dari siswa)';

        return back()->with('success', "Status informasi '{$information->title}' berhasil {$statusText}.");
    }
}
