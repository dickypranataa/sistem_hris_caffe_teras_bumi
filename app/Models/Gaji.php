<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'total_hadir',
        'total_terlambat',
        'gaji_bersih',
        'catatan',
        'tanggal_dicetak'
    ];

    // Relasi ke User (Gaji ini punya siapa?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
