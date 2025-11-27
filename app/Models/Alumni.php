<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        // --- KOLOM TESTIMONI BARU ---
        'testimonial_quote',
        'testimonial_status', // <--- DIGANTI dari is_testimonial_approved
        // -----------------------------
    ];

    // Kolom yang harus di-cast
    protected $casts = [
        'tanggal_lahir' => 'date',
        'sudah_bekerja' => 'boolean',
        // Hapus 'is_testimonial_approved', karena testimonial_status adalah string (ENUM/Varchar)
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $primaryKey = 'user_id';
    public $incrementing = false; // Karena user_id bukan auto increment
    protected $keyType = 'string';
}
