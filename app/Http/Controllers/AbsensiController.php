<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Absensi;
use App\Models\Pengaturan; // Load Model Pengaturan
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Halaman Utama Absen (Kamera & Peta)
    public function index()
    {
        $user = Auth::user();
        $hariIni = date('Y-m-d');

        // Cek apakah hari ini sudah absen masuk?
        $cekAbsen = Absensi::where('user_id', $user->id)
            ->where('tanggal', $hariIni)
            ->first();

        // Terjemahkan hari ini ke Bahasa Indonesia
        $hariInggris = date('l');
        $hariIndoMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariIniIndo = $hariIndoMap[$hariInggris];
        $isHariLibur = ($user->hari_libur === $hariIniIndo);

        // Cek Izin Diterima Hari Ini
        $izinHariIni = \App\Models\Izin::where('user_id', $user->id)
            ->where('tanggal_izin', $hariIni)
            ->where('status', 'diterima')
            ->first();
        $isIzin = ($izinHariIni != null);

        // Ambil Setting Kantor (Untuk dikirim ke JS Peta)
        $setting = Pengaturan::first();

        return view('absensi.index', compact('cekAbsen', 'user', 'setting', 'isHariLibur', 'isIzin'));
    }

    // Proses Simpan Data (Masuk / Pulang)
    public function store(Request $request)
    {
        $user = Auth::user();
        $tanggal = date('Y-m-d');
        $jamSekarang = Carbon::now();

        // 1. AMBIL KEBIJAKAN DARI DATABASE
        $setting = Pengaturan::first();
        if (!$setting) {
            return back()->with('error', 'Sistem belum dikonfigurasi oleh Admin!');
        }

        // Cek Hari Libur
        $hariInggris = date('l');
        $hariIndoMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariIniIndo = $hariIndoMap[$hariInggris];
        if ($user->hari_libur === $hariIniIndo) {
            return back()->with('error', 'Hari ini adalah hari libur Anda, tidak perlu absen!');
        }

        // Cek Izin Diterima Hari Ini
        $izinHariIni = \App\Models\Izin::where('user_id', $user->id)
            ->where('tanggal_izin', date('Y-m-d'))
            ->where('status', 'diterima')
            ->first();
        
        if ($izinHariIni) {
            return back()->with('error', 'Hari ini Anda sedang dalam status Izin yang disetujui, tidak perlu absen!');
        }

        // 2. VALIDASI INPUT (Koordinat & Foto wajib ada)
        $request->validate([
            'lokasi' => 'required', // Format: "lat,long"
            'foto'   => 'required', // Base64 string
        ]);

        // Pecah koordinat user
        $lokasiUser = explode(',', $request->lokasi);
        $latUser = $lokasiUser[0];
        $longUser = $lokasiUser[1];

        // 3. HITUNG JARAK (Haversine Formula)
        // Menghitung jarak antara posisi User vs Posisi Kantor
        $jarak = $this->distance($setting->latitude, $setting->longitude, $latUser, $longUser, "K") * 1000; // Meter

        // Cek Radius (Geofencing)
        if ($jarak > $setting->radius_meter) {
            return back()->with('error', 'Gagal! Jarak Anda ' . round($jarak) . ' meter dari kantor. Maksimal ' . $setting->radius_meter . ' meter.');
        }

        // 4. PROSES UPLOAD FOTO (Base64 to Image)
        $image_parts = explode(";base64,", $request->foto);
        $image_base64 = base64_decode($image_parts[1]);

        // Nama file unik: ID_User + Timestamp
        $fileName = 'absen_' . $user->id . '_' . time() . '.png';

        // Simpan ke folder: storage/app/public/absensi/
        Storage::disk('public')->put('absensi/' . $fileName, $image_base64);


        // 5. LOGIKA CEK STATUS (MASUK ATAU PULANG?)
        $cekAbsen = Absensi::where('user_id', $user->id)->where('tanggal', $tanggal)->first();

        if (!$cekAbsen) {
            // ===========================
            // LOGIKA ABSEN MASUK
            // ===========================

            $jamMasukShift = Carbon::parse($tanggal . ' ' . $user->jam_masuk_shift);

            // A. Cek Apakah Kepagian? (Belum buka absen)
            $jamBuka = $jamMasukShift->copy()->subMinutes($setting->menit_awal_absen_masuk);

            if ($jamSekarang->lessThan($jamBuka)) {
                return back()->with('error', 'Absen belum dibuka! Harap tunggu pukul ' . $jamBuka->format('H:i'));
            }

            // B. Cek Status Terlambat
            $batasToleransi = $jamMasukShift->copy()->addMinutes($setting->menit_toleransi_terlambat);

            if ($jamSekarang->greaterThan($batasToleransi)) {
                $status = 'Terlambat';
                $keterangan = 'Telat ' . $jamSekarang->diffInMinutes($jamMasukShift) . ' menit';
            } else {
                $status = 'Tepat Waktu';
                $keterangan = '-';
            }

            // Simpan Data Baru
            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $tanggal,
                'jam_masuk' => $jamSekarang->format('H:i:s'),
                'foto_masuk' => $fileName,
                'lokasi_masuk_lat' => $latUser,
                'lokasi_masuk_long' => $longUser,
                'status' => $status,
                'catatan' => $keterangan
            ]);

            return back()->with('success', 'Berhasil Absen Masuk! Status: ' . $status);
        } else {
            // ===========================
            // LOGIKA ABSEN PULANG
            // ===========================

            if ($cekAbsen->jam_keluar) {
                return back()->with('error', 'Anda sudah absen pulang hari ini!');
            }

            $jamPulangShift = Carbon::parse($tanggal . ' ' . $user->jam_keluar_shift);

            // A. Cek Batas Maksimal Absen Pulang (Mencegah absen besoknya)
            $batasAkhir = $jamPulangShift->copy()->addMinutes($setting->menit_maksimal_absen_pulang);

            if ($jamSekarang->greaterThan($batasAkhir)) {
                return back()->with('error', 'Batas waktu absen pulang sudah habis! Hubungi Admin.');
            }

            // Update Data Lama
            $cekAbsen->update([
                'jam_keluar' => $jamSekarang->format('H:i:s'),
                'foto_keluar' => $fileName,
                'lokasi_keluar_lat' => $latUser,
                'lokasi_keluar_long' => $longUser,
            ]);

            return back()->with('success', 'Berhasil Absen Pulang! Hati-hati di jalan.');
        }
    }

    // Halaman Riwayat (History)
    public function history()
    {
        $riwayat = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('absensi.history', compact('riwayat'));
    }

    // Rumus Menghitung Jarak (Haversine Formula)
    // Jangan diubah kecuali paham matematikanya
    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
}
