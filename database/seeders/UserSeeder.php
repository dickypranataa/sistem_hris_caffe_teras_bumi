<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Manajer (Admin)
        User::create([
            'name' => 'Manajer Teras Bumi',
            'email' => 'admin@terasbumi.com',
            'password' => Hash::make('password'), // Password login: password
            'role' => 'manajer',
            'jabatan' => 'General Manager',
            'jam_masuk_shift' => '08:00:00', // Manajer mungkin shift pagi
            'jam_keluar_shift' => '17:00:00',
        ]);

        // 2. Buat 1 Akun Karyawan (Contoh Budi)
        User::create([
            'name' => 'Budi Barista',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => 'Head Barista',
            'jam_masuk_shift' => '16:00:00', // Shift Sore
            'jam_keluar_shift' => '23:00:00',
        ]);
    }
}
