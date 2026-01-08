@extends('layouts.frontend')

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
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-gray-700 placeholder-gray-400"
                       placeholder="Cari berita atau artikel...">
            </div>

            <!-- Category Dropdown -->
            <div class="md:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
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
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-2">
                <button type="submit" class="w-full h-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($news as $item)
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
                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white text-sm font-medium">
                        <div class="flex items-center gap-2">
                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            {{ $item->published_at->format('d M Y') }}
                        </div>
                        @if($item->category)
                            <span class="px-2 py-1 bg-primary text-white text-xs rounded-md shadow-sm">{{ $item->category->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors">{{ $item->title }}</h3>
                    <p class="text-gray-500 line-clamp-3 mb-4">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                    <span class="inline-flex items-center text-primary font-semibold text-sm">
                        Baca Selengkapnya
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ml-1 group-hover:translate-x-1 transition-transform"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </span>
                </div>
            </a>
        </article>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="inline-flex w-16 h-16 bg-gray-100 rounded-full items-center justify-center text-gray-400 mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
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
