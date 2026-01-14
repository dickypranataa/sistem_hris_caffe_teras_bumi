<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            📸 Absensi Karyawan
        </h2>
    </x-slot>

    {{-- CSS LEAFLET (PETA) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
            z-index: 1;
        }
    </style>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            {{-- PESAN ERROR / SUKSES --}}
            @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 relative">

                {{-- INFO SHIFT --}}
                <div class="bg-blue-600 p-4 text-white text-center">
                    <p class="text-sm opacity-80">Shift Anda Hari Ini</p>
                    <h3 class="text-2xl font-bold">
                        {{ \Carbon\Carbon::parse($user->jam_masuk_shift)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($user->jam_keluar_shift)->format('H:i') }}
                    </h3>
                </div>

                <div class="p-6">

                    {{-- LOGIKA TAMPILAN TOMBOL --}}
                    @if($cekAbsen && $cekAbsen->jam_keluar)
                    {{-- KONDISI 1: SUDAH SELESAI KERJA --}}
                    <div class="text-center py-10">
                        <div class="mb-4 text-green-500">
                            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Shift Selesai!</h3>
                        <p class="text-gray-500">Terima kasih atas kerja kerasmu hari ini.</p>
                    </div>

                    @else
                    {{-- KONDISI 2: BELUM SELESAI (BISA MASUK ATAU PULANG) --}}

                    {{-- 1. AREA KAMERA --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2 text-center">Ambil Selfie</label>
                        <div id="my_camera" class="mx-auto rounded-lg overflow-hidden shadow-md bg-gray-200" style="width: 320px; height: 240px;"></div>
                        {{-- Input Hidden untuk Simpan Foto --}}
                        <input type="hidden" name="image" id="image_data">
                    </div>

                    {{-- 2. AREA PETA --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2 text-center">Lokasi Anda</label>
                        <div id="map" class="w-full h-48 rounded-lg shadow-md border border-gray-200"></div>
                        <p class="text-xs text-gray-500 text-center mt-1" id="lokasi_text">Mendeteksi lokasi...</p>
                    </div>

                    {{-- FORM KIRIM DATA --}}
                    <form action="{{ route('absensi.store') }}" method="POST" id="form-absen">
                        @csrf
                        <input type="hidden" name="lokasi" id="lokasi_input">
                        <input type="hidden" name="foto" id="foto_input">

                        @if(!$cekAbsen)
                        {{-- TOMBOL MASUK --}}
                        <button type="button" onClick="ambilFotoMasuk()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform hover:scale-105 flex justify-center items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            ABSEN MASUK
                        </button>
                        @else
                        {{-- TOMBOL PULANG --}}
                        <button type="button" onClick="ambilFotoPulang()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform hover:scale-105 flex justify-center items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            ABSEN PULANG
                        </button>
                        @endif
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- === LIBRARY JAVASCRIPT === --}}

    {{-- 1. Panggil Webcam.js dari File Lokal yang tadi dibuat --}}
    <script src="{{ asset('js/webcam.js') }}"></script>

    {{-- 2. Panggil Leaflet.js (Peta) dari CDN --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- SCRIPT LOGIKA ABSENSI --}}
    <script language="JavaScript">
        // Pastikan script jalan setelah halaman siap
        document.addEventListener("DOMContentLoaded", function() {

            // --- SETUP WEBCAM ---
            try {
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
            } catch (e) {
                console.error("Webcam Error:", e);
                alert("Gagal mengakses kamera. Pastikan izin diberikan.");
            }

            // --- SETUP PETA (GPS) ---
            // Koordinat Cafe Teras Bumi (Cirebon)
            var cafeLat = -6.732675656468656;
            var cafeLong = 108.55838610705769;

            var map = L.map('map').setView([cafeLat, cafeLong], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marker untuk Cafe (Opsional, agar user tahu targetnya)
            // L.marker([cafeLat, cafeLong]).addTo(map).bindPopup("Lokasi Cafe").openPopup();

            // Ambil Lokasi User Real-time
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function(position) {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;

                    // Isi nilai ke input hidden
                    document.getElementById('lokasi_input').value = lat + "," + long;
                    document.getElementById('lokasi_text').innerHTML = "Lat: " + lat + ", Long: " + long;

                    // Hapus marker user lama agar tidak numpuk
                    if (typeof userMarker !== 'undefined') {
                        map.removeLayer(userMarker);
                    }

                    // Tambah marker baru posisi user
                    userMarker = L.marker([lat, long]).addTo(map);
                    userMarker.bindPopup("Posisi Anda").openPopup();

                    // Geser peta ke posisi user
                    map.setView([lat, long], 17);
                }, function(error) {
                    console.warn("GPS Error:", error);
                    document.getElementById('lokasi_text').innerHTML = "Gagal mendeteksi lokasi. Pastikan GPS aktif.";
                });
            } else {
                alert("Browser Anda tidak mendukung Geolocation.");
            }
        });

        // --- FUNGSI TOMBOL CLICK ---

        function ambilFotoMasuk() {
            // Cek apakah lokasi sudah didapat?
            var lokasi = document.getElementById('lokasi_input').value;
            if (!lokasi) {
                alert("Tunggu sebentar, sedang mengambil titik lokasi GPS...");
                return;
            }

            Webcam.snap(function(data_uri) {
                document.getElementById('foto_input').value = data_uri;

                if (confirm("Apakah Anda yakin ingin Absen Masuk?")) {
                    document.getElementById('form-absen').submit();
                }
            });
        }

        function ambilFotoPulang() {
            var lokasi = document.getElementById('lokasi_input').value;
            if (!lokasi) {
                alert("Tunggu sebentar, sedang mengambil titik lokasi GPS...");
                return;
            }

            Webcam.snap(function(data_uri) {
                document.getElementById('foto_input').value = data_uri;

                if (confirm("Apakah Anda yakin ingin Absen Pulang?")) {
                    document.getElementById('form-absen').submit();
                }
            });
        }
    </script>
</x-app-layout>