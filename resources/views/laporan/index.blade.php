@extends('layouts.home_layout')

@section('title', 'Laporan Bulanan')

@push('styles')
<style>
    /* Filter Form overrides if needed */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    /* Grid Styling */
    .laporan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2.5rem;
        padding-bottom: 4rem;
    }

    /* Card Styling - Matching Wakaf Salman */
    .laporan-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .laporan-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    .card-img-container {
        position: relative;
        padding-top: 133%; /* 3:4 Aspect Ratio (Vertical) */
        overflow: hidden;
        background: #f8f9fa;
    }
    .card-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .laporan-card:hover .card-img {
        transform: scale(1.05);
    }
    .card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.2);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .laporan-card:hover .card-overlay {
        opacity: 1;
    }
    .card-body {
        padding: 1.5rem;
        text-align: center;
        background: white;
        position: relative;
        z-index: 2;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    .card-meta {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 500;
    }
    
    /* Decoration */
    .card-decoration {
        width: 40px;
        height: 4px;
        background: var(--secondary);
        margin: 0 auto 1rem;
        border-radius: 2px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@section('content')
<!-- Hero Section -->
<header class="hero">
    <div class="container">
        <h1 class="mb-4">Laporan & Transparansi</h1>
        <p class="mb-0 max-w-2xl mx-auto opacity-90">Kami berkomitmen untuk menyajikan laporan pengelolaan wakaf, infaq, dan sedekah secara transparan dan akuntabel.</p>
    </div>
</header>

<div class="container py-8">
    <!-- Filter Form -->
    <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-100/50 mb-10 border border-gray-100 -mt-16 relative z-10 max-w-4xl mx-auto">
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Bulan -->
            <div class="md:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="ti ti-calendar"></i>
                </div>
                <select name="month" id="month" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-gray-700 appearance-none cursor-pointer">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <!-- Tahun -->
            <div class="md:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="ti ti-calendar-stats"></i>
                </div>
                <select name="year" id="year" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-gray-700 appearance-none cursor-pointer">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <!-- Button -->
            <div class="md:col-span-2">
                <button type="submit" class="w-full h-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                    <i class="ti ti-filter"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Grid -->
    <div class="laporan-grid">
        @forelse($laporans as $item)
        <a href="{{ $item->file ? asset('storage/' . $item->file) : '#' }}" target="_blank" class="laporan-card">
            <div class="card-img-container">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? 'Laporan' }}" class="card-img">
                @else
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: #f0f2f5;">
                        <i class="ti ti-file-analytics text-gray-300" style="font-size: 4rem;"></i>
                    </div>
                @endif
                
                <div class="card-overlay">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary shadow-lg">
                            <i class="ti ti-download" style="font-size: 1.5rem;"></i>
                        </div>
                        <span class="font-semibold">Unduh Laporan</span>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="card-decoration"></div>
                <h3 class="card-title">{{ $item->title ?? 'Laporan ' . $item->month }}</h3>
                <div class="card-meta">{{ $item->month }} {{ $item->year }}</div>
            </div>
        </a>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                <div style="width: 80px; height: 80px; background: #f9f9f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #ccc;">
                    <i class="ti ti-calendar-off" style="font-size: 2rem;"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Tidak Ada Laporan</h3>
                <p style="color: var(--text-muted);">Belum ada laporan yang tersedia untuk tahun <strong>{{ $selectedYear }}</strong>.</p>
                <a href="{{ route('laporan.index') }}" class="btn text-primary hover:underline mt-2">Lihat tahun terbaru</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
