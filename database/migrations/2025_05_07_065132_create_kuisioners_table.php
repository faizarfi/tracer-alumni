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
        Schema::create('kuisioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Menambahkan kolom nama dan nim
            $table->string('nama');
            $table->string('nim');

            $table->json('pendidikan'); // pertanyaan bentuk perkuliahan
            $table->json('fasilitas');  // penilaian fasilitas

            $table->string('cari_kerja');
            $table->string('status_pekerjaan');

            $table->integer('waktu_tunggu')->nullable();
            $table->integer('jumlah_lamaran')->nullable();
            $table->integer('jumlah_respon')->nullable();
            $table->integer('jumlah_wawancara')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->text('alamat_perusahaan')->nullable();

            $table->text('jawaban'); // kritik & saran

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioners');
    }
};
