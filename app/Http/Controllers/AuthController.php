<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login terpadu untuk Admin dan Siswa/User.
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect sesuai role masing-masing
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.informasi.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses autentikasi pengguna dan mengarahkan sesuai role.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Sesuai Kebutuhan Kasus: Penentuan halaman setelah login berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . $user->name . '! Anda login sebagai Administrator.');
            }

            return redirect()->intended(route('user.informasi.index'))
                ->with('success', 'Selamat datang, ' . $user->name . '! Silakan melihat informasi dan pengumuman terbaru.');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Mengakhiri sesi pengguna dan mengembalikan ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
