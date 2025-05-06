<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //buat tabel
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_induk')->unique();
            $table->string('password');
            $table->enum('role', ['Mahasiswa', 'Admin', 'Dosen', 'Program Studi'])->default('Mahasiswa');
            $table->string('kelas')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });


        Schema::create('sessions', function (Blueprint $table) { //menyimpan data login pengguna. Ini bagian dari fitur "remember me" atau session management bawaan Laravel.
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //hapus tabel
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
