<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Program;

class FacultyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Fakultas Adab dan Bahasa' => [
                'S1 - Bahasa dan Sastra Arab', 'S1 - Ilmu Perpustakaan', 'S1 - Pendidikan Bahasa Inggris', 'S1 - Sastra Inggris', 'S1 - Sejarah Peradaban Islam', 'S1 - Tadris Bahasa Indonesia'
            ],
            'Fakultas Ekonomi Dan Bisnis Islam' => [
                'S1 - Akuntansi Syariah', 'S1 - Ekonomi Syariah', 'S1 - Manajemen Bisnis Syariah', 'S1 - Perbankan Syariah', 'S1 - Manajemen Zakat dan Wakaf', 'S1 - Bisnis Digital'
            ],
            'Fakultas Ilmu Tarbiyah' => [
                'S1 - Manajemen Pendidikan Islam', 'S1 - Pendidikan Agama Islam', 'S1 - Pendidikan Bahasa Arab', 'S1 - PGMI', 'S1 - PIAUD', 'S1 - Tadris Biologi', 'S1 - Tadris Matematika', 'S1 - Informatika'
            ],
            'Fakultas Ushuluddin dan Dakwah' => [
                'S1 - Aqidah dan Filsafat Islam', 'S1 - Bimbingan dan Konseling Islam', 'S1 - IQT', 'S1 - Komunikasi dan Penyiaran Islam', 'S1 - Psikologi Islam'
            ],
            'Fakultas Syariah' => [
                'S1 - Hukum Ekonomi Syariah', 'S1 - Hukum Keluarga Islam', 'S1 - Hukum Pidana Islam', 'S1 - Hukum Bisnis'
            ],
        ];

        foreach ($data as $facultyName => $programs) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName], ['slug' => \Illuminate\Support\Str::slug($facultyName)]);
            foreach ($programs as $prog) {
                Program::firstOrCreate([
                    'faculty_id' => $faculty->id,
                    'name' => $prog
                ], [
                    'slug' => \Illuminate\Support\Str::slug($prog)
                ]);
            }
        }
    }
}
