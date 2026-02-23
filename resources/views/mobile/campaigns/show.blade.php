@extends('layouts.frontend')

@section('title', $campaign->title)
@section('hide_bottom_nav', true)

@push('styles')
<style>
    .campaign-app {
        background: #f0f4f8;
        min-height: 100vh;
        padding-bottom: 5.5rem;
        max-width: 100vw;
        overflow-x: hidden;
    }

    /* --- Hero --- */
    .campaign-hero {
        position: relative;
        height: 280px;
        width: 100%;
        overflow: hidden;
    }

    .campaign-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .campaign-hero .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.3) 100%);
    }

    .campaign-hero .hero-nav {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 20;
    }

    .hero-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 1.1rem;
        transition: all 0.2s;
        text-decoration: none;
    }

    .hero-btn:active {
        transform: scale(0.9);
    }

    .hero-badge {
        position: absolute;
        bottom: 1.25rem;
        left: 1.25rem;
        z-index: 10;
    }

    .hero-badge span {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* --- Content Card --- */
    .campaign-content {
        background: white;
        border-radius: 1.5rem 1.5rem 0 0;
        margin-top: -1.5rem;
        position: relative;
        z-index: 10;
        padding: 1.5rem 1.25rem 1rem;
    }

    .campaign-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.35;
        margin-bottom: 1rem;
    }

    /* --- Organizer --- */
    .organizer-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .organizer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .organizer-label {
        font-size: 0.6rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .organizer-name {
        font-size: 0.875rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* --- Stats Grid --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .stat-card {
        background: #f8fafc;
        border-radius: 1rem;
        padding: 0.875rem 0.75rem;
        text-align: center;
    }

    .stat-value {
        font-size: 0.9rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.15rem;
    }

    .stat-value.primary { color: #2596be; }
    .stat-value.orange { color: #f59e0b; }
    .stat-value.green { color: #10b981; }

    .stat-label {
        font-size: 0.6rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* --- Progress --- */
    .progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 0.5rem;
    }

    .progress-amount {
        font-size: 1.1rem;
        font-weight: 800;
        color: #2596be;
    }

    .progress-target {
        font-size: 0.75rem;
        font-weight: 600;
        color: #9ca3af;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #f3f4f6;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #2596be, #4eb7c7);
        transition: width 1s ease;
    }

    .progress-pct {
        font-size: 0.7rem;
        font-weight: 700;
        color: #2596be;
    }

    /* --- Tabs --- */
    .campaign-tabs {
        display: flex;
        background: #f3f4f6;
        border-radius: 0.75rem;
        padding: 0.25rem;
        margin-bottom: 1.25rem;
    }

    .campaign-tab {
        flex: 1;
        padding: 0.625rem 0;
        text-align: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6b7280;
        border-radius: 0.5rem;
        border: none;
        background: none;
        cursor: pointer;
        transition: all 0.25s;
        position: relative;
    }

    .campaign-tab.active {
        background: white;
        color: #2596be;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    .campaign-tab .tab-count {
        display: inline-block;
        font-size: 0.6rem;
        background: rgba(107,114,128,0.15);
        color: #6b7280;
        padding: 0.1rem 0.4rem;
        border-radius: 0.5rem;
        margin-left: 0.2rem;
        font-weight: 600;
    }

    .campaign-tab.active .tab-count {
        background: rgba(37,150,190,0.1);
        color: #2596be;
    }

    /* --- Tab Content --- */
    .tab-panel {
        min-height: 150px;
    }

    /* --- Donor Card --- */
    .donor-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .donor-item:last-child {
        border-bottom: none;
    }

    .donor-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .donor-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1f2937;
    }

    .donor-amount {
        font-size: 0.75rem;
        font-weight: 700;
        color: #2596be;
    }

    .donor-time {
        font-size: 0.6rem;
        color: #9ca3af;
    }

    .donor-message {
        margin-top: 0.4rem;
        padding: 0.5rem 0.75rem;
        background: #f8fafc;
        border-radius: 0.625rem;
        font-size: 0.7rem;
        color: #6b7280;
        font-style: italic;
        line-height: 1.5;
    }

    /* --- Update Card --- */
    .update-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .update-item:last-child {
        border-bottom: none;
    }

    .update-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .update-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1f2937;
    }

    .update-date {
        font-size: 0.6rem;
        font-weight: 500;
        color: #9ca3af;
        background: #f3f4f6;
        padding: 0.2rem 0.5rem;
        border-radius: 0.375rem;
        white-space: nowrap;
    }

    /* --- Sticky CTA --- */
    .sticky-cta {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 0.875rem 1.25rem;
        padding-bottom: max(0.875rem, env(safe-area-inset-bottom));
        border-top: 1px solid #f3f4f6;
        z-index: 50;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .cta-share {
        width: 48px;
        height: 48px;
        border-radius: 0.875rem;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1.25rem;
        border: none;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .cta-share:active {
        transform: scale(0.92);
        background: #e5e7eb;
    }

    .cta-donate {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #2596be, #1a7a9e);
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.875rem;
        border-radius: 0.875rem;
        border: none;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(37, 150, 190, 0.35);
        transition: all 0.2s;
    }

    .cta-donate:active {
        transform: scale(0.97);
    }

    /* --- Empty State --- */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* --- Animations --- */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-stat {
        animation: countUp 0.5s ease forwards;
    }

    .animate-stat:nth-child(2) { animation-delay: 0.1s; }
    .animate-stat:nth-child(3) { animation-delay: 0.2s; }
</style>
@endpush

@section('content')
<div class="campaign-app">

    <!-- ===== Hero Image ===== -->
    <div class="campaign-hero">
        <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
             alt="{{ $campaign->title }}">
        <div class="hero-overlay"></div>

        <!-- Navigation -->
        <div class="hero-nav">
            <a href="{{ route('programs.index') }}" class="hero-btn">
                <i class="ti ti-arrow-left"></i>
            </a>
            <button onclick="shareCampaign()" class="hero-btn">
                <i class="ti ti-share"></i>
            </button>
        </div>

        <!-- Category Badge -->
        <div class="hero-badge">
            <span>{{ $campaign->category->name ?? 'Umum' }}</span>
        </div>
    </div>

    <!-- ===== Content Card ===== -->
    <div class="campaign-content">
        <h1 class="campaign-title">{{ $campaign->title }}</h1>

        <!-- Organizer -->
        <div class="organizer-row">
            <div class="organizer-avatar">
                <i class="ti ti-building-mosque"></i>
            </div>
            <div>
                <div class="organizer-label">Penggalang Dana</div>
                <div class="organizer-name">
                    {{ $campaign->user->name }}
                    <i class="ti ti-discount-check-filled" style="color: #3b82f6; font-size: 0.9rem;"></i>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        @php
            $percentage = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
            $donorCount = $campaign->donations->where('status', 'confirmed')->count();
            $daysLeft = $campaign->end_date ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false) : null;
        @endphp

        <div class="progress-section">
            <div class="progress-header">
                <span class="progress-amount">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                <span class="progress-target">dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ min($percentage, 100) }}%"></div>
            </div>
            <span class="progress-pct">{{ number_format(min($percentage, 100), 1) }}% tercapai</span>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card animate-stat">
                <div class="stat-value primary">{{ $donorCount }}</div>
                <div class="stat-label">Donatur</div>
            </div>
            <div class="stat-card animate-stat">
                <div class="stat-value orange">
                    @if($daysLeft !== null && $daysLeft >= 0)
                        {{ $daysLeft }}
                    @else
                        ∞
                    @endif
                </div>
                <div class="stat-label">Hari Lagi</div>
            </div>
            <div class="stat-card animate-stat">
                <div class="stat-value green">{{ number_format(min($percentage, 100), 0) }}%</div>
                <div class="stat-label">Tercapai</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="campaign-tabs">
            <button onclick="switchTab('desc')" id="tab-desc" class="campaign-tab active">Deskripsi</button>
            <button onclick="switchTab('updates')" id="tab-updates" class="campaign-tab">
                Kabar <span class="tab-count">{{ $campaign->updates->count() }}</span>
            </button>
            <button onclick="switchTab('donors')" id="tab-donors" class="campaign-tab">
                Donatur <span class="tab-count">{{ $donorCount }}</span>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="tab-panel">
            <!-- Description -->
            <div id="content-desc" class="tab-content block">
                <div class="prose prose-sm prose-green max-w-none text-gray-600">
                    {!! $campaign->full_description !!}
                </div>
            </div>

            <!-- Updates -->
            <div id="content-updates" class="tab-content hidden">
                @forelse($campaign->updates as $update)
                <div class="update-item">
                    <div class="update-header">
                        <h4 class="update-title">{{ $update->title }}</h4>
                        <span class="update-date">{{ $update->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="prose prose-sm prose-green max-w-none text-gray-600">
                        {!! $update->content !!}
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="ti ti-news"></i>
                    <p>Belum ada kabar terbaru</p>
                </div>
                @endforelse
            </div>

            <!-- Donors -->
            <div id="content-donors" class="tab-content hidden">
                @forelse($campaign->donations->where('status', 'confirmed')->take(20) as $donation)
                <div class="donor-item">
                    <div class="donor-avatar" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706;">
                        {{ substr($donation->is_anonymous ? 'HA' : ($donation->donor->name ?? 'G'), 0, 2) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.1rem;">
                            <span class="donor-name">{{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Tamu') }}</span>
                            <span class="donor-time">{{ $donation->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="donor-amount">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                        @if($donation->message)
                        <div class="donor-message">"{{ $donation->message }}"</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="ti ti-heart-off"></i>
                    <p>Belum ada donatur. Jadilah yang pertama!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ===== Sticky CTA ===== -->
<div class="sticky-cta">
    <button onclick="shareCampaign()" class="cta-share">
        <i class="ti ti-share"></i>
    </button>
    <a href="{{ route('campaign.donate', $campaign->slug) }}" class="cta-donate">
        <i class="ti ti-heart-handshake"></i>
        Donasi Sekarang
    </a>
</div>

<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        document.querySelectorAll('.campaign-tab').forEach(btn => {
            btn.classList.remove('active');
        });

        document.getElementById('content-' + tabName).classList.remove('hidden');
        document.getElementById('content-' + tabName).classList.add('block');
        document.getElementById('tab-' + tabName).classList.add('active');
    }

    function shareCampaign() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $campaign->title }}',
                text: 'Bantu program kebaikan ini: {{ $campaign->title }}',
                url: window.location.href,
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    }
</script>
@endsection
