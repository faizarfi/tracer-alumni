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
        if (!Schema::hasTable('alumnis')) {
            return; // tabel belum ada; asumsikan migration create_alumnis sudah membuatnya
        }

        if (!Schema::hasColumn('alumnis', 'nomor_telepon')) {
            Schema::table('alumnis', function (Blueprint $table) {
                $table->string('nomor_telepon', 20)->nullable()->after('asal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('alumnis') && Schema::hasColumn('alumnis', 'nomor_telepon')) {
            Schema::table('alumnis', function (Blueprint $table) {
                $table->dropColumn('nomor_telepon');
            });
        }
    }
};
