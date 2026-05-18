<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight drop-shadow-md">
                    Data Karyawan
                </h2>
                <p class="text-sm text-green-100 mt-1">Kelola daftar pegawai dan jadwal kerja.</p>
            </div>

            <a href="{{ route('admin.karyawan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-white text-green-700 text-sm font-bold rounded-xl shadow-lg hover:bg-green-50 hover:shadow-xl transition transform hover:-translate-y-0.5 border border-green-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                </svg>
                Tambah Pegawai
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @if(session('success'))
        <div x-data="{show:true}" x-show="show"
            class="mb-6 flex items-center justify-between p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl shadow-sm">
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show=false" class="text-green-700 hover:text-green-900 font-bold">✕</button>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-green-100">
            <!-- Header Section -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 font-medium">Total Pegawai:</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full shadow-sm">
                        {{ count($karyawan) }} Orang
                    </span>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-green-50 to-emerald-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Pegawai</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-green-800 uppercase tracking-wider">Shift & Libur</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-green-800 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($karyawan as $k)
                        <tr class="hover:bg-green-50/50 transition duration-150 ease-in-out group">

                            {{-- Pegawai --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    {{-- Foto / inisial --}}
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center font-bold text-lg shadow-md group-hover:scale-105 transition">
                                        {{ substr($k->name, 0, 1) }}
                                    </div>

                                    {{-- Identitas --}}
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 text-base">{{ $k->name }}</span>
                                        <span class="text-xs text-gray-500 mt-0.5">{{ $k->email }}</span>

                                        @if($k->foto_ktp)
                                        <a href="{{ asset('storage/'.$k->foto_ktp) }}" target="_blank"
                                            class="text-[11px] font-medium text-green-600 hover:text-green-800 hover:underline mt-1.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat KTP
                                        </a>
                                        @else
                                        <span class="text-[11px] text-gray-400 mt-1.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Belum upload KTP
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Jabatan --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                                    @class([
                                        'bg-orange-100 text-orange-800 border border-orange-200' => $k->jabatan == 'Barista',
                                        'bg-red-100 text-red-800 border border-red-200' => $k->jabatan == 'Kitchen',
                                        'bg-teal-100 text-teal-800 border border-teal-200' => $k->jabatan == 'Waiters',
                                        'bg-purple-100 text-purple-800 border border-purple-200' => $k->jabatan == 'Kasir',
                                        'bg-gray-100 text-gray-800 border border-gray-200' => !in_array($k->jabatan, ['Barista', 'Kitchen', 'Waiters', 'Kasir'])
                                    ])">
                                    {{ $k->jabatan ?: 'Staff' }}
                                </span>
                            </td>

                            {{-- Shift & Libur --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold bg-green-50 text-green-700 rounded-lg border border-green-200 shadow-sm w-max">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ \Carbon\Carbon::parse($k->jam_masuk_shift)->format('H:i') }}
                                        <span class="mx-2 text-green-400">→</span>
                                        {{ \Carbon\Carbon::parse($k->jam_keluar_shift)->format('H:i') }}
                                    </span>
                                    @if($k->hari_libur)
                                    <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold bg-red-50 text-red-600 rounded-md border border-red-100 w-max">
                                        <svg class="w-3 h-3 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Libur: {{ $k->hari_libur }}
                                    </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.karyawan.edit', $k->id) }}"
                                        class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 p-2.5 rounded-xl transition shadow-sm" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data {{ $k->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2.5 rounded-xl transition shadow-sm" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-green-50 rounded-full p-4 mb-4">
                                        <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada data pegawai.</p>
                                    <a href="{{ route('admin.karyawan.create') }}" class="text-green-600 hover:text-green-700 text-sm font-bold mt-2">Tambah Sekarang →</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>