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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Periode Gaji
            $table->string('bulan'); // Contoh: "November"
            $table->integer('tahun'); // Contoh: 2025

            // Data Snapshot (Rekap Kehadiran saat gaji dibuat)
            $table->integer('total_hadir')->default(0);
            $table->integer('total_terlambat')->default(0);

            // Input Manual Manajer
            $table->decimal('gaji_bersih', 15, 2); // Nominal final (Rupiah)
            $table->text('catatan')->nullable(); // Rincian bonus/potongan

            $table->date('tanggal_dicetak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
