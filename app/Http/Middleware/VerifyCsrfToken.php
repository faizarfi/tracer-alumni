<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Daftar URL yang tidak perlu diverifikasi CSRF-nya.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        // Memastikan CSRF token diverifikasi di setiap request
        return parent::handle($request, $next);
    }
}
