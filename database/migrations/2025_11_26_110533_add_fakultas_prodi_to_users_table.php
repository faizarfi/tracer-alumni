<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Menambahkan kolom 'fakultas' dan 'prodi' ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan Fakultas. Dibuat nullable karena tidak semua user (e.g., user biasa) punya relasi Fakultas/Prodi
            $table->string('fakultas')->nullable()->after('role');

            // Kolom untuk menyimpan Program Studi. Dibuat nullable.
            $table->string('prodi')->nullable()->after('fakultas');
        });
    }

    /**
     * Balikkan migrasi.
     * Menghapus kolom 'fakultas' dan 'prodi' dari tabel users.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prodi');
            $table->dropColumn('fakultas');
        });
    }
};
