<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                ⚙️ Pengaturan Kebijakan Absensi
            </h2>
            {{-- Tombol Edit (Opsional, jika Anda sudah membuat halaman editnya) --}}
            <a href="{{ route('admin.pengaturan.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center transition transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Ubah Kebijakan
            </a>
        </div>
    </x-slot>

    {{-- LEAFLET CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            z-index: 1;
            border-radius: 0.75rem;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center animate-fade-in-down">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM KIRI: DATA TEKS --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- CARD 1: LOKASI --}}
                    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-2 opacity-5">
                            <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                        </div>

                        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg></span>
                            Lokasi Kantor
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nama Kantor</p>
                                <p class="text-gray-900 font-bold text-lg">{{ $setting->nama_kantor }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase">Latitude</p>
                                    <p class="text-gray-700 font-mono text-xs truncate" title="{{ $setting->latitude }}">{{ $setting->latitude }}</p>
                                </div>
                                <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase">Longitude</p>
                                    <p class="text-gray-700 font-mono text-xs truncate" title="{{ $setting->longitude }}">{{ $setting->longitude }}</p>
                                </div>
                            </div>

                            <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold text-yellow-600 uppercase">Radius Absen</p>
                                    <p class="text-yellow-800 font-bold text-lg">{{ $setting->radius_meter }} Meter</p>
                                </div>
                                <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: WAKTU --}}
                    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-purple-100 text-purple-600 p-1.5 rounded-lg mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg></span>
                            Kebijakan Waktu
                        </h3>

                        <div class="space-y-3">
                            {{-- Buka Absen --}}
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded transition">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                    <span class="text-sm text-gray-600">Buka Absen Masuk</span>
                                </div>
                                <span class="font-bold text-gray-900">{{ $setting->menit_awal_absen_masuk }} Menit <span class="text-[10px] text-gray-400 font-normal">(Sblm Shift)</span></span>
                            </div>

                            {{-- Toleransi --}}
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded transition">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></div>
                                    <span class="text-sm text-gray-600">Toleransi Telat</span>
                                </div>
                                <span class="font-bold text-red-600">{{ $setting->menit_toleransi_terlambat }} Menit</span>
                            </div>

                            {{-- Batas Pulang --}}
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded transition">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-sm text-gray-600">Batas Absen Pulang</span>
                                </div>
                                <span class="font-bold text-gray-900">{{ $setting->menit_maksimal_absen_pulang }} Menit <span class="text-[10px] text-gray-400 font-normal">(Stlh Shift)</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: PETA VISUAL --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 h-full flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">🗺️ Peta Geofencing</h3>
                                <p class="text-sm text-gray-500">Area lingkaran biru adalah zona valid untuk melakukan absensi.</p>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded border">Read Only Mode</span>
                        </div>

                        {{-- WADAH PETA --}}
                        <div id="map" class="flex-grow shadow-inner border border-gray-200 w-full rounded-xl"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- LEAFLET JS SCRIPT --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Ambil data dari backend (AMAN DARI CSP)
            var curLat = parseFloat("{{ $setting->latitude }}");
            var curLong = parseFloat("{{ $setting->longitude }}");
            var curRadius = parseFloat("{{ $setting->radius_meter }}");
            var namaKantor = "{{ $setting->nama_kantor }}";

            // Inisialisasi Peta
            var map = L.map('map').setView([curLat, curLong], 18);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Marker
            L.marker([curLat, curLong])
                .addTo(map)
                .bindPopup("<b>" + namaKantor + "</b><br>Pusat Absensi");

            // Radius Geofence
            L.circle([curLat, curLong], {
                color: 'blue',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                radius: curRadius
            }).addTo(map);

        });
    </script>


</x-app-layout>