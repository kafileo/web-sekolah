<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan ringkasan statistik sistem.
     */
    public function index()
    {
        $totalInformasi = Information::count();
        $totalAktif = Information::where('is_active', true)->count();
        $totalNonaktif = Information::where('is_active', false)->count();
        $totalKategori = Category::count();
        $totalSiswa = User::where('role', 'user')->count();

        // Mengambil daftar informasi terbaru untuk ringkasan cepat
        $recentInformations = Information::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        // Kategori beserta jumlah informasi di dalamnya
        $categoriesStats = Category::withCount('informations')->get();

        return view('admin.dashboard', compact(
            'totalInformasi',
            'totalAktif',
            'totalNonaktif',
            'totalKategori',
            'totalSiswa',
            'recentInformations',
            'categoriesStats'
        ));
    }
}
