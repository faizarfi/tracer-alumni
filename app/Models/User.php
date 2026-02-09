<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use App\Models\Alumni;
use App\Models\Kuisioner;

// Model User: representasi pengguna aplikasi dan relasi dasar
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'prodi',
        'fakultas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    # Relasi ke tabel alumni
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }

    # Relasi ke tabel kuisioner
    public function kuisioner()
    {
        return $this->hasOne(Kuisioner::class);
    }

    /**
     * Send the password reset notification using the custom notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
