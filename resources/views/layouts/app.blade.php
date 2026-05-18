<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HRIS Teras Bumi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        a { text-decoration: none !important; }
        body { background-color: #f0fdf4; }

        /* Green scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 10px; }

        /* Page header gradient */
        .page-header-bar {
            background: linear-gradient(135deg, #166534 0%, #15803d 50%, #16a34a 100%);
            box-shadow: 0 4px 20px rgba(22,101,52,0.25);
        }
        .page-header-bar h2 { color: #fff !important; }
        .page-header-bar p { color: #bbf7d0 !important; }

        /* Card glow on hover */
        .card-hover { transition: all 0.25s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(22,101,52,0.15) !important; }

        /* Green badge */
        .badge-green { background:#dcfce7; color:#15803d; font-weight:600; font-size:.72rem; padding:3px 10px; border-radius:20px; }
        .badge-red   { background:#fee2e2; color:#dc2626; font-weight:600; font-size:.72rem; padding:3px 10px; border-radius:20px; }
        .badge-yellow{ background:#fef9c3; color:#ca8a04; font-weight:600; font-size:.72rem; padding:3px 10px; border-radius:20px; }
        .badge-purple{ background:#f3e8ff; color:#7e22ce; font-weight:600; font-size:.72rem; padding:3px 10px; border-radius:20px; }

        /* Btn primary green */
        .btn-green-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 22px; font-weight: 600;
            transition: all .2s; box-shadow: 0 4px 14px rgba(22,163,74,.35);
        }
        .btn-green-primary:hover { background: linear-gradient(135deg, #15803d, #166534); transform: translateY(-2px); color:#fff; }

        /* Table */
        table thead { background: linear-gradient(90deg, #166534, #16a34a); }
        table thead th { color: #fff !important; font-size: .75rem; font-weight: 600; letter-spacing: .05em; }
        table tbody tr { transition: background .15s; }
        table tbody tr:hover { background-color: #f0fdf4 !important; }

        /* Stat card */
        .stat-card { border-radius:16px; overflow:hidden; position:relative; }
        .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,.15); }
    </style>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="font-sans antialiased" style="background:#f0fdf4;">
    <div class="min-h-screen" style="background:#f0fdf4;">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="page-header-bar">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>