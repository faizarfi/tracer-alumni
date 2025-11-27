<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaprodiSeeder extends Seeder
{
    /**
     * Data Program Studi dan Fakultas
     */
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
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaprodiData = [];

        // Loop melalui setiap Fakultas dan Program Studi
        foreach (self::PROGRAMS as $fakultas => $prodis) {
            foreach ($prodis as $prodi) {

                // 1. Tambahkan akhiran " 123" ke nilai Prodi yang akan disimpan di kolom 'prodi'
                $prodiWithSuffix = $prodi ;

                // 2. Buat slug/username (tanpa akhiran 123) untuk email yang lebih bersih
                $prodiSlug = strtolower(str_replace(['S1 - ', ' dan ', ' '], ['', '_', '_'], $prodi));
                $userName = 'kaprodi_' . $prodiSlug;

                $kaprodiData[] = [
                    'name' => 'Kaprodi ' . $prodi,
                    'email' => $userName . '@kaprodi.uin.ac.id', // Email dengan domain kaprodi.uin.ac.id
                    'password' => Hash::make('Kaprodi123'), // Password default yang kuat
                    'role' => 'kaprodi', // Peran sebagai kaprodi
                    'fakultas' => $fakultas, // Fakultas
                    'prodi' => $prodiWithSuffix, // Program Studi DENGAN AKHIRAN ' 123'
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan data ke tabel users
        User::insert($kaprodiData);
    }
}
