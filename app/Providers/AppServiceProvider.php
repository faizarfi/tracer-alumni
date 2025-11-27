<?php

// app/Providers/AppServiceProvider.php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tidak ada perubahan, jika Anda tidak perlu mendaftar service lain.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Alias untuk middleware CheckRole
        Route::aliasMiddleware('role', RoleMiddleware::class);
     
    }
}
