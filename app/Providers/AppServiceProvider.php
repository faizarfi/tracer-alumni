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

        // Create storage symlink manually if it doesn't exist
        // This is a workaround for cPanel where exec() function is disabled
        $this->createStorageLink();
    }

    /**
     * Create storage symlink manually
     */
    private function createStorageLink(): void
    {
        $link = public_path('storage');
        $target = storage_path('app/public');

        // Check if symlink already exists
        if (file_exists($link) || is_link($link)) {
            return;
        }

        // Create the symlink using PHP's symlink function
        if (function_exists('symlink')) {
            try {
                symlink($target, $link);
            } catch (\Exception $e) {
                // Silently fail, symlink might not be available on all systems
            }
        }
    }
}
