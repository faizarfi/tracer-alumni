<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    // Fungsi untuk menghapus alumni
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

    // Menampilkan form profil alumni
    public function form()
    {
        // Cari data Alumni berdasarkan user_id.
        $alumni = Alumni::where('user_id', Auth::id())->first();

        // --- PERBAIKAN LOGIKA INI ---
        // Jika tidak ditemukan, buat objek Alumni baru (kosong) agar view tidak error
        if (!$alumni) {
            $alumni = new Alumni();
            // Opsional: Isi user_id agar tombol save/update tahu relasi ID saat pertama kali diisi
            $alumni->user_id = Auth::id();
        }

        // Memuat view yang benar: user.alumni-form
        return view('user.alumni-form', compact('alumni'));
    }

    /**
     * Menyimpan atau memperbarui profil alumni (SISI USER)
     */
    public function save(Request $request)
    {
        // Tentukan aturan validasi
        $rules = [
            'nama'              => 'required|string|max:255',
            'nim'               => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'asal'              => 'required|string|max:255',
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
            $alumni->tempat_bekerja = ($validatedData['sudah_bekerja'] == 1) ? $validatedData['tempat_bekerja'] : null;

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
            // Log::error("Error saving alumni profile: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. Debug: ' . $e->getMessage());
        }
    }

    // Menampilkan daftar alumni untuk admin
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

        return view('admin.alumni-index', compact('alumnis'));
    }

    // Fungsi untuk pencarian alumni dari sisi user
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
    public function edit($user_id)
    {
        $alumni = Alumni::where('user_id', $user_id)->firstOrFail();
        return view('admin.alumni-edit', compact('alumni'));
    }

    // Fungsi untuk update data alumni (SISI ADMIN)
    public function update(Request $request, $user_id)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'nim'               => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'asal'              => 'required|string|max:255',
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
                'nama', 'nim', 'tanggal_lahir', 'asal', 'jurusan', 'fakultas',
                'sudah_bekerja', 'tempat_bekerja', 'tahun_masuk', 'tahun_keluar'
            ]);

            $alumni->update($updateData);

            return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.alumni')->with('error', 'Gagal memperbarui data alumni: ' . $e->getMessage());
        }
    }

    // Fungsi untuk ekspor alumni ke CSV
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

    // =========================================================
    // ADMINISTRASI TESTIMONI BARU (Menggunakan status ENUM)
    // =========================================================

    /**
     * Menampilkan daftar testimoni yang statusnya 'pending'.
     */
    public function reviewTestimonials()
    {
        // FIX: Tambahkan reorder untuk mengatasi masalah caching/ordering database
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

            // Perbarui status menjadi 'approved'
            $alumni->testimonial_status = 'approved';
            $alumni->save(); // MENGGUNAKAN SAVE() UNTUK MEMASTIKAN UPDATE BERHASIL

            // REDIRECT HARUS KE HALAMAN TUJUAN (Approved)
            return redirect()->route('admin.testimonials.approved')->with('success', 'Testimoni berhasil disetujui dan dipublikasikan. Ia kini berada di daftar Disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyetujui testimoni. Debug: ' . $e->getMessage());
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

            // Ambil status sebelum update untuk menentukan redirect
            $previousStatus = $alumni->testimonial_status;

            // Perbarui status menjadi 'rejected'
            $alumni->testimonial_status = 'rejected';
            $alumni->save(); // MENGGUNAKAN SAVE() UNTUK MEMASTIKAN UPDATE BERHASIL

            // Menentukan redirect: Jika sebelumnya approved (aksi Tarik Publikasi),
            // redirect kembali ke halaman Approved. Jika tidak, redirect ke Rejected.
            $redirectTo = ($previousStatus === 'approved')
                                ? 'admin.testimonials.approved'
                                : 'admin.testimonials.rejected';

            $message = ($previousStatus === 'approved')
                        ? 'Publikasi testimoni berhasil ditarik dan dipindahkan ke daftar Ditolak.'
                        : 'Testimoni berhasil ditolak dan dipindahkan ke daftar Ditolak.';

            return redirect()->route($redirectTo)->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak testimoni. Debug: ' . $e->getMessage());
        }
    }
}   
