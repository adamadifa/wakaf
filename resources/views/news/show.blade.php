@extends('layouts.home_layout')

@section('title', $news->title)

@push('meta')
    @section('meta_og', true)
    <meta property="og:title" content="{{ $news->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($news->content), 150) }}">
    <meta property="og:image" content="{{ $news->image ? asset('storage/' . $news->image) : asset('logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
@endpush

@section('content')
<!-- Hero Section (Mini) -->
<header class="relative py-20 bg-gray-900 text-white overflow-hidden rounded-b-[2rem] mb-12">
    @if($news->image)
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover opacity-30 blur-sm">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
    @endif
    
    <div class="container relative z-10 text-center">
        <div class="inline-flex items-center gap-3 mb-6">
            @if($news->category)
                <span class="px-3 py-1 rounded-full bg-primary text-xs font-bold text-white uppercase tracking-wider shadow-lg">{{ $news->category->name }}</span>
            @endif
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur text-sm font-medium text-white border border-white/20">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                {{ $news->published_at->format('d F Y') }}
            </div>
        </div>
        <h1 class="text-3xl md:text-5xl font-bold max-w-4xl mx-auto leading-tight">{{ $news->title }}</h1>
    </div>
</header>

<div class="container py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <article class="lg:col-span-2">
            @if($news->image)
                <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full">
                </div>
            @endif

            <div class="prose prose-lg prose-blue max-w-none text-gray-700">
                {!! $news->content !!}
            </div>

            <!-- Share Section (Optional Placeholder) -->
            <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                <span class="font-semibold text-gray-900">Bagikan artikel ini:</span>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-100 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                    </button>
                </div>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8">
            <!-- Search Widget (Optional - can be added later) -->
            
            <!-- Related News -->
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2-3h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-2m-2-4h2"/></svg>
                    Berita Lainnya
                </h3>
                
                <div class="space-y-6">
                    @forelse($relatedNews as $item)
                        <a href="{{ route('news.show', $item->slug) }}" class="group block">
                            <div class="flex gap-4">
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 leading-snug group-hover:text-primary transition-colors mb-1">{{ $item->title }}</h4>
                                    <span class="text-xs text-gray-500">{{ $item->published_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm text-center">Tidak ada berita terkait saat ini.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Program CTA Widget -->
            <div class="bg-primary rounded-2xl p-6 text-white text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-2">Mari Berbagi Kebaikan</h3>
                    <p class="text-white/90 text-sm mb-6">Salurkan donasi terbaik Anda untuk program kebaikan.</p>
                    <a href="{{ route('programs.index') }}" class="inline-block w-full py-3 bg-white text-primary font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                        Mulai Donasi
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
