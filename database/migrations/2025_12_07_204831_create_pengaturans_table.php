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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kantor')->default('Cafe Teras Bumi');

            // 1. Kebijakan Lokasi (Geofencing)
            $table->double('latitude');  // Contoh: -6.732...
            $table->double('longitude'); // Contoh: 108.558...
            $table->integer('radius_meter')->default(50); // Contoh: 50 meter

            // 2. Kebijakan Waktu Masuk
            // Berapa menit sebelum shift dimulai tombol absen muncul? (misal: 30 menit)
            $table->integer('menit_awal_absen_masuk')->default(30);
            // Berapa menit telat masih ditoleransi sebelum dianggap "Telat"? (misal: 15 menit)
            $table->integer('menit_toleransi_terlambat')->default(15);

            // 3. Kebijakan Waktu Pulang
            // Berapa menit setelah jam pulang tombol absen masih aktif? (misal: 60 menit)
            $table->integer('menit_maksimal_absen_pulang')->default(60);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
