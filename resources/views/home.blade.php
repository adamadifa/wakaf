@extends('layouts.home_layout')

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
        padding: 2rem 0 2rem; /* Reduced bottom padding */
        overflow: visible; /* Allow slides to be seen */
    }

    /* Gradient Overlays - Optional: simplified for coverflow */
    .hero-slider-container::before,
    .hero-slider-container::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        width: 15%;
        z-index: 20;
        pointer-events: none;
    }

    .hero-slider-container::before {
        left: 0;
        background: linear-gradient(to right, #f9fafb, transparent);
    }

    .hero-slider-container::after {
        right: 0;
        background: linear-gradient(to left, #f9fafb, transparent);
    }

    .swiper-slide {
        width: 85%;
        height: 300px;
        transition: all 0.5s ease;
        border-radius: 1.5rem;
        overflow: hidden;
        /* Key for coverflow feel */
        transform-origin: center bottom;
    }
    
    @media (min-width: 640px) {
        .swiper-slide {
            width: 70%;
            height: 400px;
        }
    }
    
    @media (min-width: 1024px) {
        .swiper-slide {
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
        padding: 2rem;
        color: white;
        z-index: 10;
        text-align: left;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.5s ease 0.3s;
    }

    .swiper-slide-active .hero-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .swiper-slide-active {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
    <div class="w-full bg-gray-50 pb-8 overflow-hidden">
        <div class="hero-slider swiper heroSwiper">
            <div class="swiper-wrapper">
                @forelse($sliderCampaigns as $campaign)
                    <div class="swiper-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}')">
                            <div class="hero-content">
                                <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-bold rounded-full mb-2">{{ $campaign->category->name ?? 'Program Unggulan' }}</span>
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">{{ $campaign->title }}</h2>
                                <a href="{{ route('campaign.show', $campaign->slug) }}" class="btn btn-sm btn-primary bg-primary border-0 text-white mt-2">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback Slide 1 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">Baiturrahman Berbagi</h2>
                                <p class="mb-4">Kolaborasi Kemaslahatan Gapai Berkah Kebermanfaatan</p>
                            </div>
                         </div>
                    </div>
                     <!-- Fallback Slide 2 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">Salurkan Sedekah Terbaik</h2>
                                <p class="mb-4">Mari bantu sesama yang membutuhkan uluran tangan kita.</p>
                            </div>
                         </div>
                    </div>
                     <!-- Fallback Slide 3 -->
                    <div class="swiper-slide">
                         <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1593113598340-0682a919c6d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                            <div class="hero-content">
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">Wakaf untuk Umat</h2>
                                <p class="mb-4">Investasi akhirat yang pahalanya terus mengalir abadi.</p>
                            </div>
                         </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Layanan Kami -->
    <div class="container mb-24">
        <div class="text-center mb-12">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Pilih jenis program kebaikan yang ingin Anda tunaikan</p>
        </div>

        <div class="grid grid-cols-3 gap-3 md:gap-6">
            <a href="{{ route('zakat.index') }}" class="service-card group">
                <div class="service-icon">
                    <i class="ti ti-coins"></i>
                </div>
                <h3 class="service-title">Zakat</h3>
                <p class="service-desc">Tunaikan kewajiban zakat Anda untuk membersihkan harta.</p>
            </a>
            <a href="{{ route('infaq.index') }}" class="service-card group">
                <div class="service-icon">
                    <i class="ti ti-heart-handshake"></i>
                </div>
                <h3 class="service-title">Infaq & Sedekah</h3>
                <p class="service-desc">Berbagi kebahagiaan dengan menyisihkan sebagian harta.</p>
            </a>
            <a href="{{ route('wakaf.index') }}" class="service-card group">
                <div class="service-icon">
                    <i class="ti ti-building-mosque"></i>
                </div>
                <h3 class="service-title">Wakaf</h3>
                <p class="service-desc">Investasi abadi untuk kebermanfaatan umat yang berkelanjutan.</p>
            </a>

        </div>
    </div>

    <!-- Portal Berita -->
    <div class="bg-gray-50 py-16 mb-16">
        <div class="container">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="section-title text-left mb-2">Portal Berita</h2>
                    <p class="text-gray-500">Kabar terbaru dari kegiatan Baiturrahman Berbagi</p>
                </div>
                <a href="{{ route('news.index') }}" class="hidden md:inline-flex items-center text-primary font-semibold hover:text-secondary transition-colors">
                    Lihat Semua Berita <i class="ti ti-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $item)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group h-full flex flex-col">
                        <a href="{{ route('news.show', $item->slug) }}" class="block flex-1 flex flex-col">
                            <div class="relative h-56 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i class="ti ti-news text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary shadow-sm">
                                    {{ $item->category->name ?? 'Berita' }}
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="text-xs text-gray-400 mb-3 flex items-center gap-2">
                                    <i class="ti ti-calendar"></i>
                                    {{ $item->published_at->format('d M Y') }}
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors">{{ $item->title }}</h3>
                                <p class="text-gray-500 line-clamp-2 mb-4 flex-1">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                <span class="inline-flex items-center text-primary font-semibold text-sm mt-auto">
                                    Baca Selengkapnya
                                    <i class="ti ti-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <i class="ti ti-news-off text-4xl mb-4 block"></i>
                        Belum ada berita terbaru.
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-8 md:hidden">
                <a href="{{ route('news.index') }}" class="btn btn-outline w-full">Lihat Semua Berita</a>
            </div>
        </div>
    </div>
    <!-- Doa Donatur Slider -->
    <div class="py-16 bg-[#F8F9FA]">
        <div class="text-center mb-10">
            <h2 class="font-bold text-gray-900 section-title" style="font-size: 1.75rem;">Doa-doa #OrangDermawan</h2>
        </div>
        
        <div class="container relative px-4">
            <div class="swiper doaSwiper !pb-12">
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

    <!-- Managers Section -->
    <div class="py-16 bg-white">
        <div class="container">
            <div class="text-center mb-12">
                <h2 class="section-title">Struktur Pengurus</h2>
                <p class="section-subtitle">Tim profesional yang berdedikasi mengelola amanah wakaf.</p>
            </div>

            @if($managers->count() > 0)
            @if($managers->count() > 0)
            <div class="swiper managerSwiper !pb-12">
                <div class="swiper-wrapper">
                    @foreach($managers as $manager)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group text-center h-full">
                            <div class="relative h-64 overflow-hidden bg-gray-100">
                                @if($manager->image_url)
                                    <img src="{{ asset('storage/' . $manager->image_url) }}" alt="{{ $manager->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="ti ti-user text-5xl"></i>
                                    </div>
                                @endif
                                 <!-- Social Overlay -->
                                 <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-gradient-to-t from-black/80 to-transparent">
                                    <div class="flex justify-center gap-3">
                                         @if($manager->facebook)
                                            <a href="{{ $manager->facebook }}" target="_blank" class="text-white hover:text-blue-400"><i class="ti ti-brand-facebook"></i></a>
                                        @endif
                                        @if($manager->instagram)
                                            <a href="{{ $manager->instagram }}" target="_blank" class="text-white hover:text-pink-400"><i class="ti ti-brand-instagram"></i></a>
                                        @endif
                                        @if($manager->linkedin)
                                            <a href="{{ $manager->linkedin }}" target="_blank" class="text-white hover:text-blue-600"><i class="ti ti-brand-linkedin"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-primary transition-colors">{{ $manager->name }}</h3>
                                <p class="text-primary font-medium text-xs uppercase tracking-wide">{{ $manager->position }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            @endif
            @endif
        </div>
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

    var doaSwiper = new Swiper(".doaSwiper", {
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

    var managerSwiper = new Swiper(".managerSwiper", {
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
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
    });
</script>
@endpush
