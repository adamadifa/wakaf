@extends('layouts.mobile_layout')

@section('title', 'Berita & Artikel')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header & Search -->
    <div class="bg-white px-5 pt-8 pb-4 sticky top-16 z-40 shadow-sm">
        <h1 class="font-bold text-2xl text-gray-900 mb-4">Kabar Terbaru</h1>
        
        <!-- Search Bar -->
        <form action="{{ route('news.index') }}" method="GET">
            <div class="relative">
                <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-100 border-none text-sm focus:ring-2 focus:ring-primary/20 placeholder-gray-400">
            </div>
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>

        <!-- Category Filter (Swiper) -->
        <div class="swiper categorySwiper mt-4 -mx-5">
            <div class="swiper-wrapper px-5">
                <div class="swiper-slide !w-auto">
                    <a href="{{ route('news.index') }}" class="inline-block px-4 py-2 rounded-full text-xs font-bold transition-colors {{ !request('category') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        Semua
                    </a>
                </div>
                @foreach($categories as $category)
                <div class="swiper-slide !w-auto">
                    <a href="{{ route('news.index', array_merge(request()->all(), ['category' => $category->slug])) }}" class="inline-block px-4 py-2 rounded-full text-xs font-bold transition-colors {{ request('category') == $category->slug ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        {{ $category->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- News List -->
    <div class="px-5 mt-4 space-y-5">
        @forelse($news as $item)
        <a href="{{ route('news.show', $item->slug) }}" class="block bg-white rounded-2xl p-3 shadow-[0_2px_15px_rgba(0,0,0,0.05)] active:scale-[0.98] transition-transform">
            <div class="flex gap-4">
                <!-- Image -->
                <div class="w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 relative">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                            <i class="ti ti-photo-off text-2xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0 py-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">
                                {{ $item->category->name ?? 'Umum' }}
                            </span>
                            <span class="text-[10px] text-gray-400">
                                {{ $item->published_at->format('d M Y') }}
                            </span>
                        </div>
                        <h3 class="font-bold text-sm text-gray-900 leading-tight line-clamp-2 mb-2">{{ $item->title }}</h3>
                        <p class="text-xs text-gray-500 line-clamp-2">
                           {!! Str::limit(strip_tags($item->content), 80) !!}
                        </p>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <i class="ti ti-search text-3xl"></i>
            </div>
            <p class="font-bold text-gray-900">Berita Tidak Ditemukan</p>
            <p class="text-xs text-gray-500 mt-1">Coba cari dengan kata kunci lain.</p>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $news->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".categorySwiper", {
            slidesPerView: "auto",
            spaceBetween: 8,
            freeMode: true,
            slidesOffsetBefore: 20,
            slidesOffsetAfter: 20,
        });
    });
</script>
@endpush
@endsection
