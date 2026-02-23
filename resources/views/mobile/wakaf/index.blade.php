@extends('layouts.frontend')

@section('title', 'Wakaf')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* ===== App-Like Mobile Wakaf Page ===== */

    .wakaf-app {
        background: #f0f4f8;
        min-height: 100vh;
        padding-bottom: 6rem;
        max-width: 100vw;
        overflow-x: hidden;
    }

    /* --- Greeting Header --- */
    .greeting-section {
        background: linear-gradient(135deg, #2596be 0%, #1a7a9e 50%, #0d5f7e 100%);
        padding: 1.5rem 1.25rem 2.5rem;
        border-radius: 0 0 1.75rem 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .greeting-section::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -20%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }

    .greeting-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }

    .greeting-text h2 {
        color: rgba(255,255,255,0.7);
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .greeting-text h1 {
        color: white;
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.3;
    }

    .greeting-text h1 span {
        color: #fbbf24;
    }

    /* --- Search Bar --- */
    .search-bar {
        margin: -1.25rem 1.25rem 0;
        position: relative;
        z-index: 10;
    }

    .search-bar a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.875rem 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        color: #9ca3af;
        font-size: 0.875rem;
        text-decoration: none;
        transition: box-shadow 0.2s;
    }

    .search-bar a i {
        color: #2596be;
        font-size: 1.25rem;
    }

    /* --- Quick Actions --- */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        padding: 1.5rem 1.25rem 0.5rem;
    }

    .quick-action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .quick-action-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .quick-action-item:active .quick-action-icon {
        transform: scale(0.92);
    }

    .quick-action-label {
        font-size: 0.65rem;
        font-weight: 600;
        color: #374151;
        text-align: center;
        line-height: 1.2;
    }

    /* --- Section Headers --- */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 1.25rem 0.75rem;
    }

    .section-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
    }

    .section-header a {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2596be;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* --- Featured Campaign Carousel --- */
    .featured-wrap {
        padding: 0 1.25rem;
    }

    .featured-campaign {
        overflow: hidden;
        border-radius: 1.25rem;
    }

    .featured-card {
        position: relative;
        overflow: hidden;
        height: 200px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .featured-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .featured-card .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
    }

    .featured-card .card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.25rem;
        color: white;
    }

    .featured-card .badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 0.2rem 0.6rem;
        border-radius: 0.5rem;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .featured-card .card-title {
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .featured-progress {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .featured-progress .bar {
        flex: 1;
        height: 5px;
        background: rgba(255,255,255,0.25);
        border-radius: 3px;
        overflow: hidden;
    }

    .featured-progress .bar-fill {
        height: 100%;
        background: #fbbf24;
        border-radius: 3px;
    }

    .featured-progress .amount {
        font-size: 0.7rem;
        font-weight: 700;
        color: #fbbf24;
        white-space: nowrap;
    }

    .featured-campaign .swiper-pagination-bullet {
        background: #2596be;
        opacity: 0.3;
    }

    .featured-campaign .swiper-pagination-bullet-active {
        background: #2596be;
        opacity: 1;
        width: 20px;
        border-radius: 4px;
    }

    /* --- Campaign Grid --- */
    .campaign-grid-mobile {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding: 0 1.25rem;
    }

    .campaign-card-mini {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
    }

    .campaign-card-mini:active {
        transform: scale(0.97);
    }

    .campaign-card-mini .card-img {
        height: 100px;
        overflow: hidden;
    }

    .campaign-card-mini .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .campaign-card-mini .card-body {
        padding: 0.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .campaign-card-mini .card-cat {
        font-size: 0.55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #2596be;
        background: rgba(37, 150, 190, 0.08);
        padding: 0.15rem 0.4rem;
        border-radius: 0.3rem;
        display: inline-block;
        margin-bottom: 0.4rem;
        width: fit-content;
    }

    .campaign-card-mini .card-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.35;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .campaign-card-mini .mini-progress {
        height: 4px;
        background: #f3f4f6;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.4rem;
    }

    .campaign-card-mini .mini-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
        border-radius: 2px;
    }

    .campaign-card-mini .card-amount {
        font-size: 0.6rem;
        font-weight: 700;
        color: #dc8d17;
    }

    .campaign-card-mini .card-amount span {
        font-weight: 500;
        color: #9ca3af;
    }

    /* --- News Section --- */
    .news-swiper {
        overflow: hidden;
    }

    .news-swiper .swiper-slide {
        width: 280px;
    }

    .news-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: row;
        height: 100px;
        transition: transform 0.2s;
    }

    .news-card:active {
        transform: scale(0.97);
    }

    .news-card .news-img {
        width: 100px;
        min-width: 100px;
        overflow: hidden;
    }

    .news-card .news-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-card .news-body {
        padding: 0.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
    }

    .news-card .news-date {
        font-size: 0.6rem;
        font-weight: 500;
        color: #9ca3af;
        margin-bottom: 0.25rem;
    }

    .news-card .news-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* --- Doa Section --- */
    .doa-section {
        padding: 1.5rem 0 2rem;
    }

    .doa-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .doa-card::before {
        content: '"';
        position: absolute;
        top: 0.5rem;
        right: 1rem;
        font-size: 3rem;
        font-family: Georgia, serif;
        color: rgba(37, 150, 190, 0.1);
        line-height: 1;
    }

    .doa-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .doa-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2596be, #4EB7C7);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .doa-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1f2937;
    }

    .doa-campaign {
        font-size: 0.6rem;
        color: #9ca3af;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .doa-message {
        font-size: 0.8rem;
        color: #4b5563;
        line-height: 1.6;
        font-style: italic;
        flex: 1;
        margin-bottom: 0.75rem;
    }

    .doa-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.625rem;
        border-top: 1px solid #f3f4f6;
    }

    .doa-date {
        font-size: 0.6rem;
        color: #9ca3af;
    }

    .doa-aamiin {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        background: none;
        border: none;
        color: #ef4444;
        font-size: 0.7rem;
        font-weight: 700;
        cursor: pointer;
    }

    .doa-swiper .swiper-pagination-bullet {
        background: #2596be;
        opacity: 0.3;
    }

    .doa-swiper .swiper-pagination-bullet-active {
        background: #2596be;
        opacity: 1;
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeInUp 0.5s ease forwards;
    }

    .animate-delay-1 { animation-delay: 0.1s; opacity: 0; }
    .animate-delay-2 { animation-delay: 0.2s; opacity: 0; }
    .animate-delay-3 { animation-delay: 0.3s; opacity: 0; }
