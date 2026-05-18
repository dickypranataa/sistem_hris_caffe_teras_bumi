<?php

namespace App\Models;

// HAPUS baris 'use Laravel\Sanctum\HasApiTokens;' karena tidak dipakai
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // HAPUS 'HasApiTokens' dari dalam sini
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Tambahan Kolom HRIS:
        'role',
        'jabatan',
        'foto_ktp',
        'jam_masuk_shift',
        'jam_keluar_shift',
        'hari_libur',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- RELASI KE TABEL LAIN ---

    // Satu User bisa punya BANYAK data Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // Satu User bisa punya BANYAK Slip Gaji
    public function gaji()
    {
        return $this->hasMany(Gaji::class);
    }

    // Satu User bisa punya BANYAK pengajuan Izin
    public function izins()
    {
        return $this->hasMany(Izin::class);
    }
}
