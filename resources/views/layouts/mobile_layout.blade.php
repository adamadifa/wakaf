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
    <nav class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-200 shadow-sm transition-all duration-300" id="main-navbar">
        <div class="flex items-center justify-between mx-auto px-4 py-3 relative">
            <!-- Hamburger Button -->
            <button id="mobile-menu-btn" class="w-10 h-10 flex items-center justify-center text-gray-600 rounded-full hover:bg-gray-100 focus:outline-none transition-colors">
                <i class="ti ti-menu-2 text-2xl"></i>
            </button>

            <!-- Logo (Centered) -->
            <a href="{{ route('home') }}" class="nav-brand flex items-center absolute left-1/2 transform -translate-x-1/2">
                @if(request()->routeIs('wakaf.index'))
                    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-8 w-auto object-contain">
                @else
                    <img src="{{ optional($site_settings)->logo ? asset('storage/' . $site_settings->logo) : asset('images/logo-baiturrahman.png') }}" alt="{{ config('app.name') }}" class="h-8 w-auto object-contain">
                @endif
            </a>

            <!-- Right Placeholder for Balance -->
            <div class="w-10"></div> 
        </div>
    </nav>
    <div class="h-16"></div> <!-- Spacer for fixed header -->

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
                        <li><a href="{{ request()->routeIs('wakaf.index') ? route('about-wakaf') : route('about') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Profile</a></li>
                        <li><a href="{{ route('vision-mission') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Visi Misi</a></li>
                        <li><a href="{{ route('managers') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Pengurus</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:text-primary hover:bg-gray-50">Galeri</a></li>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('mobile-menu-close');
            const overlay = document.getElementById('mobile-menu-overlay');
            const menu = document.getElementById('mobile-menu');
            const body = document.body;

            function openMenu() {
                overlay.classList.remove('hidden');
                // Trigger reflow for transition
                void overlay.offsetWidth; 
                overlay.classList.remove('opacity-0');
                
                menu.classList.remove('-translate-x-full');
                body.style.overflow = 'hidden'; // Prevent scrolling
            }

            function closeMenu() {
                overlay.classList.add('opacity-0');
                menu.classList.add('-translate-x-full');
                
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    body.style.overflow = ''; // Restore scrolling
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
    </script>

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
       style="position:fixed; bottom:90px; right:16px; z-index:9999; text-decoration:none; filter:drop-shadow(0 4px 12px rgba(0,0,0,0.15));"
       title="Chat via WhatsApp">
        <span style="position:absolute; bottom:0; right:0; width:60px; height:60px; border-radius:50%; background:rgba(37,211,102,0.3); animation:wa-mob-pulse 2s ease-out infinite;"></span>
        <img src="{{ asset('images/wa_cs_character.png') }}" alt="CS" 
             style="width:60px; height:60px; object-fit:contain; border-radius:50%; background:#25D366; padding:3px; border:2px solid white; box-shadow:0 4px 20px rgba(37,211,102,0.4);">
    </a>
    <style>
        @keyframes wa-mob-pulse {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }
    </style>
    @endif
</body>
</html>
