@extends('layouts.home_layout')

@section('title', 'Infaq & Sedekah')

@push('styles')
<style>
    /* Hero */
    .infaq-hero {
        padding: 4rem 0;
        margin-bottom: 2rem;
        background: linear-gradient(rgba(14, 44, 76, 0.9), rgba(15, 91, 115, 0.85)), url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        text-align: center;
        color: white;
    }
    .infaq-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    .infaq-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Stats Banner */
    .stats-banner {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        display: block;
    }
    .stat-label {
        font-size: 0.85rem;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Grid */
    .infaq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        padding-bottom: 4rem;
    }

    /* Card */
    .infaq-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }
    .infaq-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }
    .infaq-card-img-wrapper {
        position: relative;
        overflow: hidden;
    }
    .infaq-card-img {
        height: 220px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .infaq-card:hover .infaq-card-img {
        transform: scale(1.08);
    }
    .infaq-card-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 50%);
    }
    .infaq-card-img-placeholder {
        height: 220px;
        width: 100%;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #81c784;
    }
    .infaq-card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--secondary);
        color: white;
        padding: 0.3rem 0.9rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.025em;
        backdrop-filter: blur(4px);
    }

    .infaq-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .infaq-card-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--primary), var(--teal));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(140, 198, 63, 0.3);
    }
    .infaq-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        color: var(--accent);
    }
    .infaq-card-desc {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        flex: 1;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .infaq-card-footer {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }
    .infaq-card-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .infaq-card-cta:hover {
        background: var(--teal);
        transform: translateX(4px);
    }
    .infaq-card-donors {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Empty State */
    .infaq-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
    }
    .infaq-empty-icon {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: #aaa;
    }

    /* Motivation Section */
    .motivation-section {
        background: linear-gradient(135deg, var(--accent), var(--teal));
        border-radius: 1rem;
        padding: 3rem;
        color: white;
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }
    .motivation-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .motivation-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .motivation-section p {
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
        line-height: 1.7;
    }
    .motivation-verse {
        font-style: italic;
        font-size: 1.1rem;
        margin: 1.5rem auto 0.5rem;
        max-width: 500px;
    }
    .motivation-ref {
        font-size: 0.85rem;
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .infaq-hero h1 { font-size: 1.8rem; }
        .stats-banner { gap: 1.5rem; }
        .stat-value { font-size: 1.5rem; }
        .infaq-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .motivation-section { padding: 2rem 1.5rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@section('content')
    <!-- Hero Section -->
    <header class="infaq-hero">
        <div class="container">
            <h1>Infaq & Sedekah</h1>
            <p>Salurkan infaq dan sedekah terbaik Anda untuk kebaikan umat. Setiap kebaikan akan dilipatgandakan.</p>

            <div class="stats-banner">
                <div class="stat-item">
                    <span class="stat-value">{{ $categories->count() }}</span>
                    <span class="stat-label">Program Tersedia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ \App\Models\InfaqTransaction::where('status', 'confirmed')->count() }}</span>
                    <span class="stat-label">Donatur</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Rp {{ number_format(\App\Models\InfaqTransaction::where('status', 'confirmed')->sum('amount'), 0, ',', '.') }}</span>
                    <span class="stat-label">Terkumpul</span>
                </div>
            </div>
        </div>
    </header>

    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-10">
            <h2 class="section-title">Pilih Program Infaq</h2>
            <p class="section-subtitle">Pilih program yang paling dekat di hati Anda dan mulai berbagi kebaikan</p>
        </div>

        <!-- Infaq Cards Grid -->
        <div class="infaq-grid">
            @forelse($categories as $item)
                <a href="{{ route('infaq.show', $item->id) }}" class="infaq-card">
                    <div class="infaq-card-img-wrapper">
                        @if($item->image)
                            <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" alt="{{ $item->name }}" class="infaq-card-img">
                            <div class="infaq-card-img-overlay"></div>
                        @else
                            <div class="infaq-card-img-placeholder">
                                <i class="ti ti-heart-handshake" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <span class="infaq-card-badge">Infaq</span>
                    </div>
                    <div class="infaq-card-body">
                        <h3 class="infaq-card-title">{{ $item->name }}</h3>
                        <div class="infaq-card-footer">
                            <span class="infaq-card-donors">
                                <i class="ti ti-users"></i>
                                {{ $item->transactions()->where('status', 'confirmed')->count() }} donatur
                            </span>
                            <span class="infaq-card-cta">
                                Infaq <i class="ti ti-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="infaq-empty">
                    <div class="infaq-empty-icon">
                        <i class="ti ti-heart-off" style="font-size: 2rem;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Belum Ada Program</h3>
                    <p style="color: var(--text-muted);">Program infaq/sedekah sedang disiapkan. Nantikan segera!</p>
                </div>
            @endforelse
        </div>

        <!-- Motivation Section -->
        <div class="motivation-section">
            <h3>🌟 Keutamaan Infaq & Sedekah</h3>
            <p class="motivation-verse">"Perumpamaan orang-orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan sebutir benih yang menumbuhkan tujuh bulir, pada tiap-tiap bulir seratus biji."</p>
            <p class="motivation-ref">— QS. Al-Baqarah: 261</p>
            <div style="margin-top: 2rem;">
                <a href="{{ route('contact') }}" class="btn btn-outline" style="border-color: rgba(255,255,255,0.5); color: white; border-radius: 50px; padding: 0.75rem 2rem;">
                    <i class="ti ti-brand-whatsapp" style="margin-right: 0.5rem;"></i> Konsultasi Infaq
                </a>
            </div>
        </div>

    </div>
@endsection
