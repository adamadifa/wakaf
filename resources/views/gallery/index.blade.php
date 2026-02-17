@extends('layouts.home_layout')

@section('title', 'Galeri Foto')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Galeri Kegiatan</h1>
            <p class="text-gray-600">Dokumentasi kegiatan dan program penyaluran wakaf, zakat, dan infaq.</p>
        </div>

        <!-- Album Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($albums as $album)
                <a href="{{ route('gallery.show', $album->id) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-64 overflow-hidden bg-gray-200">
                        @if($album->cover_image)
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="ti ti-photo text-5xl"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-xl font-bold mb-1 leading-tight group-hover:text-primary-light transition-colors">{{ Str::limit($album->title, 50) }}</h3>
                            <div class="flex items-center gap-2 text-sm opacity-90">
                                <i class="ti ti-photo"></i>
                                <span>{{ $album->photos_count }} Foto</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-photo-off text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada album</h3>
                    <p class="text-gray-500">Galeri foto belum tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $albums->links() }}
        </div>
    </div>
</section>
@endsection
