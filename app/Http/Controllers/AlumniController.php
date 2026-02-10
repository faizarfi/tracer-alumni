<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Concerns\PdfGenerator;

// Controller untuk mengelola data Alumni (user & admin)
class AlumniController extends Controller
{
    use PdfGenerator;
    # Fungsi untuk menghapus alumni
    # Menangani: destroy($user_id)
    public function destroy($user_id)
    {
        try {
            $alumni = Alumni::where('user_id', $user_id)->firstOrFail();

            // Hapus foto profil jika ada
            if ($alumni->foto_path) {
                Storage::disk('public')->delete($alumni->foto_path);
            }

            $alumni->delete();

            return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni')->with('error', 'Gagal menghapus data alumni: ' . $e->getMessage());
        }
    }

    # Menangani: form() - tampilkan form profil alumni untuk user
    public function form()
    {
        $alumni = Alumni::where('user_id', Auth::id())->first() ?? tap(new Alumni(), fn($a) => $a->user_id = Auth::id());

        $faculties = Faculty::orderBy('name')->get();
        $programs = Program::with('faculty')->orderBy('name')->get();

        $jurusanOptions = $programs->groupBy(fn($p) => $p->faculty?->name ?? 'Lainnya')
            ->map(fn($group) => $group->pluck('name')->all())
            ->all();

        return view('user.alumni-form', compact('alumni', 'faculties', 'jurusanOptions'));
    }

