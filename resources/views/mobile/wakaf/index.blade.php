@extends('layouts.mobile_layout')

@section('title', 'Wakaf')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Hero Section -->
    <div class="relative h-48 bg-primary rounded-b-[2rem] overflow-hidden -mx-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary-light opacity-90"></div>
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Hero" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30">
        
        <div class="relative h-full flex flex-col justify-center px-6 text-white pb-6">
            <h1 class="font-bold text-2xl mb-2 leading-tight">Mari Berbagi Kebaikan</h1>
            <p class="text-white/80 text-sm mb-4 max-w-[80%]">Salurkan infaq, sedekah, dan wakaf Anda melalui platform terpercaya.</p>
            <a href="#campaigns" class="inline-block bg-white text-primary font-bold text-sm px-6 py-2.5 rounded-full shadow-lg self-start active:scale-95 transition-transform">
                Mulai Donasi
            </a>
        </div>
    </div>

    <!-- Campaigns Section -->
    <div id="campaigns" class="px-5 mt-8">
        <div class="flex justify-between items-end mb-4">
            <div>
                <h2 class="font-bold text-lg text-gray-900">Program Pilihan</h2>
                <p class="text-xs text-gray-500">Program kebaikan yang sedang berjalan</p>
            </div>
            <a href="{{ route('programs.index') }}" class="text-xs font-bold text-primary">Lihat Semua</a>
        </div>

        <div class="space-y-4">
            @forelse($campaigns as $campaign)
            <a href="{{ route('campaign.show', $campaign->slug) }}" class="block bg-white rounded-2xl p-3 shadow-[0_2px_15px_rgba(0,0,0,0.05)] active:scale-[0.98] transition-transform">
                <div class="flex gap-4">
                    <!-- Image -->
                    <div class="w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100">
                        <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0 py-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded mb-1 inline-block">
                                {{ $campaign->category->name }}
                            </span>
                            <h3 class="font-bold text-sm text-gray-900 leading-tight line-clamp-2 mb-2">{{ $campaign->title }}</h3>
                        </div>
                        
                        <!-- Progress -->
                        <div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2 overflow-hidden">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $campaign->target_amount > 0 ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) : 0 }}%"></div>
                            </div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] text-gray-400">Terkumpul</p>
                                    <p class="text-xs font-bold text-primary">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-8 text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                <i class="ti ti-box text-2xl mb-2"></i>
                <p class="text-sm">Belum ada program saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- News Section -->
    <div class="px-5 mt-10">
        <div class="flex justify-between items-end mb-4">
            <div>
                <h2 class="font-bold text-lg text-gray-900">Kabar Terbaru</h2>
                <p class="text-xs text-gray-500">Berita & artikel terkini</p>
            </div>
            <a href="{{ route('news.index') }}" class="text-xs font-bold text-primary">Lihat Semua</a>
        </div>

        <div class="swiper newsSwiper -mx-5 px-5 pb-4">
            <div class="swiper-wrapper">
                @forelse($latestNews as $item)
                <div class="swiper-slide">
                    <a href="{{ route('news.show', $item->slug) }}" class="block group">
                        <div class="h-36 rounded-xl overflow-hidden bg-gray-100 mb-3 relative shadow-sm">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-active:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="ti ti-photo-off text-2xl"></i>
                                </div>
                            @endif
                            <div class="absolute bottom-2 left-2 bg-black/50 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-md">
                                {{ $item->published_at->format('d M Y') }}
                            </div>
                        </div>
                        <h3 class="font-bold text-sm text-gray-900 leading-tight line-clamp-2 mb-1 group-active:text-primary transition-colors">{{ $item->title }}</h3>
                    </a>
                </div>
                @empty
                <div class="swiper-slide w-full">
                    <div class="text-center py-8 text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                        <p class="text-sm">Belum ada berita terbaru.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Doa Carousel -->
    <div class="mt-8 pt-8 pb-12 bg-[#F8F9FA]">
        <div class="px-5 mb-6 text-center">
            <h2 class="font-bold text-xl text-gray-900 mb-1">Doa-doa #OrangDermawan</h2>
            <p class="text-sm text-gray-500">Doa tulus dari para donatur</p>
        </div>
        
        <div class="swiper mySwiper px-5 !pb-12">
            <div class="swiper-wrapper">
                @foreach($latestDonations as $donation)
                <div class="swiper-slide w-full"> 
                    <div class="bg-white rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 h-full flex flex-col">
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
                        <div class="text-gray-600 text-sm leading-relaxed mb-6 flex-1 italic text-center">
                            "{{ Str::limit($donation->message, 150) }}"
                        </div>
                        
                        <!-- Divider -->
                        <div class="h-px bg-gray-100 w-full mb-3"></div>
                        
                        <!-- Footer -->
                        <button class="w-full flex items-center justify-center gap-2 text-gray-500 hover:text-red-500 transition-colors text-xs font-bold uppercase tracking-wide py-2">
                            <i class="ti ti-heart-filled text-lg text-red-500"></i>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: #D1D5DB;
        opacity: 1;
        transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
        background-color: #F5A623 !important; /* Orange to match desktop */
        width: 20px;
        border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Doa Swiper
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1.1,
            spaceBetween: 16,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        // News Swiper
        var newsSwiper = new Swiper(".newsSwiper", {
            slidesPerView: 1.2,
            spaceBetween: 16,
            centeredSlides: false,
            loop: false,
        });
    });
</script>
@endsection
