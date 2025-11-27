<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PENTING: Jika tabel sudah ada, kita harus memastikan tabel lama dihapus atau diabaikan.
        // migrate:fresh sudah melakukan ini, jadi kita fokus pada pembuatan tabel yang benar.

        Schema::create('alumnis', function (Blueprint $table) {
            // Primary Key & Foreign Key ke users
            $table->string('user_id')->primary();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Data Pribadi & Akademik (Wajib diisi di form)
            $table->string('nama', 255);
            $table->string('nim', 50)->unique();
            $table->date('tanggal_lahir');
            $table->string('asal', 255);
            $table->unsignedSmallInteger('tahun_masuk'); // Kolom yang duplikat
            $table->unsignedSmallInteger('tahun_keluar'); // Kolom yang duplikat
            $table->string('jurusan', 255);
            $table->string('fakultas', 255);

            // Data Pekerjaan
            $table->boolean('sudah_bekerja')->default(0);
            $table->string('tempat_bekerja', 255)->nullable();

            // Kolom Foto Profil
            $table->string('foto_path')->nullable();

            // Kolom Testimoni
            $table->text('testimonial_quote')->nullable();
            $table->string('testimonial_status', 20)->default('rejected');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
