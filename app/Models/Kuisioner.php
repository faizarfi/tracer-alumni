<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import Model User
use App\Models\User;

class Kuisioner extends Model
{
    use HasFactory;

    protected $table = 'kuisioners';

    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'pendidikan',
        'fasilitas',
        'cari_kerja',
        'status_pekerjaan',
        'waktu_tunggu',
        'jumlah_lamaran',
        'jumlah_respon',
        'jumlah_wawancara',
        'jenis_perusahaan',
        'nama_perusahaan',
        'jenis_pekerjaan',
        'alamat_perusahaan',
        'jawaban',
        'relevansi_pekerjaan',
        'skor_kepuasan',
    ];

    /**
     * Kolom yang harus di-cast ke array (agar otomatis di-decode dari JSON)
     */
    protected $casts = [
        'pendidikan' => 'array',
        'fasilitas' => 'array',
    ];

    // --- RELASI BARU UNTUK ADMIN ---

    /**
     * Relasi ke model User.
     * Digunakan oleh AdminController untuk mendapatkan data pengguna (nama, email, dll.)
     */
    public function user()
    {
        // Asumsi foreign key di tabel 'kuisioners' adalah 'user_id'
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // --- AKHIR RELASI BARU ---

    /**
     * Relasi ke model Alumni (opsional, tapi baik untuk keutuhan data)
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'user_id', 'user_id');
    }
}
