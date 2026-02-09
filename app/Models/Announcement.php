<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Announcement: pengumuman publik
class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'published_at'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
