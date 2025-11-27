<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Menangani permintaan masuk (incoming request).
     * Middleware ini memeriksa apakah pengguna yang diautentikasi memiliki peran yang diperlukan.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Peran yang diperlukan (misalnya: 'admin', 'kaprodi', 'user')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Cek apakah peran pengguna saat ini cocok dengan peran yang diizinkan
        if ($user->role === $role) {
            return $next($request);
        }

        // 3. Jika peran tidak cocok, arahkan ke dashboard yang sesuai (Akses Ditolak)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
        } elseif ($user->role === 'kaprodi') {
            // Arahkan ke dashboard Kaprodi
            return redirect()->route('kaprodi.dashboard')->with('error', 'Akses ditolak.');
        } elseif ($user->role === 'user') {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak.');
        }

        // Default redirect jika peran tidak valid
        return redirect()->route('login')->with('error', 'Akses ditolak karena peran tidak valid.');
    }
}
