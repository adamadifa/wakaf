@extends('layouts.frontend')

@section('title', 'Semua Program')

@push('styles')
<style>
    /* Reusing styles from welcome.blade.php for consistency */
    .campaign-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        padding-bottom: 4rem;
    }
    .campaign-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }
    .campaign-card:hover {
        transform: translateY(-5px);
    }
    .card-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    .card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .card-badge {
        background: var(--secondary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 0.75rem;
        letter-spacing: 0.025em;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        color: var(--primary);
    }
    .card-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        flex: 1;
    }
    .progress-section {
        margin-top: auto;
    }
    .progress-bar-bg {
        background: #eee;
        height: 8px;
        border-radius: 4px;
        margin-bottom: 0.5rem;
        overflow: hidden;
    }
    .progress-bar-fill {
        background: var(--secondary); /* Orange */
        height: 100%;
        border-radius: 4px;
    }
    .fund-stats {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .raised { font-weight: 700; color: var(--secondary); }
    .target { color: var(--text-muted); }
    
    /* Search Bar Specific Styles */
    .search-container {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }
    .search-input {
        width: 100%;
        padding: 1rem 1.5rem;
        padding-left: 3rem;
        border: 1px solid #ddd;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        color: var(--text-dark);
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(17, 53, 94, 0.15);
        outline: none;
    }
    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }
    .search-btn {
        position: absolute;
        right: 0.5rem;
        top: 0.5rem;
        bottom: 0.5rem;
        padding: 0 1.5rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .search-btn:hover {
        background: var(--primary-light);
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@section('content')
<!-- Header with Search -->
<header class="hero" style="padding: 4rem 0; margin-bottom: 2rem; background: linear-gradient(rgba(37, 150, 190, 0.9), rgba(37, 150, 190, 0.8)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="container">
        <h1 class="mb-2" style="font-size: 2.5rem;">Temukan Program Kebaikan</h1>
        <p class="mb-4" style="font-size: 1.1rem; opacity: 0.9;">Pilih program wakaf, infaq, dan sedekah yang ingin Anda bantu.</p>
        
        <form action="{{ route('programs.index') }}" method="GET" class="search-container">
            <i class="ti ti-search search-icon" style="font-size: 1.25rem;"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari program kebaikan..." class="search-input">
            <button type="submit" class="search-btn">Cari</button>
        </form>
    </div>
</header>

<div class="container">
    @if(request('q'))
        <div class="mb-4">
            <p class="text-muted">Menampilkan hasil pencarian untuk: <strong>"{{ request('q') }}"</strong></p>
        </div>
    @endif

    <div class="campaign-grid">
        @forelse($campaigns as $campaign)
        <div class="campaign-card">
            <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}" class="card-img">
            <div class="card-body">
                <div>
                    <span class="card-badge">{{ $campaign->category->name ?? 'Umum' }}</span>
                </div>
                <h3 class="card-title">{{ $campaign->title }}</h3>
                <p class="card-desc">{{ Str::limit($campaign->short_description, 100) }}</p>
                
                <div class="progress-section">
                    @php
                        $percentage = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                    @endphp
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <div class="fund-stats">
                        <span class="raised">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                        <span class="target">Target: Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('campaign.show', $campaign->slug) }}" class="btn btn-primary" style="width: 100%">Donasi Sekarang</a>
                </div>
            </div>
        </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                <div style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #aaa;">
                    <i class="ti ti-search" style="font-size: 2rem;"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Program Tidak Ditemukan</h3>
                <p style="color: var(--text-muted);">Kami tidak menemukan program dengan kata kunci "<strong>{{ request('q') }}</strong>".</p>
                <a href="{{ route('programs.index') }}" class="btn btn-outline" style="margin-top: 1.5rem;">Lihat Semua Program</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; margin-top: 2rem;">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection
