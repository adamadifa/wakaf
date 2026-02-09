@extends('layouts.mobile_layout')

@section('title', 'Dashboard Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 pb-6">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary to-primary/80 text-white px-5 pt-6 pb-8 rounded-b-3xl shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div class="flex-1">
                <p class="text-sm opacity-90 mb-1">Selamat datang kembali,</p>
                <h1 class="text-xl font-bold">{{ $donor->name }}</h1>
            </div>
            <form action="{{ route('donor.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="ti ti-logout text-xl"></i>
                </button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <i class="ti ti-heart-handshake text-2xl"></i>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Donasi</span>
                </div>
                <p class="text-2xl font-bold mb-1">{{ $donationCount }}</p>
                <p class="text-xs opacity-90">Total Transaksi</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <i class="ti ti-mosque text-2xl"></i>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Zakat</span>
                </div>
                <p class="text-2xl font-bold mb-1">{{ $zakatCount }}</p>
                <p class="text-xs opacity-90">Total Transaksi</p>
            </div>
        </div>
    </div>

    <div class="px-5 -mt-4">
        <!-- Total Contribution Card -->
        <div class="bg-white rounded-2xl shadow-lg p-5 mb-6">
            <h2 class="text-sm font-semibold text-gray-600 mb-4 flex items-center">
                <i class="ti ti-chart-pie mr-2 text-primary"></i>
                Total Kontribusi Anda
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Donasi</p>
                    <p class="text-lg font-bold text-primary">Rp {{ number_format($totalDonations, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Zakat</p>
                    <p class="text-lg font-bold text-secondary">Rp {{ number_format($totalZakat, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Total Keseluruhan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalDonations + $totalZakat, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Recent Donations -->
        @if($recentDonations->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-5 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="ti ti-heart mr-2 text-primary"></i>
                    Donasi Terbaru
                </h2>
                <a href="{{ route('donor.donations') }}" class="text-xs font-semibold text-primary hover:text-primary/80">
                    Lihat Semua
                    <i class="ti ti-chevron-right text-sm"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentDonations->take(3) as $donation)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="ti ti-gift text-primary text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate">{{ $donation->campaign->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $donation->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm text-primary">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                        <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-semibold rounded-full mt-1">
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
        <div class="bg-white rounded-2xl shadow-lg p-5 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="ti ti-mosque mr-2 text-secondary"></i>
                    Zakat Terbaru
                </h2>
                <a href="{{ route('donor.zakat') }}" class="text-xs font-semibold text-secondary hover:text-secondary/80">
                    Lihat Semua
                    <i class="ti ti-chevron-right text-sm"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentZakat->take(3) as $zakat)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-secondary/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="ti ti-coin text-secondary text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate">{{ $zakat->zakatType->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $zakat->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm text-secondary">Rp {{ number_format($zakat->amount, 0, ',', '.') }}</p>
                        <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-semibold rounded-full mt-1">
                            {{ ucfirst($zakat->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                <i class="ti ti-bolt mr-2 text-primary"></i>
                Aksi Cepat
            </h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('programs.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary/5 rounded-xl hover:bg-primary/10 transition-colors">
                    <i class="ti ti-heart-handshake text-3xl text-primary mb-2"></i>
                    <span class="text-xs font-semibold text-gray-700">Donasi Lagi</span>
                </a>
                <a href="{{ route('zakat.index') }}" class="flex flex-col items-center justify-center p-4 bg-secondary/5 rounded-xl hover:bg-secondary/10 transition-colors">
                    <i class="ti ti-mosque text-3xl text-secondary mb-2"></i>
                    <span class="text-xs font-semibold text-gray-700">Tunaikan Zakat</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
