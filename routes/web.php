<?php

use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\AdminCommunityController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\KuisionerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

// ==================== PASSWORD RESET (Forgot Password) ====================
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();
            Auth::login($user);
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

// Announcements
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

// Community / Komunitas (dynamic from DB)
Route::get('/community', function () {
    $communities = \App\Models\Community::where('active', true)->orderBy('sort_order')->get();
    return view('user.community', compact('communities'));
})->name('community');


// ====================  ADMIN ROUTES  ====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // --- Manajemen Pengumuman (Hanya Admin) ---
        Route::resource('announcements', AdminAnnouncementController::class)->except(['index', 'show']);

        // --- Manajemen Komunitas ---
        Route::resource('community', AdminCommunityController::class)->except(['show']);

        // --- Manajemen Alumni ---
        Route::resource('alumni', AlumniController::class)
            ->only(['index', 'edit', 'update', 'destroy'])
            ->parameters(['alumni' => 'user'])
            ->names([
                'index' => 'alumni',
                'edit' => 'alumni.edit',
                'update' => 'alumni.update',
                'destroy' => 'alumni.destroy',
            ]);

        // Custom exports
        Route::get('/alumni/export-csv', [AlumniController::class, 'exportCsv'])->name('alumni.exportCsv');
        Route::get('/alumni/export-pdf', [AlumniController::class, 'exportPdf'])->name('alumni.exportPdf');

        // --- Manajemen Kuisioner ---
        Route::controller(KuisionerController::class)->group(function () {
            Route::get('/kuisioner', 'adminIndex')->name('kuisioner');
            Route::get('/kuisioner/export-csv', 'exportCsv')->name('kuisioner.exportCsv');
            Route::get('/kuisioner/{id}/detail', 'show')->name('kuisioner.detail');
            Route::delete('/kuisioner/{id}', 'destroy')->name('kuisioner.destroy');
        });

        // --- Manajemen Gallery ---
        Route::resource('gallery', GalleryController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->parameters(['gallery' => 'id'])
            ->names([
                'index' => 'gallery',
                'store' => 'gallery.store',
                'update' => 'gallery.update',
                'destroy' => 'gallery.destroy',
            ]);

        // --- Manajemen Kaprodi ---
        Route::resource('kaprodi', KaprodiController::class)
            ->except(['show'])
            ->parameters(['kaprodi' => 'id'])
            ->names([
                'index' => 'kaprodi',
            ]);

        // --- Statistik ---
        Route::get('/statistics', [AlumniController::class, 'statistics'])->name('statistics');

        // --- Manajemen Fakultas & Program Studi ---
        Route::resource('faculties', FacultyController::class)->except(['show']);
        Route::resource('programs', ProgramController::class)->except(['show']);

        // --- Testimoni Alumni ---
        Route::controller(AlumniController::class)
            ->prefix('testimonials')
            ->name('testimonials.')
            ->group(function () {

                // List Testimoni
                Route::get('/review', 'reviewTestimonials')->name('review');
                Route::get('/approved', 'approvedTestimonials')->name('approved');
                Route::get('/rejected', 'rejectedTestimonials')->name('rejected');

                // Aksi Testimoni
                Route::put('/{user_id}/approve', 'approveTestimonial')->name('approve');
                Route::delete('/{user_id}/reject', 'rejectTestimonial')->name('reject');
                Route::put('/{user_id}/pending', 'pendingTestimonial')->name('pending');
            });

    });


// ====================  KAPRODI ROUTES  ====================
Route::middleware(['auth', 'role:kaprodi'])
    ->prefix('kaprodi')
    ->name('kaprodi.')
    ->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'kaprodi')->name('dashboard');
            Route::get('/help', 'kaprodiHelp')->name('help');
            Route::get('/help/checklist-pdf', 'kaprodiHelpPdf')->name('help.checklistPdf');
        });

        Route::controller(KuisionerController::class)->group(function () {
            Route::get('/laporan-kuisioner', 'kaprodiReport')->name('kuisioner.report');
            Route::get('/export-kuisioner-pdf', 'exportKaprodiPdf')->name('kuisioner.exportPdf');
            Route::get('/export-kuisioner-csv', 'exportKaprodiCsv')->name('kuisioner.exportCsv');
            Route::get('/alumni/{alumni_id}/detail', 'showKaprodiDetail')->name('alumni.detail');
        });

        Route::controller(AlumniController::class)->group(function () {
            Route::get('/data-alumni', 'kaprodiAlumni')->name('alumni');
            Route::get('/alumni/export-pdf', 'kaprodiExportPdf')->name('alumni.exportPdf');
        });
    });


// ====================  USER ROUTES  ====================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');

        // Profil, Kuisioner, dan Pencarian pengguna
        Route::controller(AlumniController::class)->group(function () {
            Route::get('/profil', 'form')->name('profil');
            Route::put('/profil', 'save')->name('profil.update');
            Route::post('/profil', 'save')->name('profil.save');

            Route::get('/cari-alumni', 'search')->name('cari-alumni');
        });

        Route::controller(KuisionerController::class)->group(function () {
            Route::get('/kuisioner', 'form')->name('kuisioner');
            Route::post('/kuisioner', 'store')->name('kuisioner.store');
        });
    });
