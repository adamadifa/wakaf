<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Wakaf & Donasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2596be',
                        secondary: '#dc8d17',
                        accent: '#4EB7C7',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .form-input:focus {
            box-shadow: 0 0 0 4px rgba(37, 150, 190, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <!-- Main Container -->
    <div class="w-full max-w-[1000px] bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] overflow-hidden grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
        
        <!-- Left Side: Visual -->
        <div class="hidden lg:flex relative bg-primary flex-col justify-between p-12 text-white overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1532629345422-7515f4d16335?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-20 mix-blend-overlay" alt="Mosque Background">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/90 to-[#1a6b8a]/90"></div>
                
                <!-- Decorative Circles -->
                <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center gap-2 text-white/90 hover:text-white transition-colors mb-8">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
                
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold leading-tight">Mari Berbagi Kebaikan Bersama Kami</h2>
                    <p class="text-white/80 text-lg leading-relaxed">
                        Bergabunglah dengan ribuan #OrangDermawan lainnya untuk menyalurkan wakaf dan donasi terbaik Anda.
                    </p>
                </div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 text-sm font-medium text-white/70">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-gray-200 flex items-center justify-center text-gray-500 text-xs">A</div>
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-gray-200 flex items-center justify-center text-gray-500 text-xs">B</div>
                        <div class="w-10 h-10 rounded-full border-2 border-primary bg-gray-200 flex items-center justify-center text-gray-500 text-xs">C</div>
                    </div>
                    <p>Bergabung bersama 5.000+ Donatur</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="p-8 md:p-12 flex flex-col justify-center bg-white relative">
            <div class="max-w-md mx-auto w-full">
                
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang! 👋</h1>
                    <p class="text-gray-500">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <i class="ti ti-mail absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="form-input w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-all text-gray-800 font-medium placeholder:text-gray-400"
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-bold text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="ti ti-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="form-input w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-all text-gray-800 font-medium placeholder:text-gray-400"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-[#1a7a9e] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/10 hover:-translate-y-0.5 transition-all duration-200">
                        Masuk Sekarang
                    </button>
                    
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-400">atau</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-primary hover:text-primary/80 transition-colors">Daftar disini</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- Mobile Home Link (only visible on small screens) -->
            <div class="mt-8 text-center lg:hidden">
                <a href="/" class="text-sm text-gray-500 hover:text-gray-900 font-medium inline-flex items-center gap-1">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
