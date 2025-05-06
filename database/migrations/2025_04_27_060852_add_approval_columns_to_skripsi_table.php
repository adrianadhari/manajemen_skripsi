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
        Schema::table('skripsi', function (Blueprint $table) {
            $table->timestamp('seminar_proposal_approved_at')->nullable();
            $table->timestamp('seminar_hasil_approved_at')->nullable();
            $table->timestamp('sidang_skripsi_approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skripsi', function (Blueprint $table) {
            $table->dropColumn([
                'seminar_proposal_approved_at',
                'seminar_hasil_approved_at',
                'sidang_skripsi_approved_at',
            ]);
        });
    }
};
