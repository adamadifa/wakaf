@extends('layouts.home_layout')

@section('title', $album->title)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
@endpush

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary mb-4 transition-colors">
                <i class="ti ti-arrow-left"></i> Kembali ke Galeri
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $album->title }}</h1>
            @if($album->description)
                <p class="text-gray-600 max-w-3xl text-lg leading-relaxed">{{ $album->description }}</p>
            @endif
            <div class="mt-4 text-sm text-gray-500 flex items-center gap-2">
                <i class="ti ti-calendar"></i>
                <span>{{ $album->created_at->translatedFormat('d F Y') }}</span>
                <span class="mx-2">•</span>
                <i class="ti ti-photo"></i>
                <span>{{ $album->photos->count() }} Foto</span>
            </div>
        </div>

        <!-- Photos Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($album->photos as $photo)
                <a href="{{ asset('storage/' . $photo->image_path) }}" data-fancybox="gallery" data-caption="{{ $photo->caption ?? '' }}" class="group relative block aspect-square bg-gray-100 rounded-xl overflow-hidden cursor-zoom-in">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Photo" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center text-gray-900 shadow-lg">
                            <i class="ti ti-zoom-in"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <i class="ti ti-photo-off text-3xl text-gray-400 mb-2 block"></i>
                    <p class="text-gray-500">Belum ada foto di album ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    </script>
@endpush
