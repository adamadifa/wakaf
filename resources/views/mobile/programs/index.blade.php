@extends('layouts.frontend')

@section('title', 'Daftar Program')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header & Search -->
    <div class="bg-white px-5 pt-8 pb-4 sticky top-16 z-40 shadow-sm"> <!-- Modified top offset for fixed navbar -->
        <h1 class="font-bold text-2xl text-gray-900 mb-4">Program Kebaikan</h1>
        
        <!-- Search Bar -->
        <form action="{{ route('programs.index') }}" method="GET">
            <div class="relative">
                <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari program..." class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-100 border-none text-sm focus:ring-2 focus:ring-primary/20 placeholder-gray-400">
            </div>
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
        </form>

        <!-- Category Filter (Swiper) -->
        <div class="swiper categorySwiper mt-4 -mx-5">
            <div class="swiper-wrapper px-5">
                <div class="swiper-slide !w-auto">
                    <a href="{{ route('programs.index') }}" class="inline-block px-4 py-2 rounded-full text-xs font-bold transition-colors {{ !request('category_id') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        Semua
                    </a>
                </div>
                @foreach($categories as $category)
                <div class="swiper-slide !w-auto">
                    <a href="{{ route('programs.index', array_merge(request()->all(), ['category_id' => $category->id])) }}" class="inline-block px-4 py-2 rounded-full text-xs font-bold transition-colors {{ request('category_id') == $category->id ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        {{ $category->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Program List -->
    <div class="px-5 mt-4 space-y-5">
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
                            <span class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/30">
                                <i class="ti ti-heart"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <i class="ti ti-search text-3xl"></i>
            </div>
            <p class="font-bold text-gray-900">Program Tidak Ditemukan</p>
            <p class="text-xs text-gray-500 mt-1">Coba cari dengan kata kunci lain.</p>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $campaigns->links('pagination::simple-tailwind') }}
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
            slidesOffsetBefore: 20, // 20px (px-5)
            slidesOffsetAfter: 20,
        });
    });
</script>
@endpush
@endsection
