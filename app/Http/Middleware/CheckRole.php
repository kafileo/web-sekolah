<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses sistem.');
        }

        $user = auth()->user();

        if (!in_array($user->role, $roles)) {
            // Jika user biasa mencoba masuk ke area admin
            if ($user->role === 'user') {
                return redirect()->route('user.informasi.index')->with('error', 'Akses Ditolak! Anda masuk sebagai Siswa/User dan tidak diizinkan mengakses halaman admin.');
            }

            // Jika admin mencoba mengakses halaman khusus user jika dibatasi
            abort(403, 'Akses Ditolak: Hak akses Anda tidak mencukupi untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
