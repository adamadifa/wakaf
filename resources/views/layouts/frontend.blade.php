<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wakaf & Donasi') - Platform Kebaikan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0F5132; /* Deep Green */
            --primary-light: #157347;
            --accent: #D1E7DD;
            --text-dark: #212529;
            --text-muted: #6C757D;
            --bg-light: #F8F9FA;
            --white: #FFFFFF;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 0.75rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; transition: color 0.2s; }
        ul { list-style: none; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-dark);
        }
        .nav-link:hover { color: var(--primary); }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
        }
        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }
        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(15, 81, 50, 0.9), rgba(15, 81, 50, 0.8)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: var(--white);
            padding: 5rem 0;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 3rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        /* Utilities */
        .text-center { text-align: center; }
        .mb-2 { margin-bottom: 2rem; }
        .section-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .section-subtitle {
            color: var(--text-muted);
            margin-bottom: 3rem;
        }

        /* Footer */
        footer {
            background: var(--white);
            padding: 3rem 0;
            margin-top: 4rem;
            border-top: 1px solid #eee;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container nav-content">
            <a href="{{ route('home') }}" class="nav-brand">WakafApp</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
                <li><a href="#" class="nav-link">Program</a></li>
                <li><a href="#" class="nav-link">Laporan</a></li>
            </ul>
            @if(Auth::check() && Auth::user()->role !== 'donor')
                <a href="/admin" class="btn btn-outline">Dashboard Admin</a>
            @else
                <a href="#" class="btn btn-primary">Masuk / Daftar</a>
            @endif
        </div>
    </nav>

    @yield('content')

    <footer>
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} WakafApp. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
