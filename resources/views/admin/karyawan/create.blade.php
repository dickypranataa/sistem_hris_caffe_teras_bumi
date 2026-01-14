<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Karyawan Baru
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 sm:py-10 px-4">
        <div class="bg-white shadow rounded-lg">

            {{-- Card Header --}}
            <div class="border-b px-6 py-4">
                <h3 class="text-lg font-medium text-gray-800">Formulir Pegawai</h3>
                <p class="text-sm text-gray-500">Lengkapi data berikut untuk menambahkan pegawai baru.</p>
            </div>

            {{-- Form --}}
            <div class="px-6 py-6">
                <form method="POST" action="{{ route('admin.karyawan.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Cth: Budi Santoso">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Login</label>
                            <input type="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="email@terasbumi.com">
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="*******">
                        </div>

                        {{-- Jabatan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <select name="jabatan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="Barista">Barista</option>
                                <option value="Kitchen">Kitchen</option>
                                <option value="Waiters">Waiters</option>
                                <option value="Kasir">Kasir</option>
                            </select>
                        </div>

                        {{-- Shift --}}

                        <div class="sm:col-span-2 bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Shift Kerja</label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-500">Jam Masuk</label>
                                    <input type="time" name="jam_masuk_shift" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500">Jam Pulang</label>
                                    <input type="time" name="jam_keluar_shift" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Foto KTP / Foto Profil</label>

                            <div
                                class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 018 0m0 0a4 4 0 018 0m-8 0v6"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Upload file</span>
                                            <input type="file" name="foto_ktp" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG — Max 2MB</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('admin.karyawan.index') }}"
                            class="px-5 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-5 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 shadow">
                            Simpan Karyawan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>