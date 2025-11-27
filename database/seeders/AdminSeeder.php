<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@uin.ac.id'], // Mencari berdasarkan email
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('Admin123'), // Password default: Admin123
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // 2. Akun User/Alumni (Contoh data user yang sering hilang)
        User::updateOrCreate(
            ['email' => 'alumni@student.uin.ac.id'],
            [
                'name' => 'Alumni Contoh',
                'password' => Hash::make('Alumni123'), // Password default: Alumni123
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
