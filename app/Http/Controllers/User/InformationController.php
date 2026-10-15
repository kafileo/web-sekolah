<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Menampilkan daftar informasi aktif untuk siswa/pengguna umum.
     */
    public function index(Request $request)
    {
        // Kebutuhan Fungsional 4: Hanya data dengan status is_active = true yang ditampilkan
        $query = Information::active()->with(['category', 'author']);

        // Filter Pencarian kata kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter Kategori berdasarkan slug
        $selectedCategory = null;
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $selectedCategory = Category::where('slug', $categorySlug)->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $informations = $query->latest('published_date')->paginate(6)->withQueryString();
        
        // Ambil semua kategori untuk filter tombol di UI
        $categories = Category::withCount(['informations' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        // 3 informasi terbaru untuk highlight/slider banner
        $featuredInformations = Information::active()
            ->with(['category', 'author'])
            ->latest('published_date')
            ->take(3)
            ->get();

        return view('user.informations.index', compact(
            'informations',
            'categories',
            'selectedCategory',
            'featuredInformations'
        ));
    }

    /**
     * Menampilkan detail isi pengumuman/informasi kepada siswa.
     */
    public function show($slug)
    {
        // Pengguna hanya dapat membaca detail informasi yang AKTIF
        $information = Information::active()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tingkatkan jumlah pembaca
        $information->increment('views_count');

        // Rekomendasi informasi terkait dalam kategori yang sama
        $relatedInformations = Information::active()
            ->where('category_id', $information->category_id)
            ->where('id', '!=', $information->id)
            ->latest('published_date')
            ->take(3)
            ->get();

        return view('user.informations.show', compact('information', 'relatedInformations'));
    }
}
