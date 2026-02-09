<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

// Model Faculty: representasi fakultas dan relasi ke program studi
class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
