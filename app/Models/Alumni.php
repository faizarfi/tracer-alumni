<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kuisioner;

# Model Alumni: representasi data alumni dan relasinya
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

    /**
     * Relasi: alumni -> kuisioner (one-to-one by user_id)
     */
    # Relasi: satu alumni memiliki satu kuesioner
    public function kuesioner()
    {
        # Ganti Kuisioner::class jika nama Model Kuesioner Anda berbeda
        return $this->hasOne(Kuisioner::class, 'user_id', 'user_id');
    }
    /**
     * Accessor untuk properti has_filled_questionnaire
     */
    # Accessor: cek apakah alumni sudah mengisi kuesioner
    public function getHasFilledQuestionnaireAttribute() : bool
    {
        return $this->kuesioner()->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
