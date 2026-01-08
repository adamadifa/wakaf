@extends('layouts.frontend')

@section('title', $campaign->title)

@push('styles')
<style>
    /* 
       Reverting to the previous Wakaf Salman-style layout.
       Removing the :root override so it uses the global Green theme from layouts.frontend.
    */
    
    body {
        background-color: #F8F9FA;
    }

    .container {
        max-width: 1140px;
    }

    .campaign-wrapper {
        padding: 3rem 0 5rem;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 3rem;
        align-items: start;
    }

    /* Left Column */
    .campaign-left {
        min-width: 0;
    }

    .breadcrumb {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .campaign-image-container {
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .campaign-image {
        width: 100%;
        height: auto;
        display: block;
        aspect-ratio: 16/9;
        object-fit: cover;
    }

    .campaign-header {
        margin-bottom: 2rem;
    }

    .campaign-title {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .organizer-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border: 1px solid #eee;
        border-radius: var(--radius);
        width: fit-content;
    }

    .organizer-logo {
        width: 40px;
        height: 40px;
        background: var(--bg-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: bold;
    }

    /* Tabs */
    .tabs-nav {
        display: flex;
        gap: 2rem;
        border-bottom: 1px solid #eee;
        margin-bottom: 2rem;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 1rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        position: relative;
    }

    .tab-btn.active {
        color: var(--primary);
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary);
    }

    .tab-section {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .tab-section.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Content Typography */
    .prose {
        line-height: 1.7;
        color: var(--text-dark);
    }
    .prose p { margin-bottom: 1rem; }

    /* Updates List */
    .update-card {
        border-left: 3px solid var(--primary);
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Donor List */
    .donor-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .donor-icon {
        width: 40px;
        height: 40px;
        background: var(--secondary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    /* Right Sticky Sidebar */
    .donation-sticky {
        position: sticky;
        top: 6rem; /* Navbar height + gap */
        background: white;
        border-radius: var(--radius);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        border: 1px solid #efefef;
    }

    .funding-status {
        margin-bottom: 1.5rem;
    }

    .amount-raised {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 0.25rem;
        display: block;
    }

    .amount-target {
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .progress-track {
        background: #eee;
        height: 8px;
        border-radius: 4px;
        margin: 1rem 0;
        overflow: hidden;
    }

    .progress-fill {
        background: var(--secondary);
        height: 100%;
        border-radius: 4px;
    }

    .meta-grid {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-dark);
    }

    .btn-donate {
        display: block;
        width: 100%;
        text-align: center;
        padding: 1rem;
        background: var(--primary);
        color: white;
        font-weight: 700;
        border-radius: 50px;
        margin-bottom: 1rem;
        transition: background 0.2s;
    }

    .btn-donate:hover {
        background: var(--primary-light);
        color: white;
    }

    .btn-whatsapp {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.75rem;
        background: white;
        border: 2px solid #25D366;
        color: #25D366;
        font-weight: 700;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }
    
    .btn-whatsapp:hover {
        background: #f0fff4;
    }

    .share-section {
        border-top: 1px solid #eee;
        padding-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .share-label {
        font-size: 0.875rem;
        font-weight: 600;
    }

    .share-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
        transition: 0.2s;
    }
    
    .share-btn:hover {
        background: #eee;
        color: #000;
    }

    @media (max-width: 900px) {
        .campaign-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .donation-sticky {
            position: static;
        }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@section('content')
<div class="container">
    <div class="campaign-wrapper">
        
        <!-- Left Content -->
        <div class="campaign-left">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a> > Program > {{ $campaign->title }}
            </div>

            <h1 class="campaign-title">{{ $campaign->title }}</h1>

            <div class="campaign-image-container">
                <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                     alt="{{ $campaign->title }}" 
                     class="campaign-image">
            </div>

            <div class="campaign-header">
                <div class="organizer-card">
                    <div class="organizer-logo">
                        <i class="ti ti-building-mosque"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600;">Penggalang Dana</div>
                        <div style="font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
                            {{ $campaign->user->name }}
                            <i class="ti ti-discount-check-filled" style="color: #1da1f2;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs-nav">
                <button class="tab-btn active" onclick="openTab(event, 'desc')">Deskripsi</button>
                <button class="tab-btn" onclick="openTab(event, 'updates')">
                    Kabar Terbaru 
                    @if($campaign->updates->count() > 0)
                    <span style="font-size: 0.75rem; background: var(--secondary); color: white; padding: 2px 8px; border-radius: 10px; margin-left: 4px;">{{ $campaign->updates->count() }}</span>
                    @endif
                </button>
                <button class="tab-btn" onclick="openTab(event, 'donors')">
                    Donatur
                    @if($campaign->donations->count() > 0)
                    <span style="font-size: 0.75rem; background: var(--secondary); color: white; padding: 2px 8px; border-radius: 10px; margin-left: 4px;">{{ $campaign->donations->count() }}</span>
                    @endif
                </button>
            </div>

            <!-- Tab Content: Deskripsi -->
            <div id="desc" class="tab-section active">
                <div class="prose">
                    <div style="white-space: pre-line;">
                        {!! $campaign->full_description !!}
                    </div>
                </div>
            </div>

            <!-- Tab Content: Updates -->
            <div id="updates" class="tab-section">
                @forelse($campaign->updates as $update)
                    <div class="update-card">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <h4 style="font-size: 1.1rem; font-weight: 700;">{{ $update->title }}</h4>
                            <small class="text-muted">{{ $update->created_at->format('d M Y') }}</small>
                        </div>
                        <p style="color: var(--text-dark);">{{ $update->content }}</p>
                    </div>
                @empty
                    <div style="padding: 2rem; text-align: center; color: var(--text-muted); background: var(--bg-light); border-radius: var(--radius);">
                        Belum ada kabar terbaru.
                    </div>
                @endforelse
            </div>

            <!-- Tab Content: Donors -->
            <div id="donors" class="tab-section">
                @forelse($campaign->donations->where('status', 'confirmed')->take(20) as $donation)
                    <div class="donor-item">
                        <div class="donor-icon">
                            <i class="ti ti-user"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; color: var(--primary);">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                                <small style="color: var(--text-muted);">{{ $donation->created_at->diffForHumans() }}</small>
                            </div>
                            <div style="font-weight: 500;">
                                {{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Tamu') }}
                            </div>
                            @if($donation->message)
                                <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 4px;">
                                    "{{ $donation->message }}"
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="padding: 2rem; text-align: center; color: var(--text-muted); background: var(--bg-light); border-radius: var(--radius);">
                        Jadilah donatur pertama!
                    </div>
                @endforelse
            </div>

        </div>

        <!-- Right Sidebar -->
        <div class="campaign-right">
            <div class="donation-sticky">
                @php
                    $percentage = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                    $daysLeft = $campaign->end_date ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false) : null;
                @endphp

                <div class="funding-status">
                    <span class="amount-raised">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                    <span class="amount-target">terkumpul dari <strong>Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong></span>
                </div>

                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ min($percentage, 100) }}%"></div>
                </div>

                <div class="meta-grid">
                    <div>
                        {{ $percentage < 1 ? number_format($percentage, 2) : number_format($percentage, 0) }}% <span style="font-weight: normal; color: var(--text-muted);">Tercapai</span>
                    </div>
                    <div>
                        @if($daysLeft !== null && $daysLeft >= 0)
                            <strong>{{ $daysLeft }}</strong> <span style="font-weight: normal; color: var(--text-muted);">Hari Lagi</span>
                        @else
                            <span style="font-weight: normal; color: var(--text-muted);">Unlimited</span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('campaign.donate', $campaign->slug) }}" class="btn-donate">
                    WAKAF SEKARANG
                </a>

                <button class="btn-whatsapp">
                    <i class="ti ti-brand-whatsapp" style="font-size: 1.25rem;"></i>
                    Wakaf via WhatsApp
                </button>

                <div class="share-section">
                    <span class="share-label">Bagikan:</span>
                    <a href="#" class="share-btn"><i class="ti ti-brand-facebook"></i></a>
                    <a href="#" class="share-btn"><i class="ti ti-brand-twitter"></i></a>
                    <a href="#" class="share-btn"><i class="ti ti-brand-whatsapp"></i></a>
                    <a href="#" class="share-btn"><i class="ti ti-link"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    
    // Hide all tab content
    tabcontent = document.getElementsByClassName("tab-section");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].classList.remove("active");
    }
    
    // Remove active class from buttons
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    
    // Show current tab and add active class to button
    document.getElementById(tabName).style.display = "block";
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>
@endsection
