<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GajiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Depan (Login)
Route::get('/', function () {
    return view('welcome'); // Ke halaman welcome yang baru dibuat
});

// Redirect Dashboard sesuai Role (Manajer ke Admin, Karyawan ke Absen)
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'manajer') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('absensi.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// --- GROUP 1: KHUSUS MANAJER ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen Karyawan (CRUD)
    Route::get('/karyawan', [AdminController::class, 'daftarKaryawan'])->name('karyawan.index'); // Halaman List

    Route::get('/karyawan/create', [AdminController::class, 'createKaryawan'])->name('karyawan.create'); // Halaman Form Tambah (BARU)
    Route::post('/karyawan', [AdminController::class, 'storeKaryawan'])->name('karyawan.store'); // Proses Simpan

    Route::get('/karyawan/{id}/edit', [AdminController::class, 'editKaryawan'])->name('karyawan.edit'); // Halaman Form Edit
    Route::put('/karyawan/{id}', [AdminController::class, 'updateKaryawan'])->name('karyawan.update'); // Proses Update

    Route::delete('/karyawan/{id}', [AdminController::class, 'destroyKaryawan'])->name('karyawan.destroy');

    // Penggajian
    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index'); // Input Gaji
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store'); // Simpan Gaji
    Route::get('/gaji/cetak/{id}', [GajiController::class, 'cetakPDF'])->name('gaji.cetak'); // Cetak PDF

    // Pengaturan Sistem (Absensi)
    // 1. Halaman Lihat (Index) - Read Only
    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('pengaturan.index');

    // 2. Halaman Edit (Formulir) - Untuk mengubah data
    Route::get('/pengaturan/edit', [AdminController::class, 'editPengaturan'])->name('pengaturan.edit');

    // 3. Proses Update - Menyimpan perubahan ke database
    Route::put('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('pengaturan.update');

    // Izin (Admin)
    Route::get('/izin', [App\Http\Controllers\IzinController::class, 'indexAdmin'])->name('izin.index');
    Route::post('/izin/{id}/terima', [App\Http\Controllers\IzinController::class, 'terimaAdmin'])->name('izin.terima');
    Route::post('/izin/{id}/tolak', [App\Http\Controllers\IzinController::class, 'tolakAdmin'])->name('izin.tolak');
});

// --- GROUP 2: KHUSUS KARYAWAN ---
Route::middleware(['auth'])->prefix('absensi')->name('absensi.')->group(function () {

    // Halaman Utama Absen (Kamera & Peta)
    Route::get('/', [AbsensiController::class, 'index'])->name('index');

    // Proses Simpan Absen (Masuk & Pulang)
    Route::post('/store', [AbsensiController::class, 'store'])->name('store');

    // Riwayat Absensi Karyawan
    Route::get('/history', [AbsensiController::class, 'history'])->name('history');

    //gaji karyawan
    Route::get('/gaji-saya', [GajiController::class, 'riwayatGaji'])->name('gaji.history');
    Route::get('/gaji-saya/cetak/{id}', [GajiController::class, 'cetakSlipKaryawan'])->name('gaji.cetak');

    // Izin (Karyawan)
    Route::get('/izin', [App\Http\Controllers\IzinController::class, 'indexKaryawan'])->name('izin.index');
    Route::get('/izin/create', [App\Http\Controllers\IzinController::class, 'createKaryawan'])->name('izin.create');
    Route::post('/izin', [App\Http\Controllers\IzinController::class, 'storeKaryawan'])->name('izin.store');
});


// Bawaan Breeze (Profile Edit, Logout, dll)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
