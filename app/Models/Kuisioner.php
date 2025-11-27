<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',  // menambahkan field nama
        'nim',   // menambahkan field nim
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
    ];

    protected $casts = [
        'pendidikan' => 'array',
        'fasilitas' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