    /**
     * Menyimpan atau memperbarui profil alumni (SISI USER)
     */
    # Menangani: save(Request $request) - simpan/perbarui profil alumni
    public function save(Request $request)
    {
        // Tentukan aturan validasi
        $rules = [
            'nama'              => 'required|string|max:255',
            'nim'               => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'asal'              => 'required|string|max:255',
            'nomor_telepon'     => ['required','string','max:14','not_regex:/-/'],
            'jurusan'           => 'required|string|max:255',
            'fakultas'          => 'required|string|max:255',
            'sudah_bekerja'     => 'required|boolean',
            'tempat_bekerja'    => 'required_if:sudah_bekerja,1|nullable|string|max:255',
            'tahun_masuk'       => 'required|integer|min:1950|max:' . date('Y'),
            'tahun_keluar'      => 'required|integer|min:1950|max:' . (date('Y') + 5),
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max

            'testimonial_quote' => 'nullable|string|max:500',
            'request_publish'   => 'nullable|boolean',
        ];

        // Validasi data
        $validatedData = $request->validate($rules);
        $alumni = Alumni::firstOrNew(['user_id' => Auth::id()]);
        $successMessage = 'Profil berhasil disimpan/diperbarui.';

        try {
            DB::beginTransaction();

                // 1. Penanganan Foto Profil
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($alumni->foto_path) {
                    Storage::disk('public')->delete($alumni->foto_path);
                }
                // Simpan foto baru ke folder alumni_photos di disk 'public'
                $path = $request->file('foto')->store('alumni_photos', 'public');
                $alumni->foto_path = $path;
            }

            // 2. Penanganan Data Profil Utama
            $alumni->fill($validatedData);
            $alumni->user_id = Auth::id();
            $alumni->tempat_bekerja = $validatedData['sudah_bekerja'] == 1 ? $validatedData['tempat_bekerja'] : null;

            // 3. LOGIKA PENANGANAN STATUS TESTIMONI
            $quote = trim($request->testimonial_quote);
            $requestPublish = $request->boolean('request_publish');

            // Simpan status lama sebelum update
            $oldStatus = $alumni->testimonial_status;

            if (!empty($quote)) {
                // Periksa apakah kutipan berubah (untuk memicu review ulang)
                $isQuoteChanged = $alumni->testimonial_quote !== $quote;
                $alumni->testimonial_quote = $quote;

                if ($requestPublish) {
                    // Jika user meminta publikasi
                    if ($oldStatus === 'approved' && !$isQuoteChanged) {
                        // Quote tidak berubah & sudah approved: Biarkan status tetap approved
                        $alumni->testimonial_status = 'approved';
                        $successMessage .= ' Testimoni Anda sudah disetujui dan tetap tampil.';
                    } else {
                        // Quote berubah ATAU status BUKAN approved: Minta review ulang (pending)
                        $alumni->testimonial_status = 'pending';
                        $successMessage .= ' Testimoni baru Anda berhasil dikirim dan menunggu persetujuan Admin.';
                    }
                } else {
                    // Jika user tidak meminta publikasi: set status 'rejected'
                    $alumni->testimonial_status = 'rejected';
                    $successMessage .= ' Testimoni Anda disimpan sebagai draft (tidak dipublikasi).';
                }
            } else {
                // Jika quote dikosongkan, reset status dan quote
                $alumni->testimonial_quote = null;
                $alumni->testimonial_status = 'rejected';
            }

            $alumni->save();
            DB::commit();

            return redirect()->route('user.profil')->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // =========================================================
    // METODE BARU UNTUK KAPRODI
    // =========================================================

    /**
     * Menampilkan data alumni yang difilter khusus untuk Program Studi Kaprodi.
     */
    // Menangani: kaprodiAlumni(Request $request) - daftar alumni untuk Kaprodi
    public function kaprodiAlumni(Request $request)
    {
        // Mendapatkan Program Studi Kaprodi yang sedang login
        $prodi = Auth::user()->prodi ?? 'Program Studi Tidak Ditemukan';

        // Hanya ambil data alumni dari Program Studi yang bersangkutan (kolom: jurusan)
        $query = Alumni::where('jurusan', $prodi);

        // Filter: Pencarian berdasarkan nama atau NIM
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('nim', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter: Berdasarkan tahun lulus
        if ($request->filled('tahun')) {
            $query->where('tahun_keluar', $request->tahun);
        }

        // Filter: Status Karir (sudah bekerja / belum)
        $statusKerja = $request->input('status_kerja');
        if ($statusKerja !== null && $statusKerja !== '') {
            $query->where('sudah_bekerja', (int) $statusKerja);
        }

        // Ambil data untuk pagination
        $alumniData = $query->orderBy('tahun_keluar', 'desc')->paginate(15)->appends($request->query());

        // Mengambil daftar unik tahun lulus untuk filter dropdown
        $availableYears = Alumni::select('tahun_keluar')
            ->distinct()
            ->where('jurusan', $prodi) // Tetap filter berdasarkan prodi yang login
            ->orderBy('tahun_keluar', 'desc')
            ->pluck('tahun_keluar');

        // Menggunakan view yang sudah dibuat (kaprodi/data-alumni.blade.php)
        return view('kaprodi.data-alumni', compact('alumniData', 'prodi', 'availableYears'));
    }

    /**
     * Ekspor data alumni khusus untuk Kaprodi (filter berdasarkan prodi yang login)
     */
    // Menangani: kaprodiExportPdf(Request $request) - ekspor PDF alumni untuk Kaprodi
    public function kaprodiExportPdf(Request $request)
    {
        $prodi = Auth::user()->prodi ?? null;

        $query = Alumni::query();
        if ($prodi) {
            $query->where('jurusan', $prodi);
        }

        $alumnis = $query->orderBy('nama')->get();

        // Hitung statistik status karir untuk laporan
        $countTotal = $alumnis->count();
        $countBekerja = $alumnis->where('sudah_bekerja', 1)->count();
        $countBelum = $countTotal - $countBekerja;

        // Persentase (satu desimal)
        $percentBekerja = $countTotal ? round(($countBekerja / $countTotal) * 100, 1) : 0;
        $percentBelum = $countTotal ? round(($countBelum / $countTotal) * 100, 1) : 0;

        $data = compact('alumnis', 'prodi', 'countTotal', 'countBekerja', 'countBelum', 'percentBekerja', 'percentBelum');

        try {
            return $this->generatePdf('admin.alumni-pdf', $data, 'data_alumni_' . date('Ymd_His') . '.pdf');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Fitur PDF belum tersedia. Jalankan: composer require barryvdh/laravel-dompdf.');
        }
    }

    // =========================================================
    // METODE LAMA (ADMIN & USER)
    // =========================================================

    // Menampilkan daftar alumni untuk admin
    // Menangani: index(Request $request) - daftar alumni (admin)
    public function index(Request $request)
    {
        $query = Alumni::query();

        // --- FILTERING LOGIC ---

        // 1. Filter Pencarian Teks
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                    ->orWhere('nim', 'like', '%' . $request->cari . '%')
                    ->orWhere('jurusan', 'like', '%' . $request->cari . '%')
                    ->orWhere('fakultas', 'like', '%' . $request->cari . '%');
            });
        }

