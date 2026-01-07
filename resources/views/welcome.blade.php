@extends('layouts.frontend')

@section('title', 'Beranda')

@push('styles')
<style>
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
        background: var(--accent);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.75rem;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.4;
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
        background: var(--primary);
        height: 100%;
        border-radius: 4px;
    }
    .fund-stats {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .raised { font-weight: 700; color: var(--primary); }
    .target { color: var(--text-muted); }
</style>
@endpush

@section('content')
    <header class="hero">
        <div class="container">
            <h1>Mari Berbagi Kebaikan</h1>
            <p>Salurkan infaq, sedekah, dan wakaf Anda melalui platform terpercaya untuk membantu sesama.</p>
            <a href="#campaigns" class="btn btn-primary" style="background: white; color: var(--primary);">Mulai Donasi</a>
        </div>
    </header>

    <div class="container" id="campaigns">
        <div class="text-center mb-2">
            <h2 class="section-title">Program Pilihan</h2>
            <p class="section-subtitle">Daftar program kebaikan yang sedang berjalan</p>
        </div>

        <div class="campaign-grid">
            @forelse($campaigns as $campaign)
            <div class="campaign-card">
                <img src="{{ Storage::url($campaign->image_url) }}" alt="{{ $campaign->title }}" class="card-img">
                <div class="card-body">
                    <div>
                        <span class="card-badge">{{ $campaign->category->name }}</span>
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
                <div class="text-center" style="grid-column: 1/-1; padding: 4rem;">
                    <p style="color: var(--text-muted);">Belum ada program kampanye yang aktif saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
