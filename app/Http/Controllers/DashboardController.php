<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Kuisioner;
use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total Alumni
        $totalAlumni = Alumni::count();

        // Alumni yang sudah bekerja
        $bekerja = Alumni::where('sudah_bekerja', 1)->count();

        // Alumni yang belum bekerja
        $belumBekerja = Alumni::where('sudah_bekerja', 0)->count();

        // Alumni yang sudah mengisi kuisioner
        $isiKuisioner = Kuisioner::distinct('user_id')->count();

        // Alumni terbaru
        $latestAlumni = Alumni::latest()->take(5)->get();

        // Testimoni Terbaru (untuk admin review)
        $latestTestimonials = Alumni::whereNotNull('testimonial_quote')
                                        ->latest()
                                        ->take(3)
                                        ->get();

        return view('admin.dashboard', compact(
            'totalAlumni',
            'bekerja',
            'belumBekerja',
            'isiKuisioner',
            'latestAlumni',
            'latestTestimonials'
        ));
    }

    public function user()
    {
        // Statistik
        $totalAlumni = Alumni::count();
        $bekerja = Alumni::where('sudah_bekerja', 1)->count();
        $isiKuisioner = Kuisioner::distinct('user_id')->count();

        // Load data gallery
        // Asumsi data gallery diambil dari model Gallery yang tersedia
        $galleries = Gallery::latest()->take(8)->get();

        // FIX UNTUK TESTIMONI: Menggunakan kolom 'testimonial_status' dan nilai ENUM 'approved'
        // Ini memastikan testimoni yang sudah disetujui tampil di dashboard.
        $approvedTestimonials = Alumni::whereNotNull('testimonial_quote')
                                    ->where('testimonial_status', 'approved')
                                    ->inRandomOrder()
                                    ->get();

        // Logika duplikasi data untuk carousel di view
        $testimonials = $approvedTestimonials->isNotEmpty()
                            ? $approvedTestimonials->merge($approvedTestimonials)
                            : collect();

        return view('user.dashboard', compact(
            'bekerja',
            'isiKuisioner',
            'galleries',
            'testimonials'
        ));
    }
}
