<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Data Karyawan
                </h2>
                <p class="text-sm text-gray-500">Kelola daftar pegawai dan jadwal kerja.</p>
            </div>

            <a href="{{ route('admin.karyawan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v12m6-6H6" />
                </svg>
                Tambah Pegawai
            </a>
        </div>
    </x-slot>

    @if(session('success'))
    <div x-data="{show:true}" x-show="show"
        class="mb-4 flex items-center justify-between p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
        <span>{{ session('success') }}</span>
        <button @click="show=false" class="text-green-700 hover:text-green-900">✕</button>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow">
        <div class="px-4 sm:px-6 py-4 border-b">
            <span class="text-xs text-gray-500 font-medium">Total Pegawai:</span>
            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                {{ count($karyawan) }} Orang
            </span>
        </div>

        {{-- ⭐ RESPONSIF: scroll horizontal jika layar kecil --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pegawai</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Shift</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($karyawan as $k)
                    <tr class="hover:bg-gray-50">

                        {{-- Pegawai --}}
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-3">

                                {{-- Foto / inisial --}}
                                <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold">
                                    {{ substr($k->name, 0, 1) }}
                                </div>

                                {{-- Identitas --}}
                                <div>
                                    <div class="font-medium text-gray-900 text-sm sm:text-base">{{ $k->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $k->email }}</div>

                                    @if($k->foto_ktp)
                                    <a href="{{ asset('storage/'.$k->foto_ktp) }}" target="_blank"
                                        class="text-[10px] text-blue-600 hover:underline mt-1 block">
                                        Lihat KTP
                                    </a>
                                    @else
                                    <span class="text-[10px] text-gray-400 mt-1 block">Belum upload KTP</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Jabatan --}}
                        <td class="px-4 sm:px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @class([
                                    'bg-orange-100 text-orange-800' => $k->jabatan == 'Barista',
                                    'bg-red-100 text-red-800' => $k->jabatan == 'Kitchen',
                                    'bg-teal-100 text-teal-800' => $k->jabatan == 'Waiters',
                                    'bg-purple-100 text-purple-800' => $k->jabatan == 'Kasir',
                                ])">
                                {{ $k->jabatan }}
                            </span>
                        </td>

                        {{-- Shift --}}
                        <td class="px-4 sm:px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 text-xs bg-gray-100 rounded-md">
                                {{ \Carbon\Carbon::parse($k->jam_masuk_shift)->format('H:i') }}
                                <span class="mx-1">→</span>
                                {{ \Carbon\Carbon::parse($k->jam_keluar_shift)->format('H:i') }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 sm:px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.karyawan.edit', $k->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-gray-100">
                                    ✏️
                                </a>

                                <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data {{ $k->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-gray-100">
                                        🗑️
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                            Belum ada data pegawai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>