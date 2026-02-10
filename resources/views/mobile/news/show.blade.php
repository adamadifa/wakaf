@extends('layouts.mobile_layout')

@section('title', $news->title)

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Hero Image -->
    <div class="relative h-64 bg-gray-900">
        @if($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80"></div>
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-200">
                <i class="ti ti-photo-off text-4xl"></i>
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('news.index') }}" class="absolute top-4 left-4 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
    </div>

    <!-- Content Container -->
    <div class="relative -mt-8 bg-white rounded-t-3xl px-5 py-8 min-h-[50vh]">
        <!-- Meta -->
        <div class="flex items-center gap-3 mb-4">
            @if($news->category)
                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider">
                    {{ $news->category->name }}
                </span>
            @endif
            <span class="text-gray-400 text-xs flex items-center gap-1">
                <i class="ti ti-calendar"></i>
                {{ $news->published_at->format('d M Y') }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-6">{{ $news->title }}</h1>

        <!-- Content -->
        <div class="prose prose-sm prose-blue max-w-none text-gray-600 mb-10">
            {!! $news->content !!}
        </div>

        <!-- Share & Tags -->
        <div class="border-t border-gray-100 pt-6 mb-10">
            <p class="text-sm font-bold text-gray-900 mb-3">Bagikan Berita</p>
            <div class="flex gap-3">
                <button onclick="shareNews('facebook')" class="w-10 h-10 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center">
                    <i class="ti ti-brand-facebook text-xl"></i>
                </button>
                <button onclick="shareNews('twitter')" class="w-10 h-10 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center">
                    <i class="ti ti-brand-twitter text-xl"></i>
                </button>
                <button onclick="shareNews('whatsapp')" class="w-10 h-10 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center">
                    <i class="ti ti-brand-whatsapp text-xl"></i>
                </button>
                <button onclick="copyLink(this)" class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center">
                    <i class="ti ti-link text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Related News -->
        @if($relatedNews->count() > 0)
        <div>
            <h3 class="font-bold text-lg text-gray-900 mb-4">Berita Terkait</h3>
            <div class="space-y-4">
                @foreach($relatedNews as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="flex gap-4 p-3 rounded-xl bg-gray-50 border border-gray-100 active:scale-[0.98] transition-transform">
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-white flex-shrink-0">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="ti ti-photo text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <h4 class="font-bold text-sm text-gray-900 line-clamp-2 leading-snug mb-1">{{ $item->title }}</h4>
                        <span class="text-[10px] text-gray-500">{{ $item->published_at->format('d M Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function shareNews(platform) {
        const url = '{{ url()->current() }}';
        const title = '{{ $news->title }}';
        let shareUrl = '';

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
                break;
        }

        if (shareUrl) {
            window.open(shareUrl, '_blank');
        }
    }

    function copyLink(btn) {
        const url = '{{ url()->current() }}';
        
        // Try native share first if available
        if (navigator.share) {
            navigator.share({
                title: '{{ $news->title }}',
                url: url
            }).catch(console.error);
            return;
        }

        // Fallback to clipboard
        navigator.clipboard.writeText(url).then(() => {
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="ti ti-check text-green-600"></i>';
            setTimeout(() => {
                btn.innerHTML = originalIcon;
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endpush
@endsection
