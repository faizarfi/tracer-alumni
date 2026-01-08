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

        // Hitung agregat tanpa menyisipkan nilai dummy.
        // 3. Agregasi Data
        $totalResponden = $kuisionerData->count();
        $totalAlumniProdi = Alumni::where('jurusan', $kaprodiProdi)->count();

        // Robust parsing: terima numeric string, JSON-encoded, teks berlabel, atau ambil dari bidang `jawaban`
        $validScores = $kuisionerData->map(function ($k) {
            $v = $k->skor_kepuasan;

            // Helper untuk mapping label teks ke angka (Indonesia)
            $mapLabel = function ($s) {
                if ($s === null) return null;
                $t = strtolower(trim((string) $s));
                $mapping = [
                    'sangat puas' => 5, 'sangat puas sekali' => 5, 'sangat puas.' => 5,
                    'puas' => 4, 'cukup puas' => 4,
                    'cukup' => 3, 'cukup puas.' => 3,
                    'kurang' => 2, 'tidak' => 1, 'tidak puas' => 1,
                    'tidak sama sekali' => 1,
                ];
                foreach ($mapping as $kmap => $val) {
                    if (strpos($t, $kmap) !== false) return $val;
                }
                return null;
            };

            // Jika sudah ada dan bernilai
            if ($v !== null && $v !== '') {
                if (is_numeric($v)) return (float) $v;
                if (is_string($v) && preg_match('/\d+(?:\.\d+)?/', $v, $m)) return (float) $m[0];
                $mapped = $mapLabel($v);
                if ($mapped) return (float) $mapped;
                // coba decode JSON jika ada
                if (is_string($v) && (str_starts_with($v, '[') || str_starts_with($v, '{'))) {
                    $decoded = json_decode($v, true);
                    if (is_numeric($decoded)) return (float) $decoded;
                    if (is_array($decoded)) {
                        foreach ($decoded as $item) {
                            if (is_numeric($item)) return (float) $item;
                            $mapped = $mapLabel($item);
                            if ($mapped) return (float) $mapped;
                        }
                    }
                }
            }

            // Jika tidak ada di kolom skor_kepuasan, coba ambil dari kolom `jawaban`
            $jaw = $k->jawaban ?? null;
            if ($jaw) {
                if (is_string($jaw)) {
                    // Jika JSON-encoded, traverse untuk cari kunci yang mengandung 'skor' atau 'kepuasan'
                    $decoded = json_decode($jaw, true);
                    if (is_array($decoded)) {
                        // cari langsung dengan beberapa kemungkinan key
                        $keys = ['skor_kepuasan','skor','kepuasan','kepuasan_skor','nilai_kepuasan'];
                        foreach ($keys as $key) {
                            if (isset($decoded[$key])) {
                                $cand = $decoded[$key];
                                if (is_numeric($cand)) return (float) $cand;
                                $mapped = $mapLabel($cand);
                                if ($mapped) return (float) $mapped;
                                if (is_string($cand) && preg_match('/\d+(?:\.\d+)?/', $cand, $m)) return (float) $m[0];
                            }
                        }
                        // jika belum ditemukan, cari secara rekursif nilai numerik atau label
                        $found = null;
                        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($decoded));
                        foreach ($iterator as $val) {
                            if (is_numeric($val)) { $found = (float) $val; break; }
                            $mapped = $mapLabel($val);
                            if ($mapped) { $found = (float) $mapped; break; }
                        }
                        if ($found !== null) return $found;
                    } else {
                        // plain text — cari angka atau label
                        if (preg_match('/\d+(?:\.\d+)?/', $jaw, $m)) return (float) $m[0];
                        $mapped = $mapLabel($jaw);
                        if ($mapped) return (float) $mapped;
                    }
                }
            }

            return null;
        })->filter();

        $rataRataKepuasan = $validScores->count() ? round($validScores->avg(), 2) : 0;

        // Untuk debugging: nilai unik yang tersimpan di DB untuk kolom skor_kepuasan
        $distinctScores = $kuisionerData->pluck('skor_kepuasan')->unique()->values()->all();
        // Nilai unik untuk kolom relevansi_pekerjaan (bisa berupa '1','0','Ya','Tidak', dsb.)
        $distinctRelevansi = $kuisionerData->pluck('relevansi_pekerjaan')->unique()->values()->all();

        $aggregateData = [
            'total_responden' => $totalResponden,
            'rata_rata_kepuasan' => $rataRataKepuasan,
            'persentase_partisipasi' => $totalAlumniProdi > 0 ? ($totalResponden / $totalAlumniProdi) * 100 : 0,
            'distinct_skor_values' => $distinctScores,
            'distinct_relevansi_values' => $distinctRelevansi,
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