        // 2. Filter Status Bekerja
        $statusKerja = $request->input('status_kerja');
        if ($statusKerja !== null && $statusKerja !== '') {
            $query->where('sudah_bekerja', (int)$statusKerja);
        }

        // --- SORTING LOGIC ---

        $allowedSorts = ['nama', 'nim', 'fakultas', 'tahun_masuk', 'tahun_keluar', 'sudah_bekerja'];
        $sortBy = $request->input('sort', 'tahun_keluar'); // Default sorting: Tahun Lulus
        $direction = $request->input('direction', 'desc'); // Default direction: Descending

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $direction);
        } else {
            $query->orderBy('tahun_keluar', 'desc');
        }

        $alumnis = $query->paginate(10)->appends($request->query());

        // Ambil daftar fakultas untuk filter
        $faculties = \App\Models\Faculty::orderBy('name')->get();

        return view('admin.alumni-index', compact('alumnis', 'faculties'));
    }

    // Fungsi untuk pencarian alumni dari sisi user
    // Menangani: search(Request $request) - pencarian alumni (user)
    public function search(Request $request)
    {
        $query = $request->input('query');
        $fakultas = $request->input('fakultas');
        $status = $request->input('status'); // nilai 1 atau 0

        // Tambahan filter Tahun Masuk/Lulus dari view Cari Alumni
        $tahunMasuk = $request->input('tahun_masuk');
        $tahunLulus = $request->input('tahun_keluar');


        $alumniQuery = Alumni::query();

        // Jika ada input pencarian teks
        if ($query) {
            $alumniQuery->where(function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                    ->orWhere('nim', 'like', "%{$query}%")
                    ->orWhere('jurusan', 'like', "%{$query}%")
                    ->orWhere('fakultas', 'like', "%{$query}%");
            });
        }

        // Filter fakultas
        if ($fakultas && $fakultas !== 'Filter Fakultas') {
            $alumniQuery->where('fakultas', $fakultas);
        }

        // Filter status sudah bekerja
        if ($status !== null && in_array($status, ['0', '1'], true)) {
            $alumniQuery->where('sudah_bekerja', $status);
        }

        // Filter Tahun Masuk
        if ($tahunMasuk) {
            $alumniQuery->where('tahun_masuk', (int)$tahunMasuk);
        }

        // Filter Tahun Lulus
        if ($tahunLulus) {
            $alumniQuery->where('tahun_keluar', (int)$tahunLulus);
        }

        // Catatan: Di sisi user/publik, mungkin Anda hanya ingin menampilkan alumni yang datanya lengkap,
        // tetapi untuk fungsi pencarian, kita biarkan saja.

        $alumni = $alumniQuery->get();

        return view('user.cari-alumni', compact('query', 'fakultas', 'status', 'alumni'));
    }


    // Statistik alumni bekerja dan belum bekerja
    // Menangani: statistics(Request $request)
    public function statistics(Request $request)
    {
        $workingStats = Alumni::select(
            DB::raw('IF(sudah_bekerja = 1, "Bekerja", "Belum Bekerja") as status'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('status')
            ->get();

        return view('admin.alumni-statistics', compact('workingStats'));
    }

    // Menampilkan form untuk mengedit data alumni
    // Menangani: edit($user_id) - tampilkan form edit (admin)
    public function edit($user_id)
    {
        $alumni = Alumni::where('user_id', $user_id)->firstOrFail();

        $faculties = \App\Models\Faculty::orderBy('name')->get();
        $programs = \App\Models\Program::orderBy('name')->get();

        return view('admin.alumni-edit', compact('alumni', 'faculties', 'programs'));
    }

    // Fungsi untuk update data alumni (SISI ADMIN)
    // Menangani: update(Request $request, $user_id) - update data alumni (admin)
    public function update(Request $request, $user_id)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'nim'               => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'asal'              => 'required|string|max:255',
            'nomor_telepon'     => ['required','string','max:14','not_regex:/-/'],
            'jurusan'           => 'required|string|max:255',
            'fakultas'          => 'required|string|max:255',
            'sudah_bekerja'     => 'required|boolean',
            'tempat_bekerja'    => 'nullable|string|max:255',
            'tahun_masuk'       => 'required|integer|min:1950|max:' . date('Y'),
            'tahun_keluar'      => 'required|integer|min:1950|max:' . (date('Y') + 5),
            // Admin tidak mengelola foto di sini
        ]);

        try {
            $alumni = Alumni::where('user_id', $user_id)->firstOrFail();

            // Siapkan data untuk update
            $updateData = $request->only([
                'nama', 'nim', 'tanggal_lahir', 'asal', 'nomor_telepon', 'jurusan', 'fakultas',
                'sudah_bekerja', 'tempat_bekerja', 'tahun_masuk', 'tahun_keluar'
            ]);

            $alumni->update($updateData);

            return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni')->with('error', 'Gagal memperbarui data alumni: ' . $e->getMessage());
        }
    }

    // Fungsi untuk ekspor alumni ke CSV
    // Menangani: exportCsv() - ekspor data alumni ke CSV
    public function exportCsv()
    {
        $alumnis = Alumni::all();

        $filename = 'data_alumni.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($alumnis) {
            $file = fopen('php://output', 'w');

            // Header kolom diperbarui (Ditambahkan kolom status testimoni)
            fputcsv($file, [
                'Nama', 'NIM', 'Tanggal Lahir', 'Tahun Masuk', 'Tahun Keluar', 'Asal',
                'Jurusan', 'Fakultas', 'Sudah Bekerja', 'Tempat Bekerja',
                'Testimoni', 'Status Testimoni', 'Foto Path'
            ]);

            // Isi data diperbarui
            foreach ($alumnis as $alumni) {
                fputcsv($file, [
                    $alumni->nama,
                    $alumni->nim,
                    $alumni->tanggal_lahir,
                    $alumni->tahun_masuk,
                    $alumni->tahun_keluar,
                    $alumni->asal,
                    $alumni->jurusan,
                    $alumni->fakultas,
                    $alumni->sudah_bekerja ? 'Ya' : 'Tidak',
                    $alumni->tempat_bekerja ?? '-',
                    $alumni->testimonial_quote ?? '-', // Data Testimoni
                    $alumni->testimonial_status ?? 'N/A', // Status Testimoni
                    $alumni->foto_path ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor data alumni menjadi PDF.
     * Menggunakan package barryvdh/laravel-dompdf jika tersedia.
     */
    public function exportPdf(Request $request)
    {
        // Ambil data (respek ke request filters jika ada)
        $query = Alumni::query();
        if ($request->filled('status_kerja')) {
            $query->where('sudah_bekerja', (int)$request->input('status_kerja'));
        }
        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->where(function($qq) use ($q) {
                $qq->where('nama', 'like', "%{$q}%")
                   ->orWhere('nim', 'like', "%{$q}%");
            });
        }

        $alumnis = $query->orderBy('nama')->get();

        // Statistik untuk header (mirip kaprodiExportPdf)
        $countTotal = $alumnis->count();
        $countBekerja = $alumnis->where('sudah_bekerja', 1)->count();
        $countBelum = $countTotal - $countBekerja;
        $percentBekerja = $countTotal ? round(($countBekerja / $countTotal) * 100, 1) : 0;
        $percentBelum = $countTotal ? round(($countBelum / $countTotal) * 100, 1) : 0;

        $data = compact('alumnis', 'countTotal', 'countBekerja', 'countBelum', 'percentBekerja', 'percentBelum');

        try {
            return $this->generatePdf('admin.alumni-pdf', $data, 'data_alumni_' . date('Ymd_His') . '.pdf');
        } catch (\Throwable $e) {
            return view('admin.alumni-pdf', $data);
        }
    }

    // PDF generation provided by PdfGenerator trait

    // =========================================================
    // ADMINISTRASI TESTIMONI BARU (Menggunakan status ENUM)
    // =========================================================

    /**
     * Menampilkan daftar testimoni yang statusnya 'pending'.
     */
    public function reviewTestimonials()
    {
        $testimonialsToReview = Alumni::where('testimonial_status', 'pending')
                                            ->whereNotNull('testimonial_quote')
                                            ->latest()
                                            ->paginate(10);

        return view('admin.testimonial-review', compact('testimonialsToReview'));
    }

    /**
     * Menampilkan daftar testimoni yang statusnya 'approved'.
     */
    public function approvedTestimonials()
    {
        $testimonialsApproved = Alumni::where('testimonial_status', 'approved')
                                            ->whereNotNull('testimonial_quote')
                                            ->latest()
                                            ->paginate(10);

        return view('admin.testimonial-approved', compact('testimonialsApproved'));
    }

    /**
     * Menampilkan daftar testimoni yang statusnya 'rejected'.
     */
    public function rejectedTestimonials()
    {
        $testimonialsRejected = Alumni::where('testimonial_status', 'rejected')
                                            ->whereNotNull('testimonial_quote')
                                            ->latest()
                                            ->paginate(10);

        return view('admin.testimonial-rejected', compact('testimonialsRejected'));
    }


    /**
     * Menyetujui testimoni (mengubah status menjadi 'approved').
     */
    public function approveTestimonial($user_id)
    {
        try {
            $alumni = Alumni::where('user_id', $user_id)->firstOrFail();
            $alumni->testimonial_status = 'approved';
            $alumni->save();
            return redirect()->route('admin.testimonials.approved')->with('success', 'Testimoni berhasil disetujui dan dipublikasikan.');
        } catch (\Exception $e) {
            logger()->error('approveTestimonial error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui testimoni.');
        }
    }

    /**
     * Menolak testimoni (mengubah status menjadi 'rejected').
     * Digunakan sebagai aksi "Tolak" dari halaman Review, atau "Tarik Publikasi" dari halaman Approved.
     */
    public function rejectTestimonial($user_id)
    {
        try {
            $alumni = Alumni::where('user_id', $user_id)->firstOrFail();
            $previousStatus = $alumni->testimonial_status;
            $alumni->testimonial_status = 'rejected';
            $alumni->save();
            $redirectTo = ($previousStatus === 'approved') ? 'admin.testimonials.approved' : 'admin.testimonials.rejected';
            $message = ($previousStatus === 'approved') ? 'Publikasi testimoni berhasil ditarik.' : 'Testimoni berhasil ditolak.';
            return redirect()->route($redirectTo)->with('success', $message);
        } catch (\Exception $e) {
            logger()->error('rejectTestimonial error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak testimoni.');
        }
    }

    /**
     * Digunakan ketika admin ingin mengembalikan dari Rejected atau Approved ke Review.
     */
    public function pendingTestimonial($user_id)
    {
        try {
            $alumni = Alumni::where('user_id', $user_id)->firstOrFail();
            $alumni->testimonial_status = 'pending';
            $alumni->save();
            return redirect()->route('admin.testimonials.review')->with('success', 'Testimoni berhasil dikembalikan ke daftar Review.');
        } catch (\Exception $e) {
            logger()->error('pendingTestimonial error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengembalikan testimoni.');
        }
    }
}
