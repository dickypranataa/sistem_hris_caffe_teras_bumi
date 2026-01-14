<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            ⚙️ Ubah Pengaturan Sistem
        </h2>
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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-100 relative">

                {{-- Header Gradient (Tema Biru-Indigo) --}}
                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-8 py-6 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold flex items-center">
                            <svg class="w-6 h-6 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Konfigurasi Kantor & Absensi
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">Sesuaikan lokasi kantor dan aturan waktu absensi.</p>
                    </div>
                </div>

                <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        {{-- KOLOM KIRI: FORM INPUT --}}
                        <div class="lg:col-span-1 space-y-6">

                            {{-- SECTION 1: LOKASI --}}
                            <div class="space-y-4">
                                <h4 class="text-blue-800 font-bold text-sm uppercase border-b border-gray-100 pb-2">📍 Data Lokasi</h4>

                                {{-- Nama Kantor --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Kantor</label>
                                    <input type="text" name="nama_kantor" value="{{ old('nama_kantor', $setting->nama_kantor) }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                </div>

                                {{-- Radius --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Radius Absensi (Meter)</label>
                                    <div class="relative">
                                        <input type="number" name="radius_meter" id="radius" value="{{ old('radius_meter', $setting->radius_meter) }}"
                                            class="w-full rounded-lg border-gray-300 bg-yellow-50 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                        <span class="absolute right-3 top-2 text-gray-400 text-sm">m</span>
                                    </div>
                                </div>

                                {{-- Lat & Long (Readonly) --}}
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Latitude</label>
                                        <input type="text" name="latitude" id="lat" value="{{ $setting->latitude }}" readonly
                                            class="w-full rounded-lg border-gray-200 bg-gray-100 text-xs text-gray-500 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Longitude</label>
                                        <input type="text" name="longitude" id="long" value="{{ $setting->longitude }}" readonly
                                            class="w-full rounded-lg border-gray-200 bg-gray-100 text-xs text-gray-500 cursor-not-allowed">
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: WAKTU --}}
                            <div class="space-y-4 pt-4">
                                <h4 class="text-blue-800 font-bold text-sm uppercase border-b border-gray-100 pb-2">⏱️ Aturan Waktu</h4>

                                {{-- Masuk --}}
                                <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                                    <div class="mb-3">
                                        <label class="block text-xs text-green-800 font-bold mb-1">Buka Absen (Menit sblm shift)</label>
                                        <input type="number" name="menit_awal_absen_masuk" value="{{ $setting->menit_awal_absen_masuk }}" class="w-full rounded-md border-green-300 text-sm focus:ring-green-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-green-800 font-bold mb-1">Toleransi Telat (Menit)</label>
                                        <input type="number" name="menit_toleransi_terlambat" value="{{ $setting->menit_toleransi_terlambat }}" class="w-full rounded-md border-green-300 text-sm focus:ring-green-500">
                                    </div>
                                </div>

                                {{-- Pulang --}}
                                <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                                    <label class="block text-xs text-red-800 font-bold mb-1">Batas Akhir Absen (Menit stlh shift)</label>
                                    <input type="number" name="menit_maksimal_absen_pulang" value="{{ $setting->menit_maksimal_absen_pulang }}" class="w-full rounded-md border-red-300 text-sm focus:ring-red-500">
                                </div>
                            </div>

                        </div>

                        {{-- KOLOM KANAN: PETA INTERAKTIF --}}
                        <div class="lg:col-span-2 flex flex-col h-full">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-1 flex-grow flex flex-col">
                                <div class="bg-white p-3 rounded-t-lg border-b border-gray-200 flex justify-between items-center">
                                    <span class="text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Sesuaikan Titik Koordinat
                                    </span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Geser Marker Biru</span>
                                </div>
                                <div id="map" class="flex-grow rounded-b-lg w-full" style="min-height: 450px;"></div>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="flex justify-end gap-3 mt-6">
                                <a href="{{ route('admin.pengaturan.index') }}" class="px-6 py-3 text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl transition">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-3 text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 font-bold rounded-xl shadow-lg transform hover:scale-105 transition flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT PETA --}}
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