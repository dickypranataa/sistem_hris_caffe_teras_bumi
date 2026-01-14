<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Pengaturan; // Import Model Pengaturan
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // =================================================================
    // 1. DASHBOARD UTAMA
    // =================================================================
    public function index()
    {
        // Hitung total karyawan (selain manajer)
        $totalKaryawan = User::where('role', 'karyawan')->count();

        // Hitung yang sudah absen masuk hari ini
        $hadirHariIni = Absensi::whereDate('tanggal', date('Y-m-d'))->count();

        return view('admin.dashboard', compact('totalKaryawan', 'hadirHariIni'));
    }


    // =================================================================
    // 2. MANAJEMEN DATA KARYAWAN (CRUD)
    // =================================================================

    // A. Tampilkan Daftar Karyawan
    public function daftarKaryawan()
    {
        $karyawan = User::where('role', 'karyawan')->orderBy('created_at', 'desc')->get();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    // B. Tampilkan Form Tambah
    public function createKaryawan()
    {
        return view('admin.karyawan.create');
    }

    // C. Proses Simpan Karyawan Baru
    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'jabatan' => 'required',
            'jam_masuk_shift' => 'required',
            'jam_keluar_shift' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Foto
        ]);

        // Upload Foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan', // Default role
            'jabatan' => $request->jabatan,
            'jam_masuk_shift' => $request->jam_masuk_shift,
            'jam_keluar_shift' => $request->jam_keluar_shift,
            'foto_ktp' => $fotoPath,
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // D. Tampilkan Form Edit
    public function editKaryawan($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    // E. Proses Update Karyawan
    public function updateKaryawan(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($karyawan->id)],
            'jabatan' => 'required',
            'jam_masuk_shift' => 'required',
            'jam_keluar_shift' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Siapkan data update
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'jam_masuk_shift' => $request->jam_masuk_shift,
            'jam_keluar_shift' => $request->jam_keluar_shift,
        ];

        // Cek jika password diisi (Ganti password)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Cek jika ada upload foto baru
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($karyawan->foto_ktp && Storage::disk('public')->exists($karyawan->foto_ktp)) {
                Storage::disk('public')->delete($karyawan->foto_ktp);
            }
            // Simpan foto baru
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // F. Hapus Karyawan
    public function destroyKaryawan($id)
    {
        $karyawan = User::findOrFail($id);

        // Hapus foto profil jika ada
        if ($karyawan->foto_ktp && Storage::disk('public')->exists($karyawan->foto_ktp)) {
            Storage::disk('public')->delete($karyawan->foto_ktp);
        }

        $karyawan->delete();

        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus.');
    }


    // =================================================================
    // 3. PENGATURAN SISTEM (KEBIJAKAN ABSENSI)
    // =================================================================

    // A. Halaman Index (Lihat Pengaturan)
    public function pengaturan()
    {
        $setting = Pengaturan::first();

        // Jika belum ada data, buat data default (Cirebon)
        if (!$setting) {
            $setting = Pengaturan::create([
                'nama_kantor' => 'Cafe Teras Bumi',
                'latitude' => -6.732675656468656,
                'longitude' => 108.55838610705769,
                'radius_meter' => 50,
                'menit_awal_absen_masuk' => 30,
                'menit_toleransi_terlambat' => 15,
                'menit_maksimal_absen_pulang' => 60,
            ]);
        }

        return view('admin.pengaturan.index', compact('setting'));
    }

    // B. Halaman Edit (Form Ubah)
    public function editPengaturan()
    {
        $setting = Pengaturan::first();
        return view('admin.pengaturan.edit', compact('setting'));
    }

    // C. Proses Update Pengaturan
    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meter' => 'required|integer|min:1',
            'menit_awal_absen_masuk' => 'required|integer',
            'menit_toleransi_terlambat' => 'required|integer',
            'menit_maksimal_absen_pulang' => 'required|integer',
        ]);

        $setting = Pengaturan::first();

        $setting->update([
            'nama_kantor' => $request->nama_kantor,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_meter' => $request->radius_meter,
            'menit_awal_absen_masuk' => $request->menit_awal_absen_masuk,
            'menit_toleransi_terlambat' => $request->menit_toleransi_terlambat,
            'menit_maksimal_absen_pulang' => $request->menit_maksimal_absen_pulang,
        ]);

        // Redirect kembali ke halaman Index (Lihat)
        return redirect()->route('admin.pengaturan.index')->with('success', 'Kebijakan absensi berhasil diperbarui!');
    }
}
