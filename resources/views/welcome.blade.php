<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRIS Teras Bumi — Sistem SDM Cafe Terintegrasi</title>
    <meta name="description" content="Platform HRIS all-in-one untuk Cafe Teras Bumi. Absensi GPS, shift, dan payroll otomatis.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { background: #f0fdf4; color: #1f2937; }
        a { text-decoration: none; color: inherit; }

        /* NAV */
        .topnav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: linear-gradient(135deg, #166534, #15803d, #16a34a);
            box-shadow: 0 4px 24px rgba(22,101,52,.35);
        }
        .topnav-inner { max-width:1280px;margin:0 auto;padding:0 24px;display:flex;justify-content:space-between;align-items:center;height:68px; }
        .nav-logo { display:flex;align-items:center;gap:10px; }
        .nav-logo-icon { width:40px;height:40px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center; }
        .nav-logo-text { font-size:1.2rem;font-weight:800;color:#fff; }
        .nav-logo-text span { color:#bbf7d0; }
        .nav-btn {
            padding:10px 24px;background:rgba(255,255,255,.18);color:#fff;border-radius:50px;
            font-size:.88rem;font-weight:600;border:1.5px solid rgba(255,255,255,.3);
            transition:all .2s;
        }
        .nav-btn:hover { background:rgba(255,255,255,.3); }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: linear-gradient(160deg, #052e16 0%, #14532d 35%, #166534 65%, #15803d 100%);
            display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 120px 24px 80px; position: relative; overflow: hidden;
        }
        .hero::before {
            content:''; position:absolute; width:700px; height:700px; border-radius:50%;
            background:radial-gradient(circle, rgba(74,222,128,.15), transparent 70%);
            top:50%; left:50%; transform:translate(-50%,-50%);
            animation: pulse 6s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100%{transform:translate(-50%,-50%) scale(1);}50%{transform:translate(-50%,-50%) scale(1.12);} }

        .hero-badge {
            display:inline-block;padding:6px 16px;background:rgba(187,247,208,.15);
            border:1px solid rgba(187,247,208,.3);border-radius:50px;color:#bbf7d0;
            font-size:.8rem;font-weight:600;letter-spacing:.08em;margin-bottom:24px;
        }
        .hero h1 {
            font-size:clamp(2.5rem,7vw,5rem);font-weight:900;color:#fff;line-height:1.1;
            margin-bottom:24px;
        }
        .hero h1 .accent { color:#4ade80; }
        .hero p { font-size:clamp(1rem,2.5vw,1.2rem);color:#bbf7d0;max-width:600px;margin:0 auto 40px;line-height:1.7; }

        .hero-cta {
            display:flex;gap:16px;justify-content:center;flex-wrap:wrap;
        }
        .btn-primary-hero {
            padding:16px 36px;background:linear-gradient(135deg,#4ade80,#16a34a);color:#052e16;
            border-radius:14px;font-size:1rem;font-weight:800;
            box-shadow:0 8px 32px rgba(74,222,128,.4);
            transition:all .3s;display:inline-flex;align-items:center;gap:8px;
        }
        .btn-primary-hero:hover { transform:translateY(-3px);box-shadow:0 14px 40px rgba(74,222,128,.5);color:#052e16; }
        .btn-secondary-hero {
            padding:16px 36px;background:rgba(255,255,255,.1);color:#fff;
            border-radius:14px;font-size:1rem;font-weight:600;
            border:1.5px solid rgba(255,255,255,.25);transition:all .3s;
        }
        .btn-secondary-hero:hover { background:rgba(255,255,255,.2);color:#fff; }

        /* STATS STRIP */
        .stats-strip {
            background:#fff;padding:40px 24px;
            box-shadow:0 1px 0 #e5e7eb;
        }
        .stats-inner { max-width:900px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:32px;text-align:center; }
        .stat-num { font-size:2.2rem;font-weight:900;color:#16a34a; }
        .stat-label { font-size:.85rem;color:#6b7280;margin-top:4px; }
        @media(max-width:640px){ .stats-inner{grid-template-columns:1fr;gap:20px;} }

        /* FEATURES */
        .features { padding:80px 24px;background:#f0fdf4; }
        .features-inner { max-width:1200px;margin:0 auto; }
        .section-title { text-align:center;font-size:clamp(1.6rem,4vw,2.4rem);font-weight:800;color:#14532d;margin-bottom:8px; }
        .section-sub   { text-align:center;font-size:1rem;color:#6b7280;margin-bottom:52px; }
        .feat-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px; }
        .feat-card {
            background:#fff;border-radius:20px;padding:32px 28px;
            border:1.5px solid #dcfce7;transition:all .3s;
        }
        .feat-card:hover { transform:translateY(-6px);box-shadow:0 20px 48px rgba(22,101,52,.12);border-color:#4ade80; }
        .feat-icon { width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:1.6rem; }
        .feat-title { font-size:1.1rem;font-weight:700;color:#14532d;margin-bottom:10px; }
        .feat-desc  { font-size:.9rem;color:#6b7280;line-height:1.65; }

        /* CTA SECTION */
        .cta-section {
            margin:0 24px 80px;border-radius:28px;padding:64px 40px;text-align:center;
            background:linear-gradient(135deg,#052e16,#166534);
            box-shadow:0 24px 60px rgba(5,46,22,.35);
        }
        .cta-section h2 { font-size:clamp(1.6rem,4vw,2.2rem);font-weight:800;color:#fff;margin-bottom:12px; }
        .cta-section p  { color:#bbf7d0;font-size:1rem;margin-bottom:32px; }
        @media(max-width:640px){ .cta-section{margin:0 12px 60px;padding:44px 24px;} }

        /* FOOTER */
        footer { background:#052e16;color:#bbf7d0;padding:40px 24px;text-align:center; }
        footer .footer-brand { font-size:1.1rem;font-weight:700;color:#4ade80;margin-bottom:8px; }
        footer small { color:rgba(187,247,208,.5);font-size:.78rem; }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav class="topnav">
        <div class="topnav-inner">
            <div class="nav-logo">
                <div class="nav-logo-icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="nav-logo-text">HRIS <span>Teras Bumi</span></span>
            </div>
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-btn">Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="nav-btn">Login Pegawai →</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div style="position:relative;z-index:1;">
            <div class="hero-badge">🌿 SISTEM MANAJEMEN SDM CAFE</div>
            <h1>Kelola Tim Cafe<br>dengan <span class="accent">Lebih Cerdas.</span></h1>
            <p>Platform HRIS all-in-one untuk Cafe Teras Bumi. Absensi GPS, manajemen shift, izin digital, dan penggajian otomatis dalam satu genggaman.</p>
            <div class="hero-cta">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary-hero">🚀 Akses Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary-hero">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                        Masuk ke Sistem
                    </a>
                    <a href="#fitur" class="btn-secondary-hero">Pelajari Fitur ↓</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div class="stats-strip">
        <div class="stats-inner">
            <div><div class="stat-num">100%</div><div class="stat-label">Anti Titip Absen (GPS + Selfie)</div></div>
            <div><div class="stat-num">1 Klik</div><div class="stat-label">Cetak Slip Gaji PDF</div></div>
            <div><div class="stat-num">Real-time</div><div class="stat-label">Rekap Kehadiran & Keterlambatan</div></div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features" id="fitur">
        <div class="features-inner">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-sub">Semua yang Anda butuhkan untuk mengelola SDM cafe dalam satu platform</p>
            <div class="feat-grid">
                <div class="feat-card">
                    <div class="feat-icon" style="background:#dcfce7;">📍</div>
                    <h3 class="feat-title">Absensi GPS & Selfie</h3>
                    <p class="feat-desc">Validasi kehadiran akurat dengan geolokasi dan bukti foto real-time. Radius kantor bisa diatur oleh admin.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background:#fef9c3;">⏰</div>
                    <h3 class="feat-title">Manajemen Shift</h3>
                    <p class="feat-desc">Atur jam masuk, jam pulang, dan hari libur mingguan untuk tiap karyawan secara individual.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background:#f0fdf4;">💰</div>
                    <h3 class="feat-title">Payroll Otomatis</h3>
                    <p class="feat-desc">Rekap kehadiran, keterlambatan, dan izin terisi otomatis. Cetak slip gaji PDF dengan satu klik.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background:#f3e8ff;">📝</div>
                    <h3 class="feat-title">Izin Digital (PDF)</h3>
                    <p class="feat-desc">Karyawan ajukan izin dengan upload surat PDF. Admin bisa terima/tolak langsung dari dashboard.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background:#fff7ed;">🗓️</div>
                    <h3 class="feat-title">Hari Libur Karyawan</h3>
                    <p class="feat-desc">Tentukan hari libur mingguan per karyawan. Sistem otomatis membebaskan karyawan dari absensi di hari libur.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background:#fce7f3;">📊</div>
                    <h3 class="feat-title">Rekap & Laporan</h3>
                    <p class="feat-desc">Lihat rekap kehadiran semua karyawan per bulan, riwayat absen, dan status izin dengan mudah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <div class="max-w-5xl mx-auto">
        <div class="cta-section">
            <h2>Siap Kelola Tim Cafe Anda?</h2>
            <p>Login sekarang dan mulai kelola karyawan dengan lebih efisien.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary-hero" style="display:inline-flex;">🚀 Buka Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary-hero" style="display:inline-flex;">🚀 Login Sekarang</a>
            @endauth
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-brand">🌿 HRIS Cafe Teras Bumi</div>
        <small>© {{ date('Y') }} Cafe Teras Bumi, Cirebon. Sistem HRIS v1.0</small>
    </footer>

</body>
</html>