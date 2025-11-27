<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class PreventRequestsDuringMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah aplikasi dalam mode pemeliharaan
        if (App::isDownForMaintenance()) {
            // Jika aplikasi dalam pemeliharaan, tampilkan halaman 503
            return response('Service Unavailable', 503);
        }

        return $next($request);
    }
}
