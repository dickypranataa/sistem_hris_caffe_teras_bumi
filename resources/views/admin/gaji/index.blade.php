<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            💰 Penggajian Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
            @endif

            {{-- FILTER PERIODE --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
                <div class="p-6 bg-white">
                    <form action="{{ route('admin.gaji.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Bulan</label>
                            <select name="bulan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{-- Fix: $i sudah integer, jadi aman --}}
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                    @endfor
                            </select>
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tahun</label>
                            <select name="tahun" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @for($i = 2024; $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="w-full md:w-auto">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition">
                                Filter Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL INPUT GAJI --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    {{-- PERBAIKAN UTAMA ADA DI SINI: --}}
                    {{-- Menambahkan (int) sebelum $bulan agar dibaca sebagai angka --}}
                    <h3 class="font-bold text-gray-700">Daftar Gaji: {{ \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') }} {{ $tahun }}</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Karyawan</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Total Terlambat</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider" width="30%">Input Gaji Bersih (Rp)</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($karyawan as $k)
                            <tr class="hover:bg-blue-50 transition">
                                {{-- INFO KARYAWAN --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $k->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $k->jabatan }}</div>
                                </td>

                                {{-- TOTAL HADIR --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $k->total_hadir }} Hari
                                    </span>
                                </td>

                                {{-- TOTAL TERLAMBAT --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($k->total_terlambat > 0)
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $k->total_terlambat }}x
                                    </span>
                                    @else
                                    <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <form action="{{ route('admin.gaji.store') }}" method="POST" class="flex gap-2">
                                        @csrf

                                        <input type="hidden" name="user_id" value="{{ $k->id }}">
                                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <input type="hidden" name="total_hadir" value="{{ $k->total_hadir }}">
                                        <input type="hidden" name="total_terlambat" value="{{ $k->total_terlambat }}">

                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 text-xs sm:text-sm">Rp</span>
                                            </div>

                                            <input
                                                type="number"
                                                name="gaji_bersih"
                                                required
                                                value="{{ $k->data_gaji ? $k->data_gaji->gaji_bersih : '' }}"
                                                class="pl-7 sm:pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs sm:text-sm"
                                                placeholder="0">
                                        </div>

                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md shadow transition"
                                            title="Simpan">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>


                                {{-- TOMBOL CETAK --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($k->data_gaji)
                                    <a href="{{ route('admin.gaji.cetak', $k->data_gaji->id) }}" target="_blank"
                                        class="inline-flex items-center justify-center px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        PDF
                                    </a>
                                    <div class="text-[10px] text-gray-400 mt-1">
                                        Saved: {{ \Carbon\Carbon::parse($k->data_gaji->updated_at)->format('d/m H:i') }}
                                    </div>
                                    @else
                                    <span class="text-xs text-gray-400 italic">Belum disimpan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>