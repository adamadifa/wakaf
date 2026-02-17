@extends('layouts.mobile_layout')

@section('title', 'Beranda')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Hero Slider Container */
    .hero-slider-container {
        position: relative;
        overflow: hidden;
        padding: 2rem 0;
    }

    /* Hero Slider */
    .hero-slider {
        padding: 2rem 0 2rem;
        overflow: hidden; /* Prevent overflow */
    }

    .heroSwiper .swiper-slide {
        width: 85%;
        height: 200px; /* More landscape */
        transition: all 0.5s ease;
        border-radius: 1rem;
        overflow: hidden;
        /* Key for coverflow feel */
        transform-origin: center bottom;
    }
    
    @media (min-width: 640px) {
        .heroSwiper .swiper-slide {
            width: 70%;
            height: 400px;
        }
    }
    
    @media (min-width: 1024px) {
        .heroSwiper .swiper-slide {
            width: 60%;
            height: 450px;
        }
    }

    .hero-slide-bg {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .hero-slide-bg::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
    }

    .hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 1.25rem; /* Reduced padding */
        color: white;
        z-index: 10;
        text-align: left;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.5s ease 0.3s;
    }

    .heroSwiper .swiper-slide-active .hero-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .heroSwiper .swiper-slide-active {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
    }

    /* Services Section */
    .service-card {
        background: white;
        border-radius: 1rem;
        padding: 1rem; /* Reduced padding */
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .service-card {
            padding: 2rem;
        }
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }
    .service-icon {
        width: 64px;
        height: 64px;
        background: var(--bg-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: var(--primary);
        font-size: 1.75rem;
        transition: all 0.3s ease;
    }
    .service-card:hover .service-icon {
        background: var(--primary);
        color: white;
    }
    .service-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }
    .service-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    /* Custom Swiper Bullet */
    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #e5e7eb;
        opacity: 1;
        transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
        background-color: var(--secondary) !important;
        width: 30px;
        border-radius: 5px;
    }
    
    /* Doa Swiper Specifics if needed, or reuse */
</style>
@endpush

