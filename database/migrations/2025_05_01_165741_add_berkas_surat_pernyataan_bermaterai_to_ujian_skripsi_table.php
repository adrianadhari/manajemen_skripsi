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
        Schema::table('ujian_skripsi', function (Blueprint $table) {
            $table->string('berkas_surat_pernyataan_bermaterai')->nullable()->after('jenis_ujian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_skripsi', function (Blueprint $table) {
            $table->dropColumn('berkas_surat_pernyataan_bermaterai');
        });
    }
};
