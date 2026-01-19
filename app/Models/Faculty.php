<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
