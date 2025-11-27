<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Menangani permintaan yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Gunakan guard default 'web' jika $guard kosong
        $guard = $guard ?? 'web';

        if (Auth::guard($guard)->check()) {
            // Jika sudah login, lanjutkan permintaan
            return $next($request);
        }

        // Jika belum login, redirect ke halaman login
        return redirect()->route('login');
    }
}
