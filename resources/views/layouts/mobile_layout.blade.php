<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wakaf & Donasi') - Platform Kebaikan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8CC63F', // Lime Green (Palette)
                        secondary: '#F5A623', // Orange (Palette)
                        accent: '#0E2C4C', // Navy Blue (Palette)
                        teal: '#0F5B73', // Teal (Palette)
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #8CC63F; /* Lime Green */
            --primary-light: #A3D95B;
            --secondary: #F5A623; /* Orange */
            --accent: #0E2C4C; /* Navy Blue */
            --teal: #0F5B73; /* Teal */
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

        html, body {
            overflow-x: hidden;
            width: 100%;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        /* .nav-content, .nav-links removed in favor of Tailwind classes for responsiveness */
        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            padding: 0.5rem 0; /* meaningful tap area on mobile */
            display: block;
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
            @if(isset($site_settings) && $site_settings->header_image)
                background: linear-gradient(rgba(14, 44, 76, 0.9), rgba(15, 91, 115, 0.8)), url('{{ asset('storage/' . $site_settings->header_image) }}');
            @else
                background: linear-gradient(rgba(14, 44, 76, 0.9), rgba(15, 91, 115, 0.8)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            @endif
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
            color: var(--accent); /* Changed to Accent (Navy) for more contrast */
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
    <nav class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-200 shadow-md">
        <div class="flex items-center justify-center mx-auto p-4 relative">
            <a href="{{ route('home') }}" class="nav-brand flex items-center">
                <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="{{ config('app.name') }}" class="h-8 w-auto object-contain">
            </a>
        </div>
    </nav>
    <div class="h-16"></div> <!-- Spacer for fixed header -->
    @yield('content')

    @unless(View::hasSection('hide_bottom_nav'))
    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 z-50 w-full bg-white border-t border-gray-200 pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <div class="grid h-16 max-w-lg grid-cols-4 mx-auto font-medium">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('home') ? 'text-secondary' : 'text-gray-500' }}">
                <i class="ti ti-home text-2xl mb-1 group-hover:text-secondary"></i>
                <span class="text-[10px] group-hover:text-secondary">Beranda</span>
            </a>
            
            <a href="{{ route('programs.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('programs.*') ? 'text-secondary' : 'text-gray-500' }}">
                <i class="ti ti-apps text-2xl mb-1 group-hover:text-secondary"></i>
                <span class="text-[10px] group-hover:text-secondary">Program</span>
            </a>

            <a href="{{ route('news.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('news.*') ? 'text-secondary' : 'text-gray-500' }}">
                <i class="ti ti-news text-2xl mb-1 group-hover:text-secondary"></i>
                <span class="text-[10px] group-hover:text-secondary">Berita</span>
            </a>

            @if(session('donor_id'))
                <a href="{{ route('donor.dashboard') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('donor.*') ? 'text-secondary' : 'text-gray-500' }}">
                    <i class="ti ti-user text-2xl mb-1 group-hover:text-secondary"></i>
                    <span class="text-[10px] group-hover:text-secondary">Akun</span>
                </a>
            @else
                <a href="{{ route('donor.login') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('donor.*') ? 'text-secondary' : 'text-gray-500' }}">
                    <i class="ti ti-login text-2xl mb-1 group-hover:text-secondary"></i>
                    <span class="text-[10px] group-hover:text-secondary">Masuk</span>
                </a>
            @endif
        </div>
    </nav>
    <div class="h-20"></div> <!-- Spacer for bottom nav -->
    @endunless


    <style>
        /* Add safe area padding for iPhones with home indicator */
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom);
        }
        /* Add padding to body to prevent content from being hidden behind bottom nav on mobile */
        @media (max-width: 768px) {
            body {
                padding-bottom: 5rem;
            }
        }
    </style>

    @stack('scripts')
</body>
</html>
