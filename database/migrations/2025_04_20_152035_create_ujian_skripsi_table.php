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
        Schema::create('ujian_skripsi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->cascadeOnDelete();
            $table->enum('jenis_ujian', ['Seminar Proposal', 'Seminar Hasil', 'Sidang Skripsi']);
            $table->enum('status', ['Menunggu Verifikasi', 'Terverifikasi', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->date('tanggal_seminar')->nullable();
            $table->time('waktu_seminar')->nullable();
            $table->string('ruangan')->nullable();
            $table->foreignId('penguji_1_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('penguji_2_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_schedule_approved_by_prodi')->default(false);
            $table->timestamp('schedule_approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_skripsi');
    }
};
