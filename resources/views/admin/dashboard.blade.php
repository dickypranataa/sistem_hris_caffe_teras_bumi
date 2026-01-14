<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Manajer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Karyawan</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalKaryawan }} Orang</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Hadir Hari Ini</div>
                    <div class="text-3xl font-bold text-green-600">{{ $hadirHariIni }} Orang</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Menu Kelola</h3>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.karyawan.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            👥 Kelola Data Karyawan
                        </a>
                        <a href="{{ route('admin.gaji.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            💰 Input Penggajian
                        </a>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>