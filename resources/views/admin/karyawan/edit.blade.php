<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Karyawan — {{ $karyawan->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- TITLE --}}
                    <h3 class="text-lg font-medium text-gray-800 mb-6">
                        Perbarui Informasi Pegawai
                    </h3>

                    <form method="POST"
                        action="{{ route('admin.karyawan.update', $karyawan->id) }}"
                        enctype="multipart/form-data"
                        class="space-y-6">

                        @csrf
                        @method('PUT')

                        {{-- NAMA --}}
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input id="name" name="name" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('name', $karyawan->name) }}"
                                required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <x-input-label for="email" value="Email Login" />
                            <x-text-input id="email" name="email" type="email"
                                class="mt-1 block w-full"
                                value="{{ old('email', $karyawan->email) }}"
                                required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- JABATAN --}}
                        <div>
                            <x-input-label for="jabatan" value="Posisi / Jabatan" />
                            <select id="jabatan" name="jabatan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach (['Barista','Kitchen','Waiters','Kasir'] as $posisi)
                                <option value="{{ $posisi }}" @selected($karyawan->jabatan == $posisi)>
                                    {{ $posisi }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <x-input-label for="password" value="Password Baru (Opsional)" />
                            <x-text-input id="password" name="password" type="password"
                                class="mt-1 block w-full"
                                placeholder="Isi jika ingin mengubah password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- SHIFT --}}
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Jadwal & Shift Kerja</h4>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">

                                {{-- jam masuk --}}
                                <div>
                                    <x-input-label for="jam_masuk_shift" value="Jam Masuk" />
                                    <x-text-input id="jam_masuk_shift"
                                        name="jam_masuk_shift" type="time"
                                        class="mt-1 block w-full"
                                        value="{{ old('jam_masuk_shift', $karyawan->jam_masuk_shift) }}"
                                        required />
                                </div>

                                {{-- jam pulang --}}
                                <div>
                                    <x-input-label for="jam_keluar_shift" value="Jam Pulang" />
                                    <x-text-input id="jam_keluar_shift"
                                        name="jam_keluar_shift" type="time"
                                        class="mt-1 block w-full"
                                        value="{{ old('jam_keluar_shift', $karyawan->jam_keluar_shift) }}"
                                        required />
                                </div>

                                {{-- hari libur --}}
                                <div>
                                    <x-input-label for="hari_libur" value="Hari Libur Mingguan" />
                                    <select id="hari_libur" name="hari_libur"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Pilih Hari Libur --</option>
                                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                        <option value="{{ $hari }}" @selected($karyawan->hari_libur == $hari)>
                                            {{ $hari }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('hari_libur')" class="mt-2" />
                                </div>

                            </div>
                        </div>

                        {{-- FOTO --}}
                        <div>
                            <x-input-label for="foto_ktp" value="Foto Profil / KTP" />

                            <div class="flex items-center gap-4 mt-2">

                                {{-- Preview --}}
                                @if($karyawan->foto_ktp)
                                <img src="{{ asset('storage/' . $karyawan->foto_ktp) }}"
                                    class="w-20 h-20 rounded-md object-cover border" />
                                @else
                                <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center text-xl font-semibold text-gray-600">
                                    {{ substr($karyawan->name, 0, 1) }}
                                </div>
                                @endif

                                {{-- Input --}}
                                <input id="foto_ktp" type="file" name="foto_ktp"
                                    class="text-sm text-gray-700" />
                            </div>

                            <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.karyawan.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Batal
                            </a>

                            <button type="submit"
                                class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>