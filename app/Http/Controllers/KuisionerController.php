<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        ]);

        $userId = Auth::id();
        $data['user_id'] = $userId;

        // 💡 PERBAIKAN: Ambil data nama dan nim dari tabel alumnis
        // Data ini sudah dipastikan ada di method form() di atas.
        $alumniProfile = Alumni::where('user_id', $userId)->first();

        if ($alumniProfile) {
            // Asumsi: Kolom 'nama' dan 'nim' diambil dari tabel alumni
            // Jika nama/nim ada di tabel users, gunakan: Auth::user()->name, Auth::user()->nim
            // Jika nama/nim ada di tabel alumnis, gunakan: $alumniProfile->nama, $alumniProfile->nim

            // Jika kolom 'nama' dan 'nim' di tabel kuisioners harus diisi,
            // dan datanya ada di tabel alumnis, lakukan injeksi berikut:
            $data['nama'] = $alumniProfile->nama ?? Auth::user()->name; // Coba ambil dari alumni, fallback ke user name
            $data['nim'] = $alumniProfile->nim ?? null; // Coba ambil nim dari alumni
        }
        // Note: Jika $alumniProfile tidak ditemukan, seharusnya user tidak bisa sampai sini
        // karena ada pengecekan di method form().

        // Check if the user already has a questionnaire, then update; otherwise, create new.
        Kuisioner::updateOrCreate(['user_id' => $userId], $data);

        return redirect()->back()->with('success', 'Jawaban Anda berhasil disimpan. Terima kasih!');
    }

    // ... sisa controller (form, adminIndex, show, destroy, exportCsv) ...

    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        // Menggunakan join di sini lebih kompleks jika kita ingin mencari kolom 'nama' atau 'nim'
        // yang ada di tabel 'kuisioners', bukan 'users'.
        // Namun, jika tujuannya hanya mencari berdasarkan nama user, kode ini sudah benar.

        $query = Kuisioner::with('user');

        if ($search) {
            $query->where(function ($query) use ($search) {
                // Mencari berdasarkan nama di tabel kuisioners
                $query->where('nama', 'like', '%' . $search . '%')
                      // atau mencari berdasarkan user name di tabel users (untuk kompatibilitas)
                      ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        });
            });
        }

        // Perubahan: Order By seharusnya bisa dilakukan langsung pada kolom 'nama' di tabel kuisioners
        // jika kolom tersebut diisi (seperti perbaikan di atas), tapi jika Anda ingin tetap
        // menggunakan join untuk sort:

        $query->join('users', 'kuisioners.user_id', '=', 'users.id')
              ->orderBy('users.name', $sort) // Tetap sort berdasarkan nama user
              ->select('kuisioners.*', 'users.name as user_name'); // Ambil kuisioners.* dan alias nama user

        $kuisioners = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
        ]);

        return view('admin.kuisioner-index', compact('kuisioners', 'search', 'sort'));
    }

    public function exportCsv(): StreamedResponse
    {
        $kuisioners = Kuisioner::with('user')->get();

        $filename = 'kuisioner_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // 💡 PERBAIKAN: Menambahkan kolom NIM
        $columns = [
            'User ID', 'Nama', 'NIM', 'Pendidikan', 'Fasilitas', 'Cari Kerja', 'Status Pekerjaan',
            'Waktu Tunggu', 'Jumlah Lamaran', 'Jumlah Respon', 'Jumlah Wawancara',
            'Jenis Perusahaan', 'Nama Perusahaan', 'Jenis Pekerjaan', 'Alamat Perusahaan', 'Kritik dan Saran', 'Tanggal'
        ];

        $callback = function () use ($kuisioners, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($kuisioners as $k) {
                // 💡 PERBAIKAN: Menambahkan data NIM
                fputcsv($file, [
                    $k->user_id,
                    $k->nama ?? $k->user->name ?? '-', // Ambil dari kolom 'nama' kuisioners jika ada
                    $k->nim ?? '-', // Ambil dari kolom 'nim' kuisioners
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

    /**
     * Show details for a single kuisioner entry (admin view).
     */
    public function show($id)
    {
        $kuisioner = Kuisioner::with('user')->findOrFail($id);

        return view('admin.kuisioner-detail', compact('kuisioner'));
    }
}
