<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Persetujuan Izin Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div x-data="{show:true}" x-show="show" class="mb-4 flex items-center justify-between p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
                <span>{{ session('success') }}</span>
                <button @click="show=false" class="text-green-700 hover:text-green-900">✕</button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Izin</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Surat Izin (PDF)</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @forelse($izins as $izin)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $izin->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $izin->user->jabatan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">Diajukan: {{ $izin->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ asset('storage/' . $izin->file_surat) }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition text-xs font-medium">
                                            📄 Buka PDF
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($izin->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @elseif($izin->status == 'diterima')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Diterima</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($izin->status == 'pending')
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('admin.izin.terima', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Terima izin ini?')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs font-medium">Terima</button>
                                            </form>
                                            <form action="{{ route('admin.izin.tolak', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tolak izin ini?')" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs font-medium">Tolak</button>
                                            </form>
                                        </div>
                                        @else
                                        <span class="text-gray-400 text-xs italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan izin.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
