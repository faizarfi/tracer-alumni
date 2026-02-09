<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

// Model Gallery: menyimpan metadata gambar dan relasi ke user
class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_id',
    ];

    // Relasi: gambar dimiliki oleh seorang user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
