<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'tanggal',
        // Data Masuk
        'jam_masuk',
        'foto_masuk',
        'lokasi_masuk_lat',
        'lokasi_masuk_long',
        'status',
        // Data Pulang
        'jam_keluar',
        'foto_keluar',
        'lokasi_keluar_lat',
        'lokasi_keluar_long',
        'catatan',
    ];

    // Relasi BALIK ke User (Absen ini punya siapa?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