@section('content')
    <!-- Hero Slider -->
    <div class="w-full bg-gray-50 pb-8">
        <div class="hero-slider swiper heroSwiper">
            <div class="swiper-wrapper">
                @forelse($sliderCampaigns as $campaign)
                    <div class="swiper-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}')">
                            <div class="hero-content">
                                <span class="inline-block px-2.5 py-0.5 bg-secondary text-white text-[10px] font-bold rounded-full mb-1">{{ $campaign->category->name ?? 'Program Unggulan' }}</span>
                                <h2 class="text-lg md:text-2xl font-bold mb-1 leading-tight">{{ $campaign->title }}</h2>
                                <a href="{{ route('campaign.show', $campaign->slug) }}" class="btn btn-xs btn-primary bg-primary border-0 text-white mt-1 text-[10px] px-3 py-1">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback Slide 1 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-lg md:text-2xl font-bold mb-1 leading-tight">Baiturrahman Berbagi</h2>
                                <p class="mb-2 text-xs md:text-sm">Kolaborasi Kemaslahatan Gapai Berkah Kebermanfaatan</p>
                            </div>
                         </div>
                    </div>
                     <!-- Fallback Slide 2 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-lg md:text-2xl font-bold mb-1 leading-tight">Salurkan Sedekah Terbaik</h2>
                                <p class="mb-2 text-xs md:text-sm">Mari bantu sesama yang membutuhkan uluran tangan kita.</p>
                            </div>
                         </div>
                    </div>
                     <!-- Fallback Slide 3 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1593113598340-0682a919c6d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-lg md:text-2xl font-bold mb-1 leading-tight">Wakaf untuk Umat</h2>
                                <p class="mb-2 text-xs md:text-sm">Investasi akhirat yang pahalanya terus mengalir abadi.</p>
                            </div>
                         </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Layanan Kami -->
    <div class="container mb-12">
        <div class="text-left mb-6 px-4">
            <h2 class="font-bold text-gray-900 text-xl">Layanan Kami</h2>
        </div>

        <div class="grid grid-cols-3 gap-3 px-4">
            <a href="{{ route('zakat.index') }}" class="service-card group !p-4">
                <div class="service-icon !mb-2 !w-12 !h-12 !text-xl">
                    <i class="ti ti-coins"></i>
                </div>
                <h3 class="service-title !text-sm !mb-0">Zakat</h3>
            </a>
            <a href="{{ route('infaq.index') }}" class="service-card group !p-4">
                <div class="service-icon !mb-2 !w-12 !h-12 !text-xl">
                    <i class="ti ti-heart-handshake"></i>
                </div>
                <h3 class="service-title !text-sm !mb-0">Infaq</h3>
            </a>
            <a href="{{ route('wakaf.index') }}" class="service-card group !p-4">
                <div class="service-icon !mb-2 !w-12 !h-12 !text-xl">
                    <i class="ti ti-building-mosque"></i>
                </div>
                <h3 class="service-title !text-sm !mb-0">Wakaf</h3>
            </a>
        </div>
    </div>

    <!-- Portal Berita -->
    <div class="bg-gray-50 py-12 mb-8">
        <div class="container px-0"> <!-- Remove padding to allow full-width swipe feeling -->
            <div class="flex justify-between items-center mb-6 px-4">
                <h2 class="font-bold text-gray-900 text-xl">Berita Terbaru</h2>
                <a href="{{ route('news.index') }}" class="text-primary text-sm font-semibold">
                    Lihat Semua
                </a>
            </div>
            
            <div class="swiper newsSwiper px-4 !pb-8">
                <div class="swiper-wrapper">
                    @forelse($latestNews as $item)
                        <div class="swiper-slide w-[80%] sm:w-[60%] h-auto">
                            <article class="bg-white rounded-xl overflow-hidden shadow-sm h-full flex flex-col border border-gray-100">
                                <a href="{{ route('news.show', $item->slug) }}" class="block flex-1 flex flex-col">
                                    <div class="relative h-40 overflow-hidden">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                                <i class="ti ti-news text-3xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded text-[10px] font-bold text-primary shadow-sm">
                                            {{ $item->category->name ?? 'Berita' }}
                                        </div>
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col">
                                        <div class="text-[10px] text-gray-400 mb-2 flex items-center gap-1">
                                            <i class="ti ti-calendar"></i>
                                            {{ $item->published_at->format('d M Y') }}
                                        </div>
                                        <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2">{{ $item->title }}</h3>
                                    </div>
                                </a>
                            </article>
                        </div>
                    @empty
                        <div class="swiper-slide w-full px-4">
                            <div class="text-center py-8 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                                <i class="ti ti-news-off text-2xl mb-2 block"></i>
                                Belum ada berita terbaru.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Doa Donatur Slider -->
    <div class="py-12 bg-[#F8F9FA]">
        <div class="text-left mb-6 px-4">
            <h2 class="font-bold text-gray-900 text-xl">Doa-doa #OrangDermawan</h2>
        </div>
        
        <div class="container relative px-4">
            <div class="swiper doaSwiper !pb-12">
                <div class="swiper-wrapper">
                    @foreach($latestDonations as $donation)
                    <div class="swiper-slide h-auto">
                        <div class="bg-white rounded-xl p-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
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
    </div>

    <!-- Managers Section -->
    <div class="py-12 bg-white">
        <div class="text-left mb-6 px-4">
            <h2 class="font-bold text-gray-900 text-xl">Struktur Pengurus</h2>
        </div>

        @if($managers->count() > 0)
        <div class="container px-4">
            <div class="swiper managerSwiper !pb-12">
                <div class="swiper-wrapper">
                    @foreach($managers as $manager)
                    <div class="swiper-slide w-[70%] sm:w-[50%]">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group text-center h-full">
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                @if($manager->image_url)
                                    <img src="{{ asset('storage/' . $manager->image_url) }}" alt="{{ $manager->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="ti ti-user text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-base font-bold text-gray-900 mb-1">{{ $manager->name }}</h3>
                                <p class="text-primary font-medium text-[10px] uppercase tracking-wide">{{ $manager->position }}</p>
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
    var swiper = new Swiper(".heroSwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 100,
            modifier: 2.5,
            slideShadows: false, // Cleaner look without dark shadows
        },
        loop: true,
        speed: 800,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        }
    });

    var newsSwiper = new Swiper(".newsSwiper", {
        slidesPerView: "auto",
        spaceBetween: 16,
        grabCursor: true,
        centeredSlides: false, // Ensure left alignment starting position if desired, or true for center
    });

    var doaSwiper = new Swiper(".doaSwiper", {
        slidesPerView: 1.2, // Show part of next slide
        spaceBetween: 16,
        centeredSlides: false,
        grabCursor: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
    });

    var managerSwiper = new Swiper(".managerSwiper", {
        slidesPerView: "auto",
        spaceBetween: 16,
        grabCursor: true,
        centeredSlides: false,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
    });
</script>
@endpush
