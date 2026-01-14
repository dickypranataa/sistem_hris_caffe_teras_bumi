<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    // (Karena nama tabel 'pengaturan' bukan bentuk jamak bahasa Inggris standar)
    protected $table = 'pengaturan';

    // Daftar kolom yang boleh diisi/diupdate secara massal
    protected $fillable = [
        'nama_kantor',
        'latitude',
        'longitude',
        'radius_meter',
        'menit_awal_absen_masuk',
        'menit_toleransi_terlambat',
        'menit_maksimal_absen_pulang',
    ];

    // Mengubah tipe data otomatis saat diambil dari database
    // Agar saat dikoding tidak perlu pakai (int) atau (float) lagi
    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'radius_meter' => 'integer',
        'menit_awal_absen_masuk' => 'integer',
        'menit_toleransi_terlambat' => 'integer',
        'menit_maksimal_absen_pulang' => 'integer',
    ];
}
