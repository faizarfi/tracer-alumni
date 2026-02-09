<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

# Model Jawaban: menyimpan jawaban terkait kuisioner (guarded = semua kolom boleh diisi)
class Jawaban extends Model
{
    use HasFactory;

    # Jika model ini mewakili sebuah tabel, tentukan `fillable` atau `guarded` bila diperlukan
    protected $guarded = [];
}
