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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- TAMBAHAN KHUSUS HRIS CAFE ---
            $table->enum('role', ['manajer', 'karyawan'])->default('karyawan');
            
            $table->string('jabatan')->nullable();
            $table->string('foto_ktp')->nullable();

            // PENGATURAN SHIFT (Time Window)
            $table->time('jam_masuk_shift')->nullable();
            $table->time('jam_keluar_shift')->nullable();
            $table->string('hari_libur')->nullable();
            // ---------------------------------

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
