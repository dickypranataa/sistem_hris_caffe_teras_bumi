<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            💰 Slip Gaji Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Arsip Slip Gaji
                    </h3>
                </div>

                <div class="p-6">
                    @if($riwayatGaji->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Belum ada slip gaji yang diterbitkan.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($riwayatGaji as $gaji)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition duration-200 bg-gray-50 hover:bg-white relative group">

                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs font-bold text-green-600 uppercase tracking-wide">Periode</p>
                                    <h4 class="text-lg font-bold text-gray-800">
                                        {{ \Carbon\Carbon::create()->month((int)$gaji->bulan)->translatedFormat('F') }} {{ $gaji->tahun }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">Diterbitkan: {{ \Carbon\Carbon::parse($gaji->tanggal_dicetak)->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-gray-500 uppercase">Take Home Pay</p>
                                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="mt-4 border-t border-gray-200 pt-3 flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    Hadir: <span class="font-bold text-gray-700">{{ $gaji->total_hadir }}</span> |
                                    Telat: <span class="font-bold text-red-600">{{ $gaji->total_terlambat }}</span>
                                </div>

                                <a href="{{ route('absensi.gaji.cetak', $gaji->id) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>

                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>