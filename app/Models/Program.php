<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

# Model Program: representasi program studi dan relasi ke fakultas
class Program extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_id', 'name', 'slug'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
