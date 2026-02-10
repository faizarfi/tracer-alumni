<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('alumnis') || !Schema::hasColumn('alumnis', 'nomor_telepon')) {
            return;
        }

        $driver = DB::getDriverName();

        try {
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `alumnis` MODIFY `nomor_telepon` VARCHAR(14) NULL");
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE alumni ALTER COLUMN nomor_telepon TYPE VARCHAR(14)');
            } elseif ($driver === 'sqlite') {
                // SQLite mengubah tipe kolom sulit; lewati jika sqlite
                // Pengguna dapat melakukan migration manual jika diperlukan
            }
        } catch (\Throwable $e) {
            // Jika perubahan gagal (mis. doctrine/dbal tidak tersedia), jangan pecahkan migrasi lainnya
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('alumnis') || !Schema::hasColumn('alumnis', 'nomor_telepon')) {
            return;
        }

        $driver = DB::getDriverName();

        try {
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `alumnis` MODIFY `nomor_telepon` VARCHAR(20) NULL");
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE alumni ALTER COLUMN nomor_telepon TYPE VARCHAR(20)');
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
