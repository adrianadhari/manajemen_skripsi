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
        Schema::create('skripsi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('bidang');
            $table->string('attachment');
            $table->enum('status', ['Diajukan', 'Disetujui', 'Ditolak'])->default('Diajukan');
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('co_dosen_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->boolean('is_approved_for_sempro')->default(false);
            $table->timestamp('approved_for_sempro_at')->nullable();

            $table->boolean('is_approved_for_semhas')->default(false);
            $table->timestamp('approved_for_semhas_at')->nullable();

            $table->boolean('is_approved_for_sidang')->default(false);
            $table->timestamp('approved_for_sidang_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};
