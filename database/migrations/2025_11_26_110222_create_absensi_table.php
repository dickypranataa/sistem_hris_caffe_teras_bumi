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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');

            // --- FASE 1: ABSEN MASUK ---
            $table->time('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->string('lokasi_masuk_lat')->nullable();
            $table->string('lokasi_masuk_long')->nullable();
            $table->enum('status', ['Tepat Waktu', 'Terlambat'])->nullable();

            // --- FASE 2: ABSEN PULANG ---
            $table->time('jam_keluar')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->string('lokasi_keluar_lat')->nullable();
            $table->string('lokasi_keluar_long')->nullable();

            $table->text('catatan')->nullable(); // Jika ada error/keterangan lain
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