</style>
@endpush

@section('content')
<div class="wakaf-app">

    <!-- ===== Greeting Header ===== -->
    <div class="greeting-section">
        <div class="greeting-text">
            <h2>Assalamualaikum 👋</h2>
            <h1>Mari Berbagi <span>Kebaikan</span><br>Melalui Wakaf</h1>
        </div>
    </div>

    <!-- ===== Search Bar ===== -->
    <div class="search-bar animate-in animate-delay-1">
        <a href="{{ route('programs.index') }}">
            <i class="ti ti-search"></i>
            <span>Cari program wakaf...</span>
        </a>
    </div>

    <!-- ===== Quick Actions ===== -->
    <!-- <div class="quick-actions animate-in animate-delay-2">
        <a href="{{ route('wakaf.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #2563eb;">
                <i class="ti ti-building-mosque"></i>
            </div>
            <span class="quick-action-label">Wakaf</span>
        </a>
        <a href="{{ route('zakat.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669;">
                <i class="ti ti-coin"></i>
            </div>
            <span class="quick-action-label">Zakat</span>
        </a>
        <a href="{{ route('infaq.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706;">
                <i class="ti ti-heart-handshake"></i>
            </div>
            <span class="quick-action-label">Infaq</span>
        </a>
        <a href="{{ route('programs.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #7c3aed;">
                <i class="ti ti-apps"></i>
            </div>
            <span class="quick-action-label">Program</span>
        </a>
    </div> -->

    <!-- ===== Featured Campaign ===== -->
    @if($campaigns->count() > 0)
    <div class="section-header">
        <h3>🔥 Program</h3>
        <a href="{{ route('programs.index') }}">Lihat Semua <i class="ti ti-chevron-right"></i></a>
    </div>

    <div class="featured-wrap">
        <div class="swiper featured-campaign !pb-8">
            <div class="swiper-wrapper">
                @foreach($campaigns->take(3) as $campaign)
                <div class="swiper-slide">
                    <a href="{{ route('campaign.show', $campaign->slug) }}" class="featured-card" style="text-decoration:none;">
                        <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <div class="badge">{{ $campaign->category->name ?? 'Umum' }}</div>
                            <div class="card-title">{{ $campaign->title }}</div>
                            @php
                                $pct = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                            @endphp
                            <div class="featured-progress">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ min($pct, 100) }}%"></div>
                                </div>
                                <div class="amount">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @endif

    <!-- ===== Campaign Grid ===== -->
    @if($campaigns->count() > 0)
    <div class="section-header" style="padding-top: 0.5rem;">
        <h3>Semua Program</h3>
        <a href="{{ route('programs.index') }}">Lihat Semua <i class="ti ti-chevron-right"></i></a>
    </div>

    <div class="campaign-grid-mobile">
        @foreach($campaigns as $campaign)
        <a href="{{ route('campaign.show', $campaign->slug) }}" class="campaign-card-mini" style="text-decoration:none;">
            <div class="card-img">
                <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}">
            </div>
            <div class="card-body">
                <div class="card-cat">{{ $campaign->category->name ?? 'Umum' }}</div>
                <div class="card-title">{{ $campaign->title }}</div>
                @php
                    $pct = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                @endphp
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width: {{ min($pct, 100) }}%"></div>
                </div>
                <div class="card-amount">
                    Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}
                    <span> terkumpul</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <!-- ===== News Section ===== -->
    @if($latestNews->count() > 0)
    <div class="section-header">
        <h3>📰 Berita Terbaru</h3>
        <a href="{{ route('news.index') }}">Selengkapnya <i class="ti ti-chevron-right"></i></a>
    </div>

    <div class="swiper news-swiper !px-5 !pb-4">
        <div class="swiper-wrapper">
            @foreach($latestNews as $item)
            <div class="swiper-slide" style="width: 280px;">
                <a href="{{ route('news.show', $item->slug) }}" class="news-card" style="text-decoration:none;">
                    <div class="news-img">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        @else
                            <div style="width:100%;height:100%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#9ca3af;">
                                <i class="ti ti-news" style="font-size:1.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="news-body">
                        <div class="news-date">
                            <i class="ti ti-calendar" style="margin-right:2px;"></i>
                            {{ $item->published_at->format('d M Y') }}
                        </div>
                        <div class="news-title">{{ $item->title }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===== Doa Donatur ===== -->
    @if($latestDonations->count() > 0)
    <div class="doa-section">
        <div class="section-header">
            <h3>🤲 Doa Para Dermawan</h3>
        </div>

        <div class="swiper doa-swiper !px-5 !pb-10">
            <div class="swiper-wrapper">
                @foreach($latestDonations as $donation)
                <div class="swiper-slide" style="height:auto;">
                    <div class="doa-card">
                        <div class="doa-header">
                            <div class="doa-avatar">
                                @if($donation->is_anonymous)
                                    HA
                                @else
                                    {{ substr($donation->donor->name ?? 'G', 0, 2) }}
                                @endif
                            </div>
                            <div style="min-width:0;flex:1;">
                                <div class="doa-name">{{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Tamu') }}</div>
                                <div class="doa-campaign">{{ $donation->campaign->title }}</div>
                            </div>
                        </div>
                        <div class="doa-message">"{{ Str::limit($donation->message, 120) }}"</div>
                        <div class="doa-footer">
                            <span class="doa-date">{{ $donation->created_at->diffForHumans() }}</span>
                            <button class="doa-aamiin">
                                <i class="ti ti-heart-filled"></i>
                                Aamiin
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Featured Campaign Swiper
        new Swiper(".featured-campaign", {
            slidesPerView: 1,
            spaceBetween: 0,
            grabCursor: true,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".featured-campaign .swiper-pagination",
                clickable: true,
            },
        });

        // News Swiper
        new Swiper(".news-swiper", {
            slidesPerView: 'auto',
            spaceBetween: 12,
            grabCursor: true,
            freeMode: true,
        });

        // Doa Swiper
        new Swiper(".doa-swiper", {
            slidesPerView: 1.15,
            spaceBetween: 12,
            grabCursor: true,
            centeredSlides: false,
            pagination: {
                el: ".doa-swiper .swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });

        // Animate elements on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.campaign-card-mini, .section-header').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush
