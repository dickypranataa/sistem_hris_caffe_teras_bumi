# Sistem HRIS Caffe Teras Bumi

Sistem HRIS sederhana untuk manajemen kehadiran (absensi), permohonan izin, dan penggajian karyawan di Caffe Teras Bumi. Aplikasi ini dibuat dengan Laravel dan ditujukan untuk digunakan oleh Manajer (Admin) dan Karyawan.

---

## Fitur Utama (ringkas)
- Absensi (Kehadiran)
  - Absen masuk & pulang menggunakan foto (webcam) dan lokasi (GPS).
  - Geofencing: hanya memperbolehkan absen di radius kantor yang ditentukan.
  - Cek hari libur pribadi dan pengecekan izin yang sudah disetujui.
  - Riwayat absensi per karyawan.

- Izin (Cuti / Surat)
  - Karyawan mengunggah surat izin (PDF).
  - Status: pending → diterima / ditolak oleh Admin.
  - Admin dapat meninjau dan memutuskan permohonan izin.

- Penggajian (Gaji)
  - Manajer dapat menghitung dan menyimpan data gaji per bulan.
  - Sistem menyimpan snapshot: total hadir, total terlambat, total izin, dan gaji bersih.
  - Cetak slip gaji ke PDF (untuk manajer dan untuk karyawan secara pribadi).

- Profil Pengguna
  - Karyawan dapat melihat dan mengubah data profilnya (nama, kontak, dsb).

- Panel Admin (Manajer)
  - Dashboard admin.
  - Manajemen data karyawan (CRUD).
  - Pengaturan sistem terkait absensi (lokasi kantor, radius, toleransi waktu, dsb).
  - Melihat & memproses permohonan izin serta input/rekap gaji.

---

## Stack & Teknologi
- Bahasa: PHP (Laravel) + Blade (template) + sedikit JavaScript
- Framework: Laravel
- Frontend tooling: Tailwind CSS, Vite
- PDF: barryvdh/laravel-dompdf (untuk cetak slip gaji)
- Testing: PHPUnit (konfigurasi ada di phpunit.xml)

---

## Struktur Penting (ringkasan)
- app/
  - Http/Controllers/ — AbsensiController, IzinController, GajiController, AdminController, ProfileController
  - Models/ — Absensi.php, Izin.php, Gaji.php, Pengaturan.php, User.php
  - View/Components/ — komponen Blade (jika ada)
- routes/
  - web.php — rute utama (absensi, admin, izin, gaji, profile)
  - auth.php — rute otentikasi (Breeze)
- resources/views/ — tampilan Blade
- database/ — migrations / seeders
- storage/ — penyimpanan foto & file surat
- tailwind.config.js, vite.config.js, package.json, composer.json

---

## Ringkasan Rute Penting
(akses memerlukan autentikasi sesuai peran)

- Umum
  - GET  / → halaman welcome
  - GET  /dashboard → redirect ke dashboard sesuai role

- Admin / Manajer (prefix: /admin, middleware auth)
  - GET  /admin/dashboard → Admin dashboard
  - GET  /admin/karyawan → daftar karyawan
  - GET  /admin/karyawan/create → form tambah karyawan
  - POST /admin/karyawan → simpan karyawan
  - GET  /admin/karyawan/{id}/edit → form edit karyawan
  - PUT  /admin/karyawan/{id} → update karyawan
  - DELETE /admin/karyawan/{id} → hapus karyawan
  - GET  /admin/gaji → input/rekap gaji
  - POST /admin/gaji → simpan gaji (updateOrCreate)
  - GET  /admin/gaji/cetak/{id} → cetak slip gaji (PDF)
  - GET  /admin/pengaturan → lihat pengaturan absensi
  - GET  /admin/pengaturan/edit → edit pengaturan
  - PUT  /admin/pengaturan → simpan pengaturan
  - GET  /admin/izin → lihat semua pengajuan izin
  - POST /admin/izin/{id}/terima → terima izin
  - POST /admin/izin/{id}/tolak → tolak izin

- Karyawan (prefix: /absensi, middleware auth)
  - GET  /absensi → halaman absen (kamera + peta)
  - POST /absensi/store → proses absen masuk / pulang (base64 foto + lokasi)
  - GET  /absensi/history → riwayat absensi
  - GET  /absensi/gaji-saya → riwayat gaji saya
  - GET  /absensi/gaji-saya/cetak/{id} → cetak slip gaji saya (download PDF)
  - GET  /absensi/izin → daftar pengajuan izin saya
  - GET  /absensi/izin/create → form pengajuan izin
  - POST /absensi/izin → kirim pengajuan izin (upload PDF)

- Profil
  - GET/PATCH/DELETE /profile → edit / update / hapus profile (Breeze)

---

## Cara Menjalankan (development) — langkah cepat
Kebutuhan: PHP, Composer, Node.js, NPM, database (MySQL/MariaDB)

1. Clone repository
```bash
git clone https://github.com/dickypranataa/sistem_hris_caffe_teras_bumi.git
cd sistem_hris_caffe_teras_bumi
