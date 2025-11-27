<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\KuisionerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KaprodiController; // DITAMBAHKAN: Controller baru untuk Kaprodi

Route::get('/', fn() => redirect()->route('login'));

// --- Authentication Routes ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Admin Routes ---
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Manajemen Alumni
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni');
        Route::get('/alumni/export-csv', [AlumniController::class, 'exportCsv'])->name('alumni.exportCsv');
        Route::get('/alumni/{user}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/alumni/{user}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/alumni/{user}', [AlumniController::class, 'destroy'])->name('alumni.destroy');

        // Manajemen Kuisioner
        Route::get('/kuisioner', [KuisionerController::class, 'adminIndex'])->name('kuisioner');
        Route::get('/kuisioner/{id}/detail', [KuisionerController::class, 'show'])->name('kuisioner.detail');
        Route::delete('/kuisioner/{id}', [KuisionerController::class, 'destroy'])->name('kuisioner.destroy');
        Route::get('/kuisioner/export-csv', [KuisionerController::class, 'exportCsv'])->name('kuisioner.exportCsv');

        // Manajemen Gallery
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::put('/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        // Manajemen Kaprodi (BARU)
        Route::get('/kaprodi', [KaprodiController::class, 'index'])->name('kaprodi');
        Route::get('/kaprodi/create', [KaprodiController::class, 'create'])->name('kaprodi.create'); // DITAMBAHKAN: Route untuk formulir pembuatan
        Route::post('/kaprodi', [KaprodiController::class, 'store'])->name('kaprodi.store');
        Route::get('/kaprodi/{id}/edit', [KaprodiController::class, 'edit'])->name('kaprodi.edit');
        Route::put('/kaprodi/{id}', [KaprodiController::class, 'update'])->name('kaprodi.update');
        Route::delete('/kaprodi/{id}', [KaprodiController::class, 'destroy'])->name('kaprodi.destroy');

        // Statistik
        Route::get('/statistics', [AlumniController::class, 'statistics'])->name('statistics');

        // Testimoni Alumni
        Route::prefix('testimonials')->name('testimonials.')->group(function () {
            // Halaman Daftar Testimoni
            Route::get('/review', [AlumniController::class, 'reviewTestimonials'])->name('review');
            Route::get('/approved', [AlumniController::class, 'approvedTestimonials'])->name('approved');
            Route::get('/rejected', [AlumniController::class, 'rejectedTestimonials'])->name('rejected');

            // Aksi Testimoni
            Route::put('/{user_id}/approve', [AlumniController::class, 'approveTestimonial'])->name('approve');
            Route::delete('/{user_id}/reject', [AlumniController::class, 'rejectTestimonial'])->name('reject');
        });
    });

// --- User Routes ---
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');

        // Profil Alumni
        Route::get('/profil', [AlumniController::class, 'form'])->name('profil');
        Route::put('/profil', [AlumniController::class, 'save'])->name('profil.update');
        Route::post('/profil', [AlumniController::class, 'save'])->name('profil.save');

        // Kuisioner
        Route::get('/kuisioner', [KuisionerController::class, 'form'])->name('kuisioner');
        Route::post('/kuisioner', [KuisionerController::class, 'store'])->name('kuisioner.store');

        // Cari Alumni
        Route::get('/cari-alumni', [AlumniController::class, 'search'])->name('cari-alumni');
    });
