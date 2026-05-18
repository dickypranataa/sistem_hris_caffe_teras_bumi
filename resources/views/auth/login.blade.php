<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — HRIS Teras Bumi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #052e16 0%, #14532d 40%, #166534 70%, #15803d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        /* Animated blobs */
        .blob1 { position:fixed;top:-120px;left:-120px;width:400px;height:400px;background:rgba(74,222,128,.12);border-radius:50%;filter:blur(60px);animation:float1 8s ease-in-out infinite; }
        .blob2 { position:fixed;bottom:-100px;right:-100px;width:350px;height:350px;background:rgba(187,247,208,.1);border-radius:50%;filter:blur(60px);animation:float2 10s ease-in-out infinite; }
        @keyframes float1 { 0%,100%{transform:translate(0,0) scale(1);}50%{transform:translate(40px,-30px) scale(1.1);} }
        @keyframes float2 { 0%,100%{transform:translate(0,0) scale(1);}50%{transform:translate(-30px,20px) scale(1.08);} }

        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 32px 80px rgba(5,46,22,.45);
            position: relative;
            z-index: 10;
            animation: slideUp .5s ease both;
        }
        @media(max-width:480px){ .login-card { padding:32px 24px; } }
        @keyframes slideUp { from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);} }

        .logo-circle {
            width:64px;height:64px;border-radius:18px;margin:0 auto 16px;
            background:linear-gradient(135deg,#16a34a,#166534);
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 8px 24px rgba(22,163,74,.45);
        }
        .brand-title { font-size:1.5rem;font-weight:800;color:#14532d;text-align:center;margin-bottom:4px; }
        .brand-sub   { font-size:.85rem;color:#6b7280;text-align:center;margin-bottom:32px; }

        label { display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px; }
        .input-wrap { position:relative;margin-bottom:18px; }
        .input-wrap svg { position:absolute;left:12px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#9ca3af; }
        .form-input {
            width:100%;padding:11px 14px 11px 40px;
            border:1.5px solid #e5e7eb;border-radius:12px;
            font-size:.9rem;color:#111827;outline:none;transition:all .2s;
        }
        .form-input:focus { border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.15); }

        .btn-login {
            width:100%;padding:13px;margin-top:8px;
            background:linear-gradient(135deg,#16a34a,#166534);
            color:#fff;font-size:.95rem;font-weight:700;border:none;
            border-radius:12px;cursor:pointer;transition:all .25s;
            box-shadow:0 6px 20px rgba(22,163,74,.4);letter-spacing:.02em;
        }
        .btn-login:hover { transform:translateY(-2px);box-shadow:0 10px 28px rgba(22,163,74,.5); }

        .divider { display:flex;align-items:center;gap:10px;margin:20px 0; }
        .divider hr { flex:1;border:none;border-top:1px solid #e5e7eb; }
        .divider span { font-size:.75rem;color:#9ca3af;white-space:nowrap; }

        .footer-note { text-align:center;font-size:.78rem;color:rgba(255,255,255,.5);margin-top:24px; }
        .error-msg { background:#fef2f2;border:1px solid #fca5a5;color:#dc2626;border-radius:10px;padding:10px 14px;font-size:.82rem;margin-bottom:14px; }
    </style>
</head>
<body>
    <div class="blob1"></div>
    <div class="blob2"></div>

    <div class="w-full flex flex-col items-center">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-circle">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="brand-title">HRIS Teras Bumi</h1>
            <p class="brand-sub">Masuk untuk memulai sesi kerja Anda</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Errors -->
            @if ($errors->any())
            <div class="error-msg">
                @foreach ($errors->all() as $e) <div>⚠ {{ $e }}</div> @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email">Email Pegawai</label>
                    <div class="input-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@terasbumi.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex justify-between items-center mb-2">
                    <label style="display:flex;align-items:center;gap:8px;font-size:.82rem;font-weight:500;color:#374151;margin:0;">
                        <input type="checkbox" name="remember" style="accent-color:#16a34a;"> Ingat Saya
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:.82rem;color:#16a34a;font-weight:600;">Lupa Password?</a>
                    @endif
                </div>

                <button class="btn-login" type="submit">🚀 Masuk Sekarang</button>
            </form>
        </div>

        <p class="footer-note">© {{ date('Y') }} HRIS Cafe Teras Bumi &mdash; Cirebon</p>
    </div>
</body>
</html>