<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kuisioner; // ⭐ PASTIKAN NAMA MODEL INI BENAR ⭐

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'tanggal_lahir',
        'asal',
        'jurusan',
        'fakultas',
        'sudah_bekerja',
        'tempat_bekerja',
        'tahun_masuk',
        'tahun_keluar',
        'foto_path',
        'testimonial_quote',
        'testimonial_status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'sudah_bekerja' => 'boolean',
    ];

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // --- RELASI DAN ACCESSOR BARU UNTUK KUESIONER ---

    /**
     * Definisikan relasi ke Model Kuisioner.
     * Asumsi: Model Kuisioner menggunakan foreign key 'user_id'.
     */
    public function kuesioner()
    {
        // Ganti Kuisioner::class jika nama Model Kuesioner Anda berbeda
        return $this->hasOne(Kuisioner::class, 'user_id', 'user_id');
    }

    /**
     * Accessor untuk properti has_filled_questionnaire.
     * Inilah yang akan memperbaiki status "Belum Mengisi" di tabel daftar alumni.
     */
    public function getHasFilledQuestionnaireAttribute() : bool
    {
        return $this->kuesioner()->exists();
    }

    // --- AKHIR RELASI DAN ACCESSOR BARU ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
