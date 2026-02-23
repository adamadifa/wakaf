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

    <!-- SEO & Open Graph -->
    @stack('meta')
    @if(!View::hasSection('meta_og'))
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="@yield('title', 'Wakaf & Donasi') - Platform Kebaikan">
        <meta property="og:description" content="Platform wakaf dan donasi terpercaya. Salurkan kebaikan Anda sekarang.">
        <meta property="og:image" content="{{ asset('logo.png') }}">
    @endif

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
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 relative">
            <button id="mobile-menu-btn" type="button" class="inline-flex md:hidden items-center justify-center p-2 w-10 h-10 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-colors">
                <i class="ti ti-menu-2 text-2xl"></i>
            </button>
            <a href="{{ route('home') }}" class="nav-brand flex items-center space-x-3 rtl:space-x-reverse absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0">
                @if(request()->routeIs('wakaf.index'))
                    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
                @else
                    <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
                @endif
            </a>
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
                                <li>
                                    <a href="{{ route('about-wakaf') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('about-wakaf') ? 'text-primary font-bold' : '' }}">Tentang Wakaf</a>
                                </li>
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
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu hidden md:absolute z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg md:shadow w-full md:w-44 md:group-hover:block transition-all duration-300 transform origin-top-left border md:border-none border-gray-100 mt-2 md:mt-0">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('about') ? 'text-primary font-bold' : '' }}">Profile</a>
                                </li>
                                <!-- <li>
                                    <a href="{{ route('vision-mission') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('vision-mission') ? 'text-primary font-bold' : '' }}">Visi Misi</a>
                                </li> -->
                                <li>
                                    <a href="{{ route('vision-mission-wakaf') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('vision-mission-wakaf') ? 'text-primary font-bold' : '' }}">Visi Misi Wakaf</a>
                                </li>
                                <li>
                                    <a href="{{ route('managers') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('managers') ? 'text-primary font-bold' : '' }}">Pengurus</a>
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

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity duration-300 opacity-0 backdrop-blur-sm"></div>
    
    <!-- Mobile Sidebar -->
    <div id="mobile-menu" class="fixed inset-y-0 left-0 w-[280px] bg-white z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col rounded-r-2xl">
        <!-- Sidebar Header -->
        <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-white rounded-tr-2xl">
            <div class="flex items-center gap-2">
                @if(request()->routeIs('wakaf.index'))
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto">
                @else
                    <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="Logo" class="h-8 w-auto">
                @endif
            </div>
            <button id="mobile-menu-close" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-all">
                <i class="ti ti-x text-xl"></i>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
             <ul class="space-y-1">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/5 {{ request()->routeIs('home') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 font-medium' }}">
                        <i class="ti ti-home text-xl {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400' }}"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/5 {{ request()->routeIs('news.*') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 font-medium' }}">
                        <i class="ti ti-news text-xl {{ request()->routeIs('news.*') ? 'text-primary' : 'text-gray-400' }}"></i>
                        Berita
                    </a>
                </li>
                
                <!-- Dropdown for Layanan -->
                <li class="relative">
                    <button onclick="toggleSubmenu('submenu-layanan', 'arrow-layanan')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-primary/5 text-gray-700 font-medium group transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-grid-dots text-xl text-gray-400 group-hover:text-primary transition-colors"></i>
                            <span>Layanan</span>
                        </div>
                        <i class="ti ti-chevron-down text-gray-400 transition-transform duration-300" id="arrow-layanan"></i>
                    </button>
                    <ul id="submenu-layanan" class="hidden pl-12 pr-2 space-y-1 mt-1 pb-2">
                        <li><a href="{{ route('wakaf.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Wakaf</a></li>
                        <li><a href="{{ route('zakat.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Zakat</a></li>
                        <li><a href="{{ route('infaq.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Infaq / Sedekah</a></li>
                        <li><a href="{{ route('about-wakaf') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Tentang Wakaf</a></li>
                    </ul>
                </li>

                <!-- Dropdown for Tentang Kami -->
                <li class="relative">
                    <button onclick="toggleSubmenu('submenu-about', 'arrow-about')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-primary/5 text-gray-700 font-medium group transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-info-circle text-xl text-gray-400 group-hover:text-primary transition-colors"></i>
                            <span>Tentang Kami</span>
                        </div>
                        <i class="ti ti-chevron-down text-gray-400 transition-transform duration-300" id="arrow-about"></i>
                    </button>
                    <ul id="submenu-about" class="hidden pl-12 pr-2 space-y-1 mt-1 pb-2">
                        <li><a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Profile</a></li>
                        <li><a href="{{ route('vision-mission-wakaf') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Visi Misi</a></li>
                        <li><a href="{{ route('managers') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Pengurus</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('rekening') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/5 {{ request()->routeIs('rekening') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 font-medium' }}">
                        <i class="ti ti-credit-card text-xl {{ request()->routeIs('rekening') ? 'text-primary' : 'text-gray-400' }}"></i>
                        Rekening Donasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/5 {{ request()->routeIs('contact') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 font-medium' }}">
                        <i class="ti ti-phone text-xl {{ request()->routeIs('contact') ? 'text-primary' : 'text-gray-400' }}"></i>
                        Kontak
                    </a>
                </li>
             </ul>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-br-2xl">
             @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn btn-primary w-full text-center flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    <i class="ti ti-layout-dashboard"></i>
                    Dashboard
                </a>
             @else
                <a href="{{ route('donor.login') }}" class="btn btn-primary w-full text-center flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    <i class="ti ti-login"></i>
                    Masuk / Daftar
                </a>
             @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('mobile-menu-close');
            const overlay = document.getElementById('mobile-menu-overlay');
            const menu = document.getElementById('mobile-menu');
            const body = document.body;

            function openMenu() {
                overlay.classList.remove('hidden');
                void overlay.offsetWidth; 
                overlay.classList.remove('opacity-0');
                menu.classList.remove('-translate-x-full');
                body.style.overflow = 'hidden';
            }

            function closeMenu() {
                overlay.classList.add('opacity-0');
                menu.classList.add('-translate-x-full');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    body.style.overflow = '';
                }, 300);
            }

            if(menuBtn) menuBtn.addEventListener('click', openMenu);
            if(closeBtn) closeBtn.addEventListener('click', closeMenu);
            if(overlay) overlay.addEventListener('click', closeMenu);
        });

        function toggleSubmenu(id, arrowId) {
            const submenu = document.getElementById(id);
            const arrow = document.getElementById(arrowId);
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        // Mobile Dropdown Toggle (Generic Class-Based for Desktop Menu on small tablet)
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
                        <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-14 w-auto object-contain">
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
