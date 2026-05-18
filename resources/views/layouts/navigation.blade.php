<nav x-data="{ open: false }" style="background:linear-gradient(135deg,#166534 0%,#15803d 60%,#16a34a 100%); box-shadow:0 4px 20px rgba(22,101,52,.35);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <div style="background:rgba(255,255,255,.2); border-radius:10px; padding:8px;" class="group-hover:bg-white/30 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-white tracking-tight">HRIS <span style="color:#bbf7d0;">Teras Bumi</span></span>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden sm:flex items-center gap-1 ml-6">
                    @if(Auth::user()->role === 'manajer')
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.karyawan.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.karyawan.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Karyawan
                        </a>
                        <a href="{{ route('admin.gaji.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.gaji.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Penggajian
                        </a>
                        <a href="{{ route('admin.izin.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.izin.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Persetujuan Izin
                        </a>
                        <a href="{{ route('admin.pengaturan.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.pengaturan.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Pengaturan
                        </a>
                    @endif

                    @if(Auth::user()->role === 'karyawan')
                        <a href="{{ route('absensi.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('absensi.index') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Absen Sekarang
                        </a>
                        <a href="{{ route('absensi.history') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('absensi.history') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Riwayat Absen
                        </a>
                        <a href="{{ route('absensi.gaji.history') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('absensi.gaji.history') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Riwayat Gaji
                        </a>
                        <a href="{{ route('absensi.izin.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('absensi.izin.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">
                            Izin Kerja
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex items-center gap-3">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-white transition" style="background:rgba(255,255,255,.18);" onmouseover="this.style.background='rgba(255,255,255,.28)'" onmouseout="this.style.background='rgba(255,255,255,.18)'">
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#bbf7d0,#4ade80);display:flex;align-items:center;justify-content:center;font-weight:700;color:#166534;font-size:14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-left leading-tight">
                                <div class="text-xs font-bold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs" style="color:#bbf7d0;">{{ Auth::user()->jabatan ?? Auth::user()->role }}</div>
                            </div>
                            <svg class="w-4 h-4 text-green-200 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Masuk sebagai</p>
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2 inline text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4 mr-2 inline text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-lg text-green-100 hover:bg-white/20 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t" style="border-color:rgba(255,255,255,.15);">
        <!-- User Info -->
        <div class="px-4 py-4 flex items-center gap-3" style="background:rgba(0,0,0,.1);">
            <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#bbf7d0,#4ade80);display:flex;align-items:center;justify-content:center;font-weight:700;color:#166534;font-size:16px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-sm font-bold text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs" style="color:#bbf7d0;">{{ ucfirst(Auth::user()->role) }} {{ Auth::user()->jabatan ? '· '.$_user_jabatan = Auth::user()->jabatan : '' }}</div>
            </div>
        </div>

        <div class="px-3 py-3 space-y-1">
            @if(Auth::user()->role === 'manajer')
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">📊 Dashboard</a>
                <a href="{{ route('admin.karyawan.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.karyawan.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">👥 Data Karyawan</a>
                <a href="{{ route('admin.gaji.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.gaji.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">💰 Penggajian</a>
                <a href="{{ route('admin.izin.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.izin.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">📋 Persetujuan Izin</a>
                <a href="{{ route('admin.pengaturan.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.pengaturan.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">⚙️ Pengaturan</a>
            @endif
            @if(Auth::user()->role === 'karyawan')
                <a href="{{ route('absensi.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('absensi.index') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">📸 Absen Sekarang</a>
                <a href="{{ route('absensi.history') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('absensi.history') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">📅 Riwayat Absen</a>
                <a href="{{ route('absensi.gaji.history') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('absensi.gaji.history') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">💵 Riwayat Gaji</a>
                <a href="{{ route('absensi.izin.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('absensi.izin.*') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/15 hover:text-white' }}">📝 Izin Kerja</a>
            @endif

            <div class="pt-2 border-t" style="border-color:rgba(255,255,255,.15);">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-green-100 hover:bg-white/15 hover:text-white">👤 Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium text-red-300 hover:bg-red-900/30 hover:text-red-200">🚪 Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>