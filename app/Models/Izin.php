<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_izin',
        'file_surat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
