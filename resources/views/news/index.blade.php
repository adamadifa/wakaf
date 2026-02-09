@extends('layouts.home_layout')

@section('title', 'Berita & Artikel')

@section('content')
<!-- Hero Section -->
<header class="hero">
    <div class="container">
        <h1 class="mb-4">Berita & Artikel</h1>
        <p class="mb-0 max-w-2xl mx-auto opacity-90">Ikuti perkembangan terbaru kegiatan dan program kebaikan yang sedang berlangsung.</p>
    </div>
</header>

<div class="container py-8">
    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-100/50 mb-10 border border-gray-100 -mt-16 relative z-10 max-w-4xl mx-auto">
        <form action="{{ route('news.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Search Input -->
            <div class="md:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ti ti-search text-gray-400 text-xl"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-gray-700 placeholder-gray-400"
                       placeholder="Cari berita atau artikel...">
            </div>

            <!-- Category Dropdown -->
            <div class="md:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ti ti-category text-gray-400 text-xl"></i>
                </div>
                <select name="category"
                        class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-gray-700 appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <i class="ti ti-chevron-down"></i>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-2">
                <button type="submit" class="w-full h-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-light transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($news as $item)
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
                        <p class="text-gray-500 line-clamp-3 mb-4 flex-1">{{ Str::limit(strip_tags($item->content), 100) }}</p>
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
                <h3 class="text-lg font-semibold text-gray-900">Belum ada berita</h3>
                <p class="text-gray-500 mt-1">Nantikan kabar terbaru dari kami.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection
