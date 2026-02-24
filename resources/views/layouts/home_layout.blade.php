<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wakaf & Donasi') - Platform Kebaikan</title>
    @stack('meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json?v={{ time() }}">
    <meta name="theme-color" content="#8CC63F">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png?v={{ time() }}">

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker Registered'))
                    .catch(err => console.log('Service Worker Failed to Register', err));
            });
        }
    </script>

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
    <nav class="navbar bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between md:justify-between justify-center mx-auto p-4">
            <a href="{{ route('home') }}" class="nav-brand flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="hidden inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false" id="navbar-toggle">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white items-center">
                    <li><a href="{{ route('home') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('home') ? 'text-secondary' : '' }}" aria-current="page">Beranda</a></li>
                    <li><a href="{{ route('news.index') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('news.*') ? 'text-secondary' : '' }}">Berita</a></li>
                    
                    <!-- Layanan Dropdown -->
                    <li class="relative group w-full md:w-auto">
                        <button class="dropdown-toggle nav-link w-full md:w-auto flex items-center justify-between md:justify-start py-2 px-3 gap-1 md:group-hover:text-primary {{ request()->routeIs('wakaf.*') || request()->routeIs('zakat.*') || request()->routeIs('infaq.*') || request()->routeIs('programs.*') ? 'text-secondary' : '' }}">
                            Layanan
                            <svg class="w-2.5 h-2.5 ms-1 transition-transform duration-200 dropdown-arrow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden md:absolute z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg md:shadow w-full md:w-48 md:group-hover:block transition-all duration-300 transform origin-top-left border md:border-none border-gray-100 mt-2 md:mt-0">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="{{ route('wakaf.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('wakaf.*') ? 'text-primary font-bold' : '' }}">Wakaf</a>
                                </li>
                                <li>
                                    <a href="{{ route('zakat.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('zakat.*') ? 'text-primary font-bold' : '' }}">Zakat</a>
                                </li>
                                <li>
                                    <a href="{{ route('infaq.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('infaq.*') ? 'text-primary font-bold' : '' }}">Infaq / Sedekah</a>
                                </li>
                                <!-- <li>
                                    <a href="{{ route('about-wakaf') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('about-wakaf') ? 'text-primary font-bold' : '' }}">Tentang Wakaf</a>
                                </li> -->
                            </ul>
                        </div>
                    </li>

                    <!-- Tentang Kami Dropdown -->
                    <li class="relative group w-full md:w-auto">
                        <button class="dropdown-toggle nav-link w-full md:w-auto flex items-center justify-between md:justify-start py-2 px-3 gap-1 md:group-hover:text-primary">
                            Tentang Kami
                            <svg class="w-2.5 h-2.5 ms-1 transition-transform duration-200 dropdown-arrow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden md:absolute z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg md:shadow w-full md:w-44 md:group-hover:block transition-all duration-300 transform origin-top-left border md:border-none border-gray-100 mt-2 md:mt-0">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="{{ request()->routeIs('wakaf.index') ? route('about-wakaf') : route('about') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('about-wakaf') || request()->routeIs('about') ? 'text-primary font-bold' : '' }}">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('vision-mission') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('vision-mission') ? 'text-primary font-bold' : '' }}">Visi Misi</a>
                                </li>
                                <li>
                                    <a href="{{ route('managers') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('managers') ? 'text-primary font-bold' : '' }}">Pengurus</a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('gallery.*') ? 'text-primary font-bold' : '' }}">Galeri</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{ route('rekening') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('rekening') ? 'text-secondary' : '' }}">Rekening</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link block py-2 px-3 {{ request()->routeIs('contact') ? 'text-secondary' : '' }}">Kontak</a></li>
                    <li class="mt-2 md:mt-0 w-full md:w-auto">
                        @if(Auth::check() && Auth::user()->role !== 'donor')
                            <a href="{{ route('dashboard') }}" class="btn btn-outline w-full md:w-auto text-center block">Dashboard Admin</a>
                        @elseif(Auth::check() && Auth::user()->role === 'donor')
                             <a href="{{ route('dashboard') }}" class="btn btn-outline w-full md:w-auto text-center block">Dashboard</a>
                        @else
                            <a href="{{ route('donor.login') }}" class="btn btn-primary w-full md:w-auto text-center block">Masuk</a>
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

        // Mobile Dropdown Toggle (Generic Class-Based)
        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    const menu = this.nextElementSibling;
                    const arrow = this.querySelector('.dropdown-arrow');
                    
                    menu.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                }
            });
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
                        <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="{{ config('app.name') }}" class="h-14 w-auto object-contain">
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ $site_settings->short_description ?? 'WakafApp Merupakan Lembaga Pengelolaan Wakaf yang telah terdaftar pada Badan Wakaf Indonesia dengan No Nazhir 3.3.00170.' }}
                    </p>

                </div>

                <!-- Column 2: Links -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-6 text-lg">Layanan</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="{{ route('wakaf.index') }}" class="hover:text-primary transition-colors">Wakaf</a></li>
                        <li><a href="{{ route('zakat.index') }}" class="hover:text-primary transition-colors">Zakat</a></li>
                        <li><a href="{{ route('infaq.index') }}" class="hover:text-primary transition-colors">Infaq / Sedekah</a></li>
                        <li><a href="{{ route('programs.index') }}" class="hover:text-primary transition-colors">Program</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact & Social -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-6 text-lg">Temukan Kami</h3>
                    <div class="flex gap-3 mb-6">
                        @if($site_settings->facebook)
                        <a href="{{ $site_settings->facebook }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                            <i class="ti ti-brand-facebook text-xl"></i>
                        </a>
                        @endif
                        @if($site_settings->instagram)
                        <a href="{{ $site_settings->instagram }}" target="_blank" class="w-10 h-10 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all">
                            <i class="ti ti-brand-instagram text-xl"></i>
                        </a>
                        @endif
                        @if($site_settings->twitter)
                        <a href="{{ $site_settings->twitter }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 text-gray-800 flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all">
                            <i class="ti ti-brand-x text-xl"></i>
                        </a>
                        @endif
                        @if($site_settings->linkedin)
                        <a href="{{ $site_settings->linkedin }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center hover:bg-blue-700 hover:text-white transition-all">
                            <i class="ti ti-brand-linkedin text-xl"></i>
                        </a>
                        @endif
                        @if($site_settings->youtube)
                        <a href="{{ $site_settings->youtube }}" target="_blank" class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                            <i class="ti ti-brand-youtube text-xl"></i>
                        </a>
                        @endif
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


    @include('layouts.partials.mobile_bottom_nav')
    @include('layouts.partials.pwa_install_prompt')

    <!-- Floating WhatsApp Button -->
    @if(isset($site_settings) && $site_settings->phone_number)
    @php
        $waNumber = preg_replace('/[^0-9]/', '', $site_settings->phone_number);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
    @endphp
    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Assalamualaikum. Saya ingin berdonasi. Mohon info program yang tersedia. Terima kasih') }}" 
       target="_blank" 
       class="wa-float-btn group"
       title="Chat via WhatsApp">
        <!-- Pulse Ring -->
        <span class="wa-pulse-ring"></span>
        <!-- Character Image -->
        <img src="{{ asset('images/wa_cs_character.png') }}" alt="Customer Service" class="wa-character-img">
        <!-- Tooltip -->
        <span class="wa-tooltip">Chat Kami 💬</span>
    </a>

    <style>
        .wa-float-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.15));
        }
        .wa-float-btn:hover {
            transform: scale(1.08);
        }
        .wa-character-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 50%;
            background: #25D366;
            padding: 4px;
            border: 3px solid white;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
        }
        .wa-float-btn:hover .wa-character-img {
            box-shadow: 0 6px 28px rgba(37, 211, 102, 0.6);
        }
        .wa-pulse-ring {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.3);
            animation: wa-pulse 2s ease-out infinite;
        }
        @keyframes wa-pulse {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .wa-tooltip {
            position: absolute;
            right: 90px;
            bottom: 20px;
            background: white;
            color: #333;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 12px;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s ease;
            pointer-events: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .wa-tooltip::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-left-color: white;
        }
        .wa-float-btn:hover .wa-tooltip {
            opacity: 1;
            transform: translateX(0);
        }
        @media (max-width: 768px) {
            .wa-float-btn { bottom: 90px; right: 16px; }
            .wa-character-img { width: 64px; height: 64px; }
            .wa-pulse-ring { width: 64px; height: 64px; }
            .wa-tooltip { display: none; }
        }
    </style>
    @endif

    @stack('scripts')
</body>
</html>
