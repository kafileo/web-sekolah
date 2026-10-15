<?php // penjelas: File routing utama framework yang mendefinisikan rute autentikasi, dashboard admin, manajemen informasi CRUD sekolah, dan portal informasi siswa dengan proteksi role-based access control.
// penjelas: Baris rute di bawah ini mengamankan hak akses role admin dan user melalui middleware 'auth' dan 'role'.

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InformationController as AdminInformationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\InformationController as UserInformationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi Sekolah (SIP-Sekolah)
|--------------------------------------------------------------------------
| Seluruh rute aplikasi didefinisikan secara terstruktur menggunakan arsitektur MVC.
| Rute admin diproteksi ketat sehingga role user/siswa tidak dapat mengaksesnya.
*/

// Halaman utama diarahkan ke login atau ke halaman tujuan berdasarkan status autentikasi
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.informasi.index');
    }
    return redirect()->route('login');
});

// --------------------------------------------------------------------------
// 1. RUTE AUTENTIKASI (Halaman Login Terpadu Admin & User)
// --------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --------------------------------------------------------------------------
// 2. RUTE ROLE ADMIN (Halaman Pengelolaan, Dashboard & Full CRUD Informasi)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin: Menampilkan ringkasan statistik sistem
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Pengelolaan Informasi Penuh (CRUD: Create, Read, Update, Delete)
    Route::resource('informations', AdminInformationController::class);

    // Fitur Cepat: Ubah status aktif/nonaktif informasi
    Route::patch('informations/{information}/toggle-status', [AdminInformationController::class, 'toggleStatus'])
        ->name('informations.toggle-status');
});

// --------------------------------------------------------------------------
// 3. RUTE ROLE USER / SISWA (Melihat Informasi & Pengumuman Aktif Sekolah)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:user,admin'])->group(function () {
    // Daftar Informasi Siswa (Hanya menampilkan informasi dengan status is_active = true)
    Route::get('/informasi', [UserInformationController::class, 'index'])->name('user.informasi.index');

    // Detail Isi Informasi / Pengumuman
    Route::get('/informasi/{slug}', [UserInformationController::class, 'show'])->name('user.informasi.show');
});
