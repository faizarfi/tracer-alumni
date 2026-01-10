<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\KuisionerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\AdminCommunityController;

// Landing page
Route::get('/', function () {
    return view('home');
});

// ====================  AUTH ROUTES  ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Announcements
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

// Community / Komunitas (dynamic from DB)
Route::get('/community', function () {
    $communities = \App\Models\Community::where('active', true)->orderBy('sort_order')->get();
    return view('community', compact('communities'));
})->name('community');


// ====================  ADMIN ROUTES  ====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // --- Manajemen Pengumuman (Hanya Admin) ---
        Route::get('/announcements/create', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [AdminAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

        // --- Manajemen Komunitas ---
        Route::get('/community', [AdminCommunityController::class, 'index'])->name('community.index');
        Route::get('/community/create', [AdminCommunityController::class, 'create'])->name('community.create');
        Route::post('/community', [AdminCommunityController::class, 'store'])->name('community.store');
        Route::get('/community/{community}/edit', [AdminCommunityController::class, 'edit'])->name('community.edit');
        Route::put('/community/{community}', [AdminCommunityController::class, 'update'])->name('community.update');
        Route::delete('/community/{community}', [AdminCommunityController::class, 'destroy'])->name('community.destroy');

        // --- Manajemen Alumni ---
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni');
        Route::get('/alumni/export-csv', [AlumniController::class, 'exportCsv'])->name('alumni.exportCsv');
        Route::get('/alumni/export-pdf', [AlumniController::class, 'exportPdf'])->name('alumni.exportPdf');
        Route::get('/alumni/{user}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/alumni/{user}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/alumni/{user}', [AlumniController::class, 'destroy'])->name('alumni.destroy');

        // --- Manajemen Kuisioner ---
        Route::get('/kuisioner', [KuisionerController::class, 'adminIndex'])->name('kuisioner');
        Route::get('/kuisioner/{id}/detail', [KuisionerController::class, 'show'])->name('kuisioner.detail');
        Route::delete('/kuisioner/{id}', [KuisionerController::class, 'destroy'])->name('kuisioner.destroy');
        Route::get('/kuisioner/export-csv', [KuisionerController::class, 'exportCsv'])->name('kuisioner.exportCsv');

        // --- Manajemen Gallery ---
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::put('/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        // --- Manajemen Kaprodi ---
        Route::get('/kaprodi', [KaprodiController::class, 'index'])->name('kaprodi');
        Route::get('/kaprodi/create', [KaprodiController::class, 'create'])->name('kaprodi.create');
        Route::post('/kaprodi', [KaprodiController::class, 'store'])->name('kaprodi.store');
        Route::get('/kaprodi/{id}/edit', [KaprodiController::class, 'edit'])->name('kaprodi.edit');
        Route::put('/kaprodi/{id}', [KaprodiController::class, 'update'])->name('kaprodi.update');
        Route::delete('/kaprodi/{id}', [KaprodiController::class, 'destroy'])->name('kaprodi.destroy');

        // --- Statistik ---
        Route::get('/statistics', [AlumniController::class, 'statistics'])->name('statistics');

        // --- Testimoni Alumni ---
        Route::prefix('testimonials')->name('testimonials.')->group(function () {

            // List Testimoni
            Route::get('/review', [AlumniController::class, 'reviewTestimonials'])->name('review');
            Route::get('/approved', [AlumniController::class, 'approvedTestimonials'])->name('approved');
            Route::get('/rejected', [AlumniController::class, 'rejectedTestimonials'])->name('rejected');

            // Aksi Testimoni
            Route::put('/{user_id}/approve', [AlumniController::class, 'approveTestimonial'])->name('approve');
            Route::delete('/{user_id}/reject', [AlumniController::class, 'rejectTestimonial'])->name('reject');
            Route::put('/{user_id}/pending', [AlumniController::class, 'pendingTestimonial'])->name('pending'); // ✅ BARU: Kembali ke Review
        });

    });


// ====================  KAPRODI ROUTES  ====================
Route::middleware(['auth', 'role:kaprodi'])
    ->prefix('kaprodi')
    ->name('kaprodi.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'kaprodi'])->name('dashboard');

        Route::get('/laporan-kuisioner', [KuisionerController::class, 'kaprodiReport'])->name('kuisioner.report');
        Route::get('/data-alumni', [AlumniController::class, 'kaprodiAlumni'])->name('alumni');
        Route::get('/export-kuisioner-pdf', [KuisionerController::class, 'exportKaprodiPdf'])->name('kuisioner.exportPdf');

        // Ekspor PDF khusus Kaprodi (menggunakan DomPDF jika tersedia)
        Route::get('/alumni/export-pdf', [AlumniController::class, 'kaprodiExportPdf'])->name('alumni.exportPdf');

        // Perbaiki error RouteNotFound
        Route::get('/alumni/{alumni_id}/detail', [KuisionerController::class, 'showKaprodiDetail'])->name('alumni.detail');

        Route::get('/export-kuisioner-csv', [KuisionerController::class, 'exportKaprodiCsv'])->name('kuisioner.exportCsv');

        Route::get('/help', [DashboardController::class, 'kaprodiHelp'])->name('help');
        Route::get('/help/checklist-pdf', [DashboardController::class, 'kaprodiHelpPdf'])->name('help.checklistPdf');
    });


// ====================  USER ROUTES  ====================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');

        // Profil
        Route::get('/profil', [AlumniController::class, 'form'])->name('profil');
        Route::put('/profil', [AlumniController::class, 'save'])->name('profil.update');
        Route::post('/profil', [AlumniController::class, 'save'])->name('profil.save');

        // Kuisioner
        Route::get('/kuisioner', [KuisionerController::class, 'form'])->name('kuisioner');
        Route::post('/kuisioner', [KuisionerController::class, 'store'])->name('kuisioner.store');

        // Cari Alumni
        Route::get('/cari-alumni', [AlumniController::class, 'search'])->name('cari-alumni');
    });
