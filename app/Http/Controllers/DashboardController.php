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
        // Menambahkan trim untuk memastikan tidak ada spasi tersembunyi yang membuat query gagal.
        $prodiName = trim($user->prodi) ?? 'Program Studi Tidak Ditemukan';

        // 1. Metrik Utama
        // Menggunakan query langsung agar data benar-benar sinkron dengan filter prodi.
        $totalAlumni = Alumni::where('jurusan', $prodiName)->count();
        $alumniUserIds = Alumni::where('jurusan', $prodiName)->pluck('user_id');

        // Jumlah Responden Kuisioner dari Prodi ini
        $totalResponden = Kuisioner::whereIn('user_id', $alumniUserIds)
                                     ->distinct('user_id')
                                     ->count();

        // 2. Data Grafik 1: Alumni Berdasarkan Tahun Keluar
        // Diubah menjadi ASC (urut naik) agar grafik tahun tampil dari lama ke baru.
        $alumniByYear = Alumni::where('jurusan', $prodiName)
            ->whereNotNull('tahun_keluar')
            ->select('tahun_keluar', DB::raw('count(*) as total'))
            ->groupBy('tahun_keluar')
            ->orderBy('tahun_keluar', 'asc')
            ->pluck('total', 'tahun_keluar')
            ->toArray();

        // 3. Data Grafik 2: Distribusi Status Kerja
        $statusKerjaResult = Alumni::where('jurusan', $prodiName)
            ->select('sudah_bekerja', DB::raw('count(*) as total'))
            ->groupBy('sudah_bekerja')
            ->pluck('total', 'sudah_bekerja')
            ->toArray();

        // Memastikan array memiliki kunci '0' dan '1' agar chart tidak error jika salah satu data kosong.
        // Menangani kemungkinan key berupa string atau integer dari database.
        $statusKerja = [
            '1' => (int)($statusKerjaResult[1] ?? $statusKerjaResult['1'] ?? 0), // Bekerja
            '0' => (int)($statusKerjaResult[0] ?? $statusKerjaResult['0'] ?? 0), // Belum Bekerja
        ];

        // 4a. Rata-rata waktu mendapat kerja (dalam bulan) — gunakan field `waktu_tunggu` dari Kuisioner
        $avgTimeRaw = Kuisioner::whereIn('user_id', $alumniUserIds)
                        ->whereNotNull('waktu_tunggu')
                        ->where('waktu_tunggu', '!=', '')
                        ->avg(DB::raw('CAST(waktu_tunggu AS SIGNED)'));
        $avgTimeToJob = $avgTimeRaw ? round($avgTimeRaw, 1) : null;

        // 4b. Tingkat serapan kerja (%)
        $employabilityRate = 0;
        if ($totalAlumni > 0) {
            $employabilityRate = round((($statusKerja['1'] ?? 0) / $totalAlumni) * 100, 1);
        }

        // 4c. Responden baru 30 hari
        $recentRespondents30d = Kuisioner::whereIn('user_id', $alumniUserIds)
                                    ->where('created_at', '>=', now()->subDays(30))
                                    ->distinct('user_id')
                                    ->count('user_id');

        // 4d. Recent activity: gabungkan pengisian kuesioner dan pendaftaran alumni (urut berdasarkan waktu)
        $recentKuisioners = Kuisioner::whereIn('user_id', $alumniUserIds)
                                ->latest()
                                ->take(8)
                                ->get(['user_id', 'nama', 'created_at']);

        $recentAlumni = Alumni::where('jurusan', $prodiName)
                            ->latest()
                            ->take(6)
                            ->get(['nama', 'user_id', 'created_at']);

        $recentActivity = collect();
        foreach ($recentKuisioners as $k) {
            $recentActivity->push([
                'type' => 'kuisioner',
                'text' => ($k->nama ?? 'Pengguna') . ' mengisi kuesioner',
                'time' => $k->created_at->diffForHumans(),
                'ts' => $k->created_at->getTimestamp(),
            ]);
        }
        foreach ($recentAlumni as $a) {
            $recentActivity->push([
                'type' => 'alumni',
                'text' => ($a->nama ?? 'Alumni') . ' terdaftar',
                'time' => $a->created_at->diffForHumans(),
                'ts' => $a->created_at->getTimestamp(),
            ]);
        }

        // Urutkan berdasarkan timestamp dan ambil 8 teratas
        $recentActivity = $recentActivity->sortByDesc('ts')->values()->take(8)->map(function ($i) {
            return ['text' => $i['text'], 'time' => $i['time']];
        })->toArray();

        // 4. Agregasi data yang akan dikirim ke view
        $kaprodiData = [
            'prodi_name' => $prodiName,
            'total_alumni' => $totalAlumni,
            'total_responden' => $totalResponden,
            // Data Grafik
            'alumni_by_year' => $alumniByYear,
            'status_kerja' => $statusKerja,
            // Additional insights
            'avg_time_to_job' => $avgTimeToJob,
            'employability_rate' => $employabilityRate,
            'recent_respondents_30d' => $recentRespondents30d,
            'recent_activity' => $recentActivity,
        ];

        // 5. Tampilkan view dashboard Kaprodi
        return view('kaprodi.dashboard', compact('kaprodiData'));
    }

    /**
     * Tampilkan halaman bantuan/panduan untuk pengguna Kaprodi.
     */
    public function kaprodiHelp(Request $request)
    {
        // Asumsi view 'kaprodi.help' berisi FAQ, panduan penggunaan dashboard, dll.
        return view('kaprodi.help');
    }

    /**
     * Download printable checklist PDF for Kaprodi (guarded: requires barryvdh/laravel-dompdf).
     */
    public function kaprodiHelpPdf(Request $request)
    {
        // Blade view: resources/views/kaprodi/help-checklist.blade.php
        try {
            // 1) Preferred: facade if available
            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                // enable remote images (public_path) and HTML5 parser
                \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kaprodi.help-checklist');
                return $pdf->download('checklist-kaprodi.pdf');
            }

            // 2) If the package's binding exists in the container
            if (app()->bound('dompdf.wrapper')) {
                $pdf = app('dompdf.wrapper');
                if (method_exists($pdf, 'setOptions')) {
                    $pdf->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
                }
                $pdf->loadView('kaprodi.help-checklist');
                return $pdf->download('checklist-kaprodi.pdf');
            }

            // 3) Fallback: use Dompdf directly (if installed)
            if (class_exists(\Dompdf\Dompdf::class)) {
                $html = view('kaprodi.help-checklist')->render();
                $options = new \Dompdf\Options();
                $options->set('isRemoteEnabled', true);
                $dompdf = new \Dompdf\Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $output = $dompdf->output();
                return response($output, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="checklist-kaprodi.pdf"',
                ]);
            }
        } catch (\Throwable $e) {
            // Log the error for debugging
            logger()->error('kaprodiHelpPdf error: ' . $e->getMessage());
        }

        return redirect()->route('kaprodi.help')->with('error', 'PDF export tidak tersedia — instal DomPDF atau hubungi tim IT.');
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
