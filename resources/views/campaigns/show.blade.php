@extends('layouts.frontend')

@section('title', $campaign->title)

@push('styles')
<style>
    .campaign-detail {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3rem 1rem;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
    .campaign-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: var(--radius);
        margin-bottom: 2rem;
    }
    .campaign-content {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }
    .sidebar-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        position: sticky;
        top: 2rem;
    }
    .progress-bar-bg {
        background: #eee;
        height: 10px;
        border-radius: 5px;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .progress-bar-fill {
        background: var(--primary);
        height: 100%;
        border-radius: 5px;
    }
    .fund-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .raised {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }
    .target {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text);
    }
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    
    /* Tab Styles */
    .tabs {
        display: flex;
        gap: 0.5rem;
        border-bottom: 2px solid #eee;
        margin-bottom: 2rem;
    }
    .tab-button {
        padding: 1rem 1.5rem;
        background: none;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .tab-button:hover {
        color: var(--primary);
    }
    .tab-button.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }
    .tab-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 1rem;
        margin-left: 0.5rem;
        min-width: 1.5rem;
        text-align: center;
    }
    .tab-button.active .tab-badge {
        background: var(--primary);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    
    .distribution-item, .donation-item {
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .donor-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--accent);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<div class="campaign-detail">
    <div class="detail-grid">
        <!-- Main Content -->
        <div>
            <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                 alt="{{ $campaign->title }}" 
                 class="campaign-image">
            
            <div class="campaign-content">
                <span class="card-badge" style="background: var(--accent); color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.875rem; font-weight: 600; display: inline-block; margin-bottom: 1rem;">
                    {{ $campaign->category->name }}
                </span>
                
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">{{ $campaign->title }}</h1>
                
                <p style="color: var(--text-muted); margin-bottom: 2rem;">
                    Dibuat oleh <strong>{{ $campaign->user->name }}</strong> • {{ $campaign->created_at->diffForHumans() }}
                </p>

                <div class="mb-8">
                    <div style="line-height: 1.8; white-space: pre-line;">{{ $campaign->full_description }}</div>
                </div>

                <!-- Tabs Navigation -->
                <div class="tabs">
                    <button class="tab-button active" onclick="switchTab('updates')">
                        Kabar Terbaru
                        @if($campaign->updates && $campaign->updates->count() > 0)
                            <span class="tab-badge">{{ $campaign->updates->count() }}</span>
                        @endif
                    </button>
                    <button class="tab-button" onclick="switchTab('penyaluran')">
                        Penyaluran Dana
                        @if($campaign->distributions && $campaign->distributions->count() > 0)
                            <span class="tab-badge">{{ $campaign->distributions->count() }}</span>
                        @endif
                    </button>
                    <button class="tab-button" onclick="switchTab('donatur')">
                        Donatur
                        @if($campaign->donations && $campaign->donations->count() > 0)
                            <span class="tab-badge">{{ $campaign->donations->count() }}</span>
                        @endif
                    </button>
                </div>



                <!-- Tab Content: Kabar Terbaru -->
                <div id="tab-updates" class="tab-content active">
                    @if($campaign->updates && $campaign->updates->count() > 0)
                        @foreach($campaign->updates as $update)
                        <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 2rem; margin-bottom: 2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <h3 style="font-weight: 700; font-size: 1.25rem; color: var(--text); margin: 0;">{{ $update->title }}</h3>
                                <small style="color: var(--text-muted); white-space: nowrap; margin-left: 1rem;">{{ $update->published_at->format('d M Y') }}</small>
                            </div>
                            <div style="color: var(--text-muted); line-height: 1.8; white-space: pre-line;">{!! nl2br(e($update->content)) !!}</div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <p>Belum ada kabar terbaru untuk program ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab Content: Penyaluran Dana -->
                <div id="tab-penyaluran" class="tab-content">
                    @if($campaign->distributions && $campaign->distributions->count() > 0)
                        @foreach($campaign->distributions as $distribution)
                        <div style="display: flex; gap: 1rem; padding: 1.5rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($distribution->documentation_url)
                                <div style="flex-shrink: 0;">
                                    @php
                                        $ext = pathinfo($distribution->documentation_url, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $distribution->documentation_url) }}" 
                                             alt="Dokumentasi" 
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 0.5rem; cursor: pointer;"
                                             onclick="window.open('{{ asset('storage/' . $distribution->documentation_url) }}', '_blank')">
                                    @else
                                        <a href="{{ asset('storage/' . $distribution->documentation_url) }}" target="_blank" 
                                           style="display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: var(--accent); border-radius: 0.5rem; text-decoration: none;">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary);">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                    <h3 style="font-weight: 600; font-size: 1.1rem; margin: 0;">{{ $distribution->title }}</h3>
                                    <span style="font-weight: 700; color: var(--primary); font-size: 1.1rem; white-space: nowrap; margin-left: 1rem;">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</span>
                                </div>
                                <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 0.5rem; line-height: 1.6;">{{ $distribution->description }}</p>
                                <small style="color: var(--text-muted); font-size: 0.85rem;">{{ \Carbon\Carbon::parse($distribution->distributed_at)->format('d M Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <p>Belum ada penyaluran dana untuk program ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab Content: Donatur -->
                <div id="tab-donatur" class="tab-content">
                    @if($campaign->donations && $campaign->donations->count() > 0)
                        @foreach($campaign->donations->take(20) as $donation)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #f0f0f0;">
                            <div class="donor-avatar">
                                @php
                                    $name = $donation->is_anonymous ? 'Hamba Allah' : $donation->user->name;
                                    $initials = '';
                                    $words = explode(' ', $name);
                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } else {
                                        $initials = strtoupper(substr($name, 0, 2));
                                    }
                                @endphp
                                {{ $initials }}
                            </div>
                            <div style="flex: 1;">
                                <p style="font-weight: 600; margin-bottom: 0.25rem;">{{ $name }}</p>
                                <small style="color: var(--text-muted);">{{ $donation->created_at->diffForHumans() }}</small>
                            </div>
                            <span style="font-weight: 700; color: var(--primary); font-size: 1.1rem;">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <p>Belum ada donatur untuk program ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="sidebar-card">
                <div class="fund-stats">
                    <div>
                        <div class="raised">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</div>
                        <div class="target">terkumpul dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                @php
                    $percentage = $campaign->target_amount > 0 ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                @endphp
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ min($percentage, 100) }}%"></div>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $campaign->donations ? $campaign->donations->count() : 0 }}</div>
                        <div class="stat-label">Donatur</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">
                            @if($campaign->end_date)
                                {{ max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false)) }}
                            @else
                                ∞
                            @endif
                        </div>
                        <div class="stat-label">Hari Tersisa</div>
                    </div>
                </div>

                <a href="{{ route('campaign.donate', $campaign->slug) }}" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; text-align: center; display: block;">
                    Donasi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById('tab-' + tabName).classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}
</script>
@endsection
