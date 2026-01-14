<div class="flex flex-col w-full h-full">

    <!-- Logo -->
    <div class="flex items-center justify-center mb-6 text-2xl font-bold text-blue-600">
        ☕ Teras Bumi
    </div>

    <!-- User Info -->
    <div class="flex flex-col items-center mb-6 border-b pb-4">
        <div class="w-16 h-16 bg-gray-300 rounded-full mb-2 flex items-center justify-center overflow-hidden">
            @if(Auth::user()->foto_ktp)
            <img src="{{ asset('storage/'.Auth::user()->foto_ktp) }}" class="object-cover w-full h-full">
            @else
            <span class="text-2xl">👤</span>
            @endif
        </div>
        <h2 class="font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
        <span class="text-xs text-gray-500 uppercase tracking-wider">{{ Auth::user()->role }} - {{ Auth::user()->jabatan }}</span>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex flex-col gap-2 flex-1">

        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            🏠 Dashboard
        </a>

        @if(Auth::user()->role === 'manajer')
        <p class="px-4 mt-4 text-xs font-bold text-gray-400 uppercase">Admin Menu</p>

        <a href="{{ route('admin.karyawan.index') }}"
            class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.karyawan.*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            👥 Data Karyawan
        </a>

        <a href="{{ route('admin.gaji.index') }}"
            class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.gaji.*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            💰 Penggajian
        </a>
        @endif

        @if(Auth::user()->role === 'karyawan')
        <p class="px-4 mt-4 text-xs font-bold text-gray-400 uppercase">Karyawan Menu</p>

        <a href="{{ route('absensi.index') }}"
            class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('absensi.index') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            📸 Absen Sekarang
        </a>

        <a href="{{ route('absensi.history') }}"
            class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('absensi.history') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            📅 Riwayat Absen
        </a>
        @endif

    </nav>

    <!-- LOGOUT -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 rounded-lg hover:bg-red-50">
            🚪 Logout
        </button>
    </form>

</div>