<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Kuisioner;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard untuk pengguna Admin (Superuser).
     * Menyediakan metrik global untuk semua data alumni.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        // Total Alumni terdaftar
        $totalAlumni = Alumni::count();

        // Alumni yang sudah bekerja (sudah_bekerja = 1)
        $bekerja = Alumni::where('sudah_bekerja', 1)->count();

        // Alumni yang belum bekerja (sudah_bekerja = 0)
        $belumBekerja = Alumni::where('sudah_bekerja', 0)->count();

        // Jumlah responden Kuisioner (diambil dari user_id yang unik di tabel Kuisioner)
        $isiKuisioner = Kuisioner::distinct('user_id')->count();

        // 5 Alumni Terbaru yang terdaftar
        $latestAlumni = Alumni::latest()->take(5)->get();

        // 3 Testimoni Terbaru yang menunggu review/persetujuan (diasumsikan testimonial_status 'pending' atau null)
        $latestTestimonials = Alumni::whereNotNull('testimonial_quote')
                                    ->where(function ($query) {
                                        $query->where('testimonial_status', 'pending')
                                              ->orWhereNull('testimonial_status');
                                    })
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

    /**
     * Tampilkan dashboard untuk pengguna Kaprodi.
     * Mengambil metrik yang disaring berdasarkan Program Studi Kaprodi yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function kaprodi()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil nama program studi dari user. Ganti 'prodi' jika nama kolom berbeda.
        // Fallback digunakan jika kolom 'prodi' tidak ada/kosong.
        $prodiName = $user->prodi ?? 'Program Studi Tidak Ditemukan';

        // Base query untuk menyaring Alumni berdasarkan Program Studi
        $alumniProdiQuery = Alumni::where('jurusan', $prodiName);

        // 1. Metrik Utama
        $totalAlumni = $alumniProdiQuery->count();
        $alumniUserIds = $alumniProdiQuery->pluck('user_id');

        // Jumlah Responden Kuisioner dari Prodi ini
        $totalResponden = Kuisioner::whereIn('user_id', $alumniUserIds)
                                     ->distinct('user_id')
                                     ->count();

        // 2. Data Grafik 1: Alumni Berdasarkan Tahun Keluar
        $alumniByYear = $alumniProdiQuery
            ->whereNotNull('tahun_keluar')
            ->select('tahun_keluar', DB::raw('count(*) as total'))
            ->groupBy('tahun_keluar')
            ->orderBy('tahun_keluar', 'desc')
            ->pluck('total', 'tahun_keluar')
            ->toArray();

        // 3. Data Grafik 2: Distribusi Status Kerja
        $statusKerjaResult = $alumniProdiQuery
            ->select('sudah_bekerja', DB::raw('count(*) as total'))
            ->groupBy('sudah_bekerja')
            ->pluck('total', 'sudah_bekerja')
            ->toArray();

        // Memastikan array memiliki kunci '0' (Belum Bekerja) dan '1' (Bekerja) untuk visualisasi
        $statusKerja = [
            '1' => $statusKerjaResult[1] ?? 0, // Bekerja
            '0' => $statusKerjaResult[0] ?? 0, // Belum Bekerja
        ];

        // 4. Agregasi data yang akan dikirim ke view
        $kaprodiData = [
            'prodi_name' => $prodiName,
            'total_alumni' => $totalAlumni,
            'total_responden' => $totalResponden,
            // Data Grafik
            'alumni_by_year' => $alumniByYear,
            'status_kerja' => $statusKerja,
        ];

        // 5. Tampilkan view dashboard Kaprodi
        return view('kaprodi.dashboard', compact('kaprodiData'));
    }

    /**
     * Tampilkan halaman bantuan/panduan untuk pengguna Kaprodi.
     * Metode ini ditambahkan untuk menyediakan halaman bantuan.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function kaprodiHelp(Request $request)
    {
        // Asumsi view 'kaprodi.help' berisi FAQ, panduan penggunaan dashboard, dll.
        return view('kaprodi.help');
    }

    /**
     * Tampilkan dashboard untuk pengguna umum (Alumni/Guest).
     * Menyediakan statistik publik, galeri, dan testimoni yang disetujui.
     *
     * @return \Illuminate\View\View
     */
    public function user()
    {
        // Statistik publik
        // $totalAlumni = Alumni::count(); // Dihapus karena tidak terpakai di compact
        $bekerja = Alumni::where('sudah_bekerja', 1)->count();
        $isiKuisioner = Kuisioner::distinct('user_id')->count();

        // 8 item terbaru dari Galeri
        $galleries = Gallery::latest()->take(8)->get();

        // Testimoni yang sudah disetujui ('approved')
        $approvedTestimonials = Alumni::whereNotNull('testimonial_quote')
                                      ->where('testimonial_status', 'approved')
                                      ->inRandomOrder() // Acak agar lebih variatif
                                      ->get();

        // Logika duplikasi data untuk carousel di view, jika jumlah testimoni kurang.
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
