<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'HRIS Teras Bumi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-figtree antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">

        <!-- Background Decoration (Sama seperti Welcome) -->
        <div class="absolute top-0 left-0 -z-10 translate-x-1/4 -translate-y-1/4 opacity-30">
            <div class="w-[600px] h-[600px] bg-gradient-to-br from-amber-200 to-orange-100 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute bottom-0 right-0 -z-10 -translate-x-1/4 translate-y-1/4 opacity-30">
            <div class="w-[500px] h-[500px] bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-full blur-3xl"></div>
        </div>

        <!-- Logo & Judul -->
        <div class="mb-8 text-center">
            <a href="/" class="flex flex-col items-center gap-2 group">
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-3 rounded-2xl shadow-lg transform group-hover:scale-110 transition duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mt-3">HRIS Teras Bumi</h2>
                <p class="text-sm text-gray-500">Silakan login untuk memulai sesi kerja.</p>
            </a>
        </div>

        <!-- Card Form -->
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl sm:rounded-3xl border border-gray-100 relative">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Pegawai</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </span>
                        <input id="email" class="block w-full pl-10 border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@terasbumi.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input id="password" class="block w-full pl-10 border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition"
                            type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4 flex justify-between items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a class="text-sm text-amber-600 hover:text-amber-800 font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button class="w-full justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition transform hover:-translate-y-0.5">
                        {{ __('Masuk Sekarang') }}
                    </button>
                </div>

                {{-- Opsi Register (Opsional, biasanya HRIS tidak ada register publik) --}}
                <div class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700">Daftar di sini</a>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} HRIS Teras Bumi Cirebon
        </div>
    </div>
</body>

</html>