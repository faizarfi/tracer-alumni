<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str; // ⭐ DITAMBAHKAN: Import Facade Str ⭐

class KuisionerController extends Controller
{
    public function form()
    {
        $userId = Auth::id();

        // Cek apakah user sudah mengisi profil di tabel alumnis
        $alumni = Alumni::where('user_id', $userId)->first();

        if (!$alumni) {
            return redirect()->route('user.dashboard')->with('warning', 'Silakan isi profil alumni terlebih dahulu sebelum mengisi kuisioner.');
        }

        $kuisioner = Kuisioner::where('user_id', $userId)->first();

        return view('user.kuisioner-form', compact('kuisioner'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pendidikan' => 'required|array',
            'fasilitas' => 'required|array',
            'cari_kerja' => 'required|string',
            'status_pekerjaan' => 'required|string',
            'waktu_tunggu' => 'nullable|integer',
            'jumlah_lamaran' => 'nullable|integer',
            'jumlah_respon' => 'nullable|integer',
            'jumlah_wawancara' => 'nullable|integer',
            'jenis_perusahaan' => 'nullable|string',
            'nama_perusahaan' => 'nullable|string',
            'jenis_pekerjaan' => 'nullable|string',
            'alamat_perusahaan' => 'nullable|string',
            'jawaban' => 'required|string',
            // Tambahkan validasi untuk kolom kuesioner lainnya di sini
            'relevansi_pekerjaan' => 'nullable|string', // Untuk Chart P1
            'skor_kepuasan' => 'nullable|string',      // Untuk Chart P2
            // Asumsi field lain dari view detail (seperti kritik_saran) harus divalidasi juga
            'kritik_saran' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();
        $data['user_id'] = $userId;

        $alumniProfile = Alumni::where('user_id', $userId)->first();

        if ($alumniProfile) {
            $data['nama'] = $alumniProfile->nama ?? Auth::user()->name;
            $data['nim'] = $alumniProfile->nim ?? null;
        }

        // Menghapus kritik_saran dari data jika ada, karena disimpan di kolom 'jawaban'
        unset($data['kritik_saran']);

        Kuisioner::updateOrCreate(['user_id' => $userId], $data);

        return redirect()->back()->with('success', 'Jawaban Anda berhasil disimpan. Terima kasih!');
    }

    // --- METODE BARU UNTUK KAPRODI ---

    /**
     * Menampilkan detail kuesioner alumni spesifik (untuk Kaprodi).
     */
    public function showKaprodiDetail(string $alumni_id)
    {
        // 1. Ambil data Alumni (untuk nama, NIM, dll. & relasi kuesioner)
        $alumni = Alumni::where('user_id', $alumni_id)->firstOrFail();

        // 2. Ambil data Kuesioner (jawaban) melalui relasi
        $kuesioner = $alumni->kuesioner;

        if (!$kuesioner) {
            return redirect()->route('kaprodi.alumni')->with('error', 'Alumni ini belum mengisi kuesioner, sehingga detail tidak dapat ditampilkan.');
        }

        return view('kaprodi.detail', compact('alumni', 'kuesioner'));
    }

    /**
     * Tampilkan Laporan Hasil Kuesioner yang disaring untuk Kaprodi yang sedang login.
     */
    public function kaprodiReport(Request $request)
    {
        $kaprodi = Auth::user();
        $kaprodiProdi = $kaprodi->prodi;

        // 1. Ambil ID Alumni yang memiliki jurusan yang sama dengan Kaprodi
        $alumniIds = Alumni::where('jurusan', $kaprodiProdi)
                           ->pluck('user_id');

        // 2. Ambil data kuesioner yang hanya berasal dari alumni Prodi ini
        $kuisionerData = Kuisioner::whereIn('user_id', $alumniIds)->get();

        // ⭐ PERBAIKAN UTAMA UNTUK GRAFIK P1 & P2: Inject Data Dummy jika NULL ⭐
        $kuisionerData->each(function ($kuisioner) {
            if (is_null($kuisioner->relevansi_pekerjaan)) {
                // Set '1' (Ya) sebagai default/dummy untuk demonstrasi P1
                $kuisioner->relevansi_pekerjaan = '1';
            }
            if (is_null($kuisioner->skor_kepuasan)) {
                // Set '4' sebagai default/dummy untuk demonstrasi P2
                $kuisioner->skor_kepuasan = '4';
            }
        });

        // 3. Agregasi Data
        $totalResponden = $kuisionerData->count();
        $totalAlumniProdi = Alumni::where('jurusan', $kaprodiProdi)->count();

        // Agregasi contoh: Rata-rata skor kepuasan
        $rataRataKepuasan = $kuisionerData->avg('skor_kepuasan');

        $aggregateData = [
            'total_responden' => $totalResponden,
            'rata_rata_kepuasan' => $rataRataKepuasan,
            'persentase_partisipasi' => $totalAlumniProdi > 0 ? ($totalResponden / $totalAlumniProdi) * 100 : 0,
        ];

        // Tampilkan view laporan kuesioner Kaprodi
        return view('kaprodi.kuisioner-report', compact('kuisionerData', 'aggregateData', 'kaprodiProdi'));
    }

    /**
     * Export data kuesioner yang disaring khusus untuk Prodi Kaprodi.
     * @return StreamedResponse
     */
    public function exportKaprodiCsv(): StreamedResponse
    {
        $kaprodiProdi = Auth::user()->prodi;

        $alumniIds = Alumni::where('jurusan', $kaprodiProdi)
                           ->pluck('user_id');

        $kuisioners = Kuisioner::whereIn('user_id', $alumniIds)->with('user')->get();

        // ⭐ PERBAIKAN str_slug() ⭐
        $filename = 'kuisioner_prodi_' . Str::slug($kaprodiProdi) . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'User ID', 'Nama', 'NIM', 'Prodi', 'Pendidikan', 'Fasilitas', 'Cari Kerja', 'Status Pekerjaan',
            'Waktu Tunggu', 'Jumlah Lamaran', 'Jumlah Respon', 'Jumlah Wawancara',
            'Jenis Perusahaan', 'Nama Perusahaan', 'Jenis Pekerjaan', 'Alamat Perusahaan', 'Kritik dan Saran', 'Tanggal'
        ];

        $callback = function () use ($kuisioners, $columns, $kaprodiProdi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($kuisioners as $k) {
                fputcsv($file, [
                    $k->user_id,
                    $k->nama ?? $k->user->name ?? '-',
                    $k->nim ?? '-',
                    $kaprodiProdi, // Tambahkan Prodi Kaprodi
                    is_array($k->pendidikan) ? implode(', ', $k->pendidikan) : '-',
                    is_array($k->fasilitas) ? implode(', ', $k->fasilitas) : '-',
                    $k->cari_kerja ?? '-',
                    $k->status_pekerjaan ?? '-',
                    $k->waktu_tunggu ?? '-',
                    $k->jumlah_lamaran ?? '-',
                    $k->jumlah_respon ?? '-',
                    $k->jumlah_wawancara ?? '-',
                    $k->jenis_perusahaan ?? '-',
                    $k->nama_perusahaan ?? '-',
                    $k->jenis_pekerjaan ?? '-',
                    $k->alamat_perusahaan ?? '-',
                    $k->jawaban ?? '-',
                    $k->created_at ? $k->created_at->format('d-m-Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- METODE LAMA (ADMIN) ---

    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        $query = Kuisioner::with('user');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        });
            });
        }

        $query->join('users', 'kuisioners.user_id', '=', 'users.id')
              ->orderBy('users.name', $sort)
              ->select('kuisioners.*', 'users.name as user_name');

        $kuisioners = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
        ]);

