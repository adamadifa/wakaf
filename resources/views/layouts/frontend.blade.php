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
                        primary: '#2596be', // Custom Blue
                        secondary: '#dc8d17', // Custom Orange
                        accent: '#4EB7C7', // Teal
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #2596be; /* Custom Blue */
            --primary-light: #4aaecf;
            --secondary: #dc8d17; /* Custom Orange */
            --accent: #4EB7C7; /* Teal */
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
                background: linear-gradient(rgba(37, 150, 190, 0.9), rgba(37, 150, 190, 0.8)), url('{{ asset('storage/' . $site_settings->header_image) }}');
            @else
                background: linear-gradient(rgba(37, 150, 190, 0.9), rgba(37, 150, 190, 0.8)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
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
    <nav class="navbar bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="nav-brand flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false" id="navbar-toggle">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white items-center">
                    <li><a href="{{ route('home') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('home') ? 'text-blue-700' : '' }}" aria-current="page">Beranda</a></li>
                    <li><a href="{{ route('programs.index') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('programs.*') ? 'text-blue-700' : '' }}">Program</a></li>
                    <li><a href="{{ route('news.index') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('news.*') ? 'text-blue-700' : '' }}">Berita</a></li>
                    <li><a href="{{ route('laporan.index') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('laporan.*') ? 'text-primary font-bold' : '' }}">Laporan</a></li>
                    <li class="mt-2 md:mt-0">
                        @if(Auth::check() && Auth::user()->role !== 'donor')
                            <a href="{{ route('dashboard') }}" class="btn btn-outline w-full md:w-auto text-center">Dashboard Admin</a>
                        @elseif(Auth::check() && Auth::user()->role === 'donor')
                             <!-- Optional: specific link for donor dashboard if exists, otherwise assume home or profile -->
                             <a href="{{ route('dashboard') }}" class="btn btn-outline w-full md:w-auto text-center">Dashboard</a>
                        @else
                            <a href="{{ route('donor.login') }}" class="btn btn-primary w-full md:w-auto text-center">Masuk</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            var target = document.getElementById('navbar-default');
            target.classList.toggle('hidden');
        });
    </script>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-white pt-16 pb-8 border-t border-gray-100 mt-auto">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Column 1: Brand & Info -->
                <div class="space-y-6">
                    <a href="{{ route('home') }}" class="block">
                        <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-14 w-auto object-contain">
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        WakafApp Merupakan Lembaga Pengelolaan Wakaf yang telah terdaftar pada Badan Wakaf Indonesia dengan No Nazhir 3.3.00170.
                    </p>
                    <div class="flex gap-4">
                        <!-- Accreditation Icons (Placeholders) -->
                        <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center text-[10px] text-center text-gray-400">WTP</div>
                        <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center text-[10px] text-center text-gray-400">Top CSR</div>
                        <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center text-[10px] text-center text-gray-400">Forum Wakaf</div>
                    </div>
                </div>

                <!-- Column 2: Links -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-6 text-lg">Learn More</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-primary transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Milestone</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Laporan Tahunan</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Karir</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact & Social -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-6 text-lg">Temukan Kami</h3>
                    <div class="flex gap-3 mb-6">
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                            <i class="ti ti-brand-facebook text-xl"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all">
                            <i class="ti ti-brand-instagram text-xl"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-50 text-gray-800 flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all">
                            <i class="ti ti-brand-x text-xl"></i>
                        </a>
                    </div>
                    <div class="space-y-3 text-sm text-gray-500">
                        <h4 class="font-bold text-gray-800">Alamat:</h4>
                        <p class="leading-relaxed">
                            {!! nl2br(e($site_settings->address ?? 'Alamat belum diatur.')) !!}
                        </p>
                    </div>
                </div>

                <!-- Column 4: Map -->
                <div class="rounded-xl overflow-hidden h-[250px] bg-gray-100 relative shadow-sm border border-gray-100">
                    <iframe 
                        src="{{ $site_settings->maps_embed ?? '' }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-100 pt-8 text-center">
                <p class="text-sm text-gray-400">
                    Copyright &copy; {{ date('Y') }} WakafApp. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 z-50 w-full bg-white border-t border-gray-200 md:hidden pb-safe">
        <div class="grid h-16 max-w-lg grid-cols-5 mx-auto font-medium">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-500' }}">
                <i class="ti ti-home text-2xl mb-1 group-hover:text-primary"></i>
                <span class="text-[10px] group-hover:text-primary">Beranda</span>
            </a>
            <a href="{{ route('programs.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('programs.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="ti ti-heart-handshake text-2xl mb-1 group-hover:text-primary"></i>
                <span class="text-[10px] group-hover:text-primary">Program</span>
            </a>
            <a href="{{ route('news.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('news.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="ti ti-news text-2xl mb-1 group-hover:text-primary"></i>
                <span class="text-[10px] group-hover:text-primary">Berita</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('laporan.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="ti ti-chart-pie text-2xl mb-1 group-hover:text-primary"></i>
                <span class="text-[10px] group-hover:text-primary">Laporan</span>
            </a>
            @if(Auth::check() && Auth::user()->role !== 'donor')
                <a href="{{ route('dashboard') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                    <i class="ti ti-layout-dashboard text-2xl mb-1 group-hover:text-primary"></i>
                    <span class="text-[10px] group-hover:text-primary">Admin</span>
                </a>
            @elseif(Auth::check() && Auth::user()->role === 'donor')
                <a href="{{ route('dashboard') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                    <i class="ti ti-user text-2xl mb-1 group-hover:text-primary"></i>
                    <span class="text-[10px] group-hover:text-primary">Akun</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                    <i class="ti ti-login text-2xl mb-1 group-hover:text-primary"></i>
                    <span class="text-[10px] group-hover:text-primary">Masuk</span>
                </a>
            @endif
        </div>
    </nav>
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
