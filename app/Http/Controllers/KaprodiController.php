<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class KaprodiController extends Controller
{
    // Tetap pakai daftar fakultas + prodi sebagai opsi pilihan,
    // tapi tidak membatasi input prodi (validasi sudah dibebaskan).
    private const PROGRAMS = [
        "Fakultas Adab dan Bahasa" => [
            "S1 - Bahasa dan Sastra Arab",
            "S1 - Ilmu Perpustakaan dan Informasi Islam",
            "S1 - Pendidikan Bahasa Inggris",
            "S1 - Sastra Inggris",
            "S1 - Sejarah Peradaban Islam",
            "S1 - Tadris Bahasa Indonesia"
        ],
        "Fakultas Ekonomi Dan Bisnis Islam" => [
            "S1 - Akuntansi Syariah",
            "S1 - Ekonomi Syariah",
            "S1 - Manajemen Bisnis Syariah",
            "S1 - Perbankan Syariah",
            "S1 - Manajemen Zakat dan Wakaf",
            "S1 - Bisnis Digital"
        ],
        "Fakultas Ilmu Tarbiyah" => [
            "S1 - Bioteknologi",
            "S1 - Ilmu Lingkungan",
            "S1 - Manajemen Pendidikan Islam",
            "S1 - Pendidikan Agama Islam",
            "S1 - Pendidikan Bahasa Arab",
            "S1 - Pendidikan Guru Madrasah Ibtidaiyah",
            "S1 - Pendidikan Islam Anak Usia Dini",
            "S1 - Sains Data",
            "S1 - Tadris Biologi",
            "S1 - Tadris Matematika",
            "S1 - Teknologi Pangan",
            "S1 - Informatika"
        ],
        "Fakultas Ushuluddin dan Dakwah" => [
            "S1 - Aqidah dan Filsafat Islam",
            "S1 - Bimbingan dan Konseling Islam",
            "S1 - Ilmu Al-Qur’an dan Tafsir",
            "S1 - Komunikasi dan Penyiaran Islam",
            "S1 - Manajemen Dakwah",
            "S1 - Psikologi Islam",
            "S1 - Pemikiran Politik Islam",
            "S1 - Tasawuf dan Psikoterapi"
        ],
        "Fakultas Syariah" => [
            "S1 - Hukum Ekonomi Syariah",
            "S1 - Hukum Keluarga Islam",
            "S1 - Hukum Pidana Islam",
            "S1 - Hukum Bisnis"
        ]
    ];

    /**
     * Tampilkan daftar Kaprodi
     */
    public function index(Request $request)
    {
        $allProdi = collect(self::PROGRAMS)->flatten();

        $query = User::where('role', 'kaprodi');

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->cari.'%')
                  ->orWhere('email', 'like', '%'.$request->cari.'%')
                  ->orWhere('prodi', 'like', '%'.$request->cari.'%')
                  ->orWhere('fakultas', 'like', '%'.$request->cari.'%');
            });
        }

        $kaprodiList = $query->orderBy('name', 'asc')->paginate(10)->appends($request->query());

        return view('admin.kaprodi', compact('kaprodiList', 'allProdi'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        $programs = self::PROGRAMS;
        return view('admin.kaprodi-create', compact('programs'));
    }

    /**
     * Simpan Kaprodi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'prodi'     => 'required|string|max:255', // bebas diisi
            'fakultas'  => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'kaprodi',
                'fakultas'  => $request->fakultas,
                'prodi'     => $request->prodi,
            ]);

        } catch (\Exception $e) {
            Log::error("Gagal membuat Kaprodi baru: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat Kaprodi.');
        }

        return redirect()->route('admin.kaprodi')->with('success', 'Data Kaprodi berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $kaprodi = User::where('role', 'kaprodi')->findOrFail($id);
        $programs = self::PROGRAMS;

        return view('admin.kaprodi-edit', compact('kaprodi', 'programs'));
    }

    /**
     * Update Kaprodi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'prodi'     => 'required|string|max:255', // bebas diisi
            'fakultas'  => 'required|string|max:100',
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $kaprodi = User::where('role', 'kaprodi')->findOrFail($id);

            $updateData = [
                'name'      => $request->name,
                'email'     => $request->email,
                'prodi'     => $request->prodi,
                'fakultas'  => $request->fakultas,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $kaprodi->update($updateData);

        } catch (\Exception $e) {
            Log::error("Gagal mengupdate Kaprodi ID {$id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui Kaprodi.');
        }

        return redirect()->route('admin.kaprodi')->with('success', 'Data Kaprodi berhasil diperbarui.');
    }

    /**
     * Hapus Kaprodi
     */
    public function destroy($id)
    {
        try {
            User::where('role', 'kaprodi')->findOrFail($id)->delete();
        } catch (\Exception $e) {
            Log::error("Gagal menghapus Kaprodi ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus Kaprodi.');
        }

        return redirect()->route('admin.kaprodi')->with('success', 'Data Kaprodi berhasil dihapus.');
    }
}