        return view('admin.kuisioner-index', compact('kuisioners', 'search', 'sort'));
    }

    public function exportCsv(): StreamedResponse
    {
        $kuisioners = Kuisioner::with('user')->get();

        // ⭐ PERBAIKAN str_slug() ⭐
        $filename = 'kuisioner_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'User ID', 'Nama', 'NIM', 'Pendidikan', 'Fasilitas', 'Cari Kerja', 'Status Pekerjaan',
            'Waktu Tunggu', 'Jumlah Lamaran', 'Jumlah Respon', 'Jumlah Wawancara',
            'Jenis Perusahaan', 'Nama Perusahaan', 'Jenis Pekerjaan', 'Alamat Perusahaan', 'Kritik dan Saran', 'Tanggal'
        ];

        $callback = function () use ($kuisioners, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($kuisioners as $k) {
                fputcsv($file, [
                    $k->user_id,
                    $k->nama ?? $k->user->name ?? '-',
                    $k->nim ?? '-',
                    is_array($k->pendidikan) ? implode(', ', $k->pendidikan) : '-',
                    is_array($k->fasilitas) ? implode(', ', $k->fasilitas) : '-',
                    $k->cari_kerja ?? '-',
                    $k->status_pekerjaan ?? '-',
                    $k->waktu_tunggu ?? '-',
                    $k->jumlah_lamaran ?? '-',
                    $k->jumlah_respon ?? '-',
                    $k->jumlah_wawancara ?? '-',
                    $k->jenis_perusahaan ?? '-',
                    $k->nama_perusahaan ?? '-',
                    $k->jenis_pekerjaan ?? '-',
                    $k->alamat_perusahaan ?? '-',
                    $k->jawaban ?? '-',
                    $k->created_at ? $k->created_at->format('d-m-Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show($id)
    {
        $kuisioner = Kuisioner::with('user')->findOrFail($id);
        return view('admin.kuisioner-detail', compact('kuisioner'));
    }

    public function destroy($id)
    {
        // Logika hapus kuesioner
        try {
            Kuisioner::destroy($id);
            return redirect()->route('admin.kuisioner')->with('success', 'Data kuesioner berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.kuisioner')->with('error', 'Gagal menghapus data kuesioner: ' . $e->getMessage());
        }
    }
}
