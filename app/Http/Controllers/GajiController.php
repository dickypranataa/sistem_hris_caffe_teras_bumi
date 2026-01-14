<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gaji;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf; // Library PDF
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    // =================================================================
    // BAGIAN 1: MANAJER (ADMIN)
    // =================================================================

    // Menampilkan halaman input gaji & rekap kehadiran
    public function index(Request $request)
    {
        // 1. Ambil Filter Bulan & Tahun (Default: Bulan Ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 2. Ambil Semua Karyawan
        $karyawan = User::where('role', 'karyawan')->get();

        // 3. Loop setiap karyawan untuk hitung kehadiran & cek data gaji
        foreach ($karyawan as $k) {
            // Hitung Total Hadir Bulan Ini dari tabel Absensi
            $k->total_hadir = Absensi::where('user_id', $k->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            // Hitung Total Terlambat
            $k->total_terlambat = Absensi::where('user_id', $k->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', 'Terlambat')
                ->count();

            // Cek apakah gaji bulan ini sudah diinput sebelumnya?
            $k->data_gaji = Gaji::where('user_id', $k->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
        }

        return view('admin.gaji.index', compact('karyawan', 'bulan', 'tahun'));
    }

    // Menyimpan data gaji yang diinput Manajer
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'user_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'gaji_bersih' => 'required|numeric',
        ]);

        // Simpan atau Update Gaji (Fitur UpdateOrCreate sangat berguna disini)
        // Jika data bulan tsb sudah ada -> Update. Jika belum -> Buat Baru.
        Gaji::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
            ],
            [
                'total_hadir' => $request->total_hadir, // Simpan snapshot kehadiran
                'total_terlambat' => $request->total_terlambat,
                'gaji_bersih' => $request->gaji_bersih,
                'catatan' => $request->catatan, // Opsional
                'tanggal_dicetak' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Data gaji berhasil disimpan!');
    }

    // Cetak Slip Gaji (Versi Manajer - Bisa cetak punya siapa saja)
    public function cetakPDF($id)
    {
        // Ambil Data Gaji + Data User pemiliknya
        $gaji = Gaji::with('user')->findOrFail($id);

        // Load View PDF
        $pdf = Pdf::loadView('admin.gaji.cetak', compact('gaji'));

        // Download PDF dengan nama file otomatis
        return $pdf->download('Slip_Gaji_' . $gaji->user->name . '_' . $gaji->bulan . '-' . $gaji->tahun . '.pdf');
    }


    // =================================================================
    // BAGIAN 2: KARYAWAN (USER)
    // =================================================================

    // 1. Tampilkan Riwayat Gaji Saya (Halaman List)
    public function riwayatGaji()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // Ambil data gaji HANYA milik user tersebut
        // Urutkan dari tahun & bulan terbaru
        $riwayatGaji = Gaji::where('user_id', $userId)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('karyawan.gaji.index', compact('riwayatGaji'));
    }

    // 2. Download Slip Gaji (Versi Karyawan - Ada Validasi Keamanan)
    public function cetakSlipKaryawan($id)
    {
        // PENTING: Validasi Kepemilikan
        // Pastikan ID Gaji yang mau didownload benar-benar milik User yang login.
        // Agar Budi tidak bisa mendownload gaji Siti dengan mengganti ID di URL.

        $gaji = Gaji::where('id', $id)
            ->where('user_id', Auth::id()) // Kunci utamanya disini
            ->firstOrFail(); // Jika tidak ditemukan/bukan miliknya, tampilkan Error 404

        // Menggunakan desain PDF yang sama dengan Admin agar konsisten
        $pdf = Pdf::loadView('admin.gaji.cetak', compact('gaji'));

        return $pdf->download('Slip_Gaji_Saya_' . $gaji->bulan . '-' . $gaji->tahun . '.pdf');
    }
}
