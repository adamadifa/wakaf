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
        background: #f3f4f6;
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
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
    .raised { font-weight: 700; color: var(--secondary); } /* Orange */
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
                <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}" class="card-img">
                <div class="card-body">
                    <div>
                        <span class="card-badge">{{ $campaign->category->name ?? 'Umum' }}</span>
                    </div>
                    <h3 class="card-title">
                    <a href="{{ route('campaign.show', $campaign->slug) }}" style="text-decoration: none; color: inherit;">
                        {{ $campaign->title }}
                    </a>
                </h3>
                <p class="card-desc">{!! Str::limit(strip_tags($campaign->short_description), 100) !!}</p>
                    
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

        <div class="text-center mt-8 mb-12">
            <a href="{{ route('programs.index') }}" class="btn btn-outline px-8 rounded-full">
                Lihat Semua Program <i class="ti ti-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- News Section -->
        <div class="container mb-24">
            <div class="text-center mb-12">
                <h2 class="section-title">Berita & Artikel</h2>
                <p class="section-subtitle">Informasi dan kabar terbaru dari kegiatan kami</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $item)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-lg shadow-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <a href="{{ route('news.show', $item->slug) }}" class="block">
                            <div class="relative h-48 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white text-sm font-medium flex items-center gap-2">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    {{ $item->published_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors">{{ $item->title }}</h3>
                                <p class="text-gray-500 line-clamp-2 mb-4">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                <span class="inline-flex items-center text-primary font-semibold text-sm">
                                    Baca Selengkapnya
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ml-1 group-hover:translate-x-1 transition-transform"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </span>
                            </div>
                        </a>
                    </article>
                @empty
                 <div class="col-span-full text-center text-gray-500">Belum ada berita terbaru.</div>
                @endforelse
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('news.index') }}" class="btn btn-outline px-8 rounded-full">
                    Lihat Berita Lainnya <i class="ti ti-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Doa Donatur Slider -->
        <div class="py-16 bg-[#F8F9FA]">
            <div class="text-center mb-10">
                <h2 class="font-bold text-gray-900" style="font-size: 1.75rem;">Doa-doa #OrangDermawan</h2>
            </div>
            
            <div class="container relative px-4">
                <div class="swiper mySwiper !pb-12">
                    <div class="swiper-wrapper">
                        @foreach($latestDonations as $donation)
                        <div class="swiper-slide h-auto">
                            <div class="bg-white rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
                                <!-- Header -->
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-full bg-[#F3F4F6] flex items-center justify-center text-xs font-bold text-gray-600 shrink-0 border border-gray-200">
                                        @if($donation->is_anonymous)
                                            HA
                                        @else
                                            {{ substr($donation->donor->name ?? 'G', 0, 2) }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm mb-1 truncate">
                                            {{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Tamu') }}
                                        </h4>
                                        <div class="flex items-center text-[10px] text-gray-500 leading-none">
                                            <span class="truncate max-w-[120px]">{{ $donation->campaign->title }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $donation->created_at->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Message -->
                                <div class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">
                                    {{ Str::limit($donation->message, 150) }}
                                </div>
                                
                                <!-- Divider -->
                                <div class="h-px bg-gray-100 w-full mb-3"></div>
                                
                                <!-- Footer -->
                                <button class="w-full flex items-center justify-center gap-2 text-gray-500 hover:text-red-500 transition-colors text-xs font-bold uppercase tracking-wide py-2">
                                    <i class="ti ti-heart-filled text-lg"></i>
                                    <span>Aamiin</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #D1D5DB;
        opacity: 1;
        transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
        background-color: #D4AF37 !important; /* Gold color like reference */
        width: 10px;
    }
    .section-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 24,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
        });
    });
</script>
@endpush
