<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HRIS Teras Bumi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 text-gray-800 font-figtree selection:bg-amber-500 selection:text-white">

    <!-- NAVIGASI -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-2 rounded-xl shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">HRIS <span class="text-amber-600">Teras Bumi</span></span>
                </div>

                <!-- Menu Kanan -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-amber-600 transition">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Login Pegawai
                    </a>
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Blob Decoration -->
        <div class="absolute top-0 right-0 -z-10 translate-x-1/3 -translate-y-1/4 opacity-30">
            <div class="w-[800px] h-[800px] bg-gradient-to-br from-amber-200 to-orange-100 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute bottom-0 left-0 -z-10 -translate-x-1/3 translate-y-1/4 opacity-30">
            <div class="w-[600px] h-[600px] bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-amber-100 text-amber-700 text-xs font-bold tracking-wide mb-6">
                SISTEM MANAJEMEN SDM TERINTEGRASI
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                Kelola Tim Cafe <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-600">Lebih Efisien.</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10">
                Platform HRIS all-in-one untuk Cafe Teras Bumi. Absensi GPS, manajemen shift, dan penggajian otomatis dalam satu aplikasi yang mudah digunakan.
            </p>

            <div class="flex justify-center gap-4">
                @auth
                <a href="{{ url('/dashboard') }}" class="px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                    Akses Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="px-8 py-4 text-base font-bold text-white bg-gray-900 rounded-xl hover:bg-gray-800 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Masuk ke Sistem
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- FEATURES GRID -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- Feature 1 -->
                <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Absensi GPS & Selfie</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Validasi kehadiran akurat dengan geolokasi dan bukti foto real-time. Anti titip absen.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Payroll Otomatis</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Rekap kehadiran dan hitung gaji secara otomatis. Cetak slip gaji PDF dengan satu klik.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Shift</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Atur jam masuk dan pulang karyawan dengan fleksibel. Notifikasi keterlambatan real-time.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="text-lg font-bold">Cafe Teras Bumi</span>
                <p class="text-sm text-gray-400 mt-1">HRIS System v1.0</p>
            </div>
            <div class="text-sm text-gray-500">
                &copy; {{ date('Y') }} Teras Bumi Cirebon. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>