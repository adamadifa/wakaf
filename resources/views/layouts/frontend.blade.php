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
            background: linear-gradient(rgba(37, 150, 190, 0.9), rgba(37, 150, 190, 0.8)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
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
            <a href="{{ route('home') }}" class="nav-brand">
                <img src="{{ asset('logo.png') }}" alt="Wakaf Baiturrahman" class="h-10 w-auto object-contain">
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
                <li><a href="{{ route('programs.index') }}" class="nav-link">Program</a></li>
                <li><a href="{{ route('news.index') }}" class="nav-link">Berita</a></li>
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

    <!-- Footer -->
    <footer class="bg-white pt-16 pb-8 border-t border-gray-100 mt-auto">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Column 1: Brand & Info -->
                <div class="space-y-6">
                    <a href="{{ route('home') }}" class="block">
                        <img src="{{ asset('logo.png') }}" alt="Wakaf Baiturrahman" class="h-14 w-auto object-contain">
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
                            Komplek Area Masjid Salman ITB,<br>
                            Jl. Ganesa No.7, Lebak Siliwangi,<br>
                            Coblong, Bandung City,<br>
                            West Java 40132
                        </p>
                    </div>
                </div>

                <!-- Column 4: Map -->
                <div class="rounded-xl overflow-hidden h-[250px] bg-gray-100 relative shadow-sm border border-gray-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.246075591965!2d107.60944931477218!3d-6.891075695020464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e65767b433e1%3A0x2863e00782787729!2sMasjid%20Salman%20ITB!5e0!3m2!1sen!2sid!4v1647846589324!5m2!1sen!2sid" 
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
    @stack('scripts')
</body>
</html>
