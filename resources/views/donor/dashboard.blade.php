@extends('layouts.home_layout')

@section('title', 'Dashboard Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-5">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary to-primary/80 text-white px-8 py-10 rounded-3xl shadow-xl mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm opacity-90 mb-2">Selamat datang kembali,</p>
                    <h1 class="text-3xl font-bold mb-1">{{ $donor->name }}</h1>
                    <p class="text-sm opacity-90">{{ $donor->email }}</p>
                </div>
                <form action="{{ route('donor.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-colors flex items-center gap-2">
                        <i class="ti ti-logout text-xl"></i>
                        <span class="font-semibold">Keluar</span>
                    </button>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <i class="ti ti-heart-handshake text-3xl"></i>
                        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">Donasi</span>
                    </div>
                    <p class="text-3xl font-bold mb-1">{{ $donationCount }}</p>
                    <p class="text-sm opacity-90">Total Transaksi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <i class="ti ti-mosque text-3xl"></i>
                        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">Zakat</span>
                    </div>
                    <p class="text-3xl font-bold mb-1">{{ $zakatCount }}</p>
                    <p class="text-sm opacity-90">Total Transaksi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 md:col-span-2">
                    <p class="text-sm opacity-90 mb-2">Total Kontribusi Keseluruhan</p>
                    <p class="text-4xl font-bold">Rp {{ number_format($totalDonations + $totalZakat, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Total Contribution Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="ti ti-chart-pie mr-2 text-primary"></i>
                        Rincian Kontribusi
                    </h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-5 bg-primary/5 rounded-xl">
                            <p class="text-sm text-gray-600 mb-2">Total Donasi</p>
                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($totalDonations, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $donationCount }} transaksi</p>
                        </div>
                        <div class="p-5 bg-secondary/5 rounded-xl">
                            <p class="text-sm text-gray-600 mb-2">Total Zakat</p>
                            <p class="text-2xl font-bold text-secondary">Rp {{ number_format($totalZakat, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $zakatCount }} transaksi</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Donations -->
                @if($recentDonations->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="ti ti-heart mr-2 text-primary"></i>
                            Donasi Terbaru
                        </h2>
                        <a href="{{ route('donor.donations') }}" class="text-sm font-semibold text-primary hover:text-primary/80 flex items-center gap-1">
                            Lihat Semua
                            <i class="ti ti-chevron-right"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentDonations->take(5) as $donation)
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                <i class="ti ti-gift text-primary text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 mb-1">{{ $donation->campaign->title }}</p>
                                <p class="text-sm text-gray-500">{{ $donation->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary mb-1">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recent Zakat -->
                @if($recentZakat->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="ti ti-mosque mr-2 text-secondary"></i>
                            Zakat Terbaru
                        </h2>
                        <a href="{{ route('donor.zakat') }}" class="text-sm font-semibold text-secondary hover:text-secondary/80 flex items-center gap-1">
                            Lihat Semua
                            <i class="ti ti-chevron-right"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentZakat->take(5) as $zakat)
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center shrink-0">
                                <i class="ti ti-coin text-secondary text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 mb-1">{{ $zakat->zakatType->name }}</p>
                                <p class="text-sm text-gray-500">{{ $zakat->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-secondary mb-1">Rp {{ number_format($zakat->amount, 0, ',', '.') }}</p>
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    {{ ucfirst($zakat->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ti ti-bolt mr-2 text-primary"></i>
                        Aksi Cepat
                    </h2>
                    <div class="space-y-3">
                        <a href="{{ route('programs.index') }}" class="flex items-center gap-3 p-4 bg-primary/5 rounded-xl hover:bg-primary/10 transition-colors group">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                <i class="ti ti-heart-handshake text-2xl text-primary"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Donasi Lagi</p>
                                <p class="text-xs text-gray-500">Lihat program donasi</p>
                            </div>
                            <i class="ti ti-chevron-right text-gray-400"></i>
                        </a>
                        <a href="{{ route('zakat.index') }}" class="flex items-center gap-3 p-4 bg-secondary/5 rounded-xl hover:bg-secondary/10 transition-colors group">
                            <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center group-hover:bg-secondary/20 transition-colors">
                                <i class="ti ti-mosque text-2xl text-secondary"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Tunaikan Zakat</p>
                                <p class="text-xs text-gray-500">Hitung & bayar zakat</p>
                            </div>
                            <i class="ti ti-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-gradient-to-br from-primary/10 to-secondary/10 rounded-2xl p-6 border border-primary/20">
                    <div class="text-center">
                        <i class="ti ti-heart-handshake text-5xl text-primary mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Terima Kasih!</h3>
                        <p class="text-sm text-gray-600">
                            Kontribusi Anda sangat berarti untuk membantu sesama
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
