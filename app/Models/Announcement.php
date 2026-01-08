<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'published_at'
    ];

    protected $dates = ['published_at'];

    /**
     * Casts
     * Ensure published_at is a Carbon instance when retrieved
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
