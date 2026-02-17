@extends('layouts.frontend')

@section('title', 'Struktur Pengurus')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-primary/10 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x600?team')] bg-cover bg-center opacity-10"></div>
    <div class="container relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Struktur Pengurus</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Tim profesional yang berdedikasi mengelola amanah wakaf.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="container">
        @if($managers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($managers as $manager)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group text-center">
                <div class="relative h-80 overflow-hidden bg-gray-100">
                    @if($manager->image_url)
                        <img src="{{ asset('storage/' . $manager->image_url) }}" alt="{{ $manager->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="ti ti-user text-6xl"></i>
                        </div>
                    @endif
                    
                    <!-- Social Overlay -->
                     <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-gradient-to-t from-black/80 to-transparent">
                        <div class="flex justify-center gap-3">
                             @if($manager->facebook)
                                <a href="{{ $manager->facebook }}" target="_blank" class="text-white hover:text-blue-400"><i class="ti ti-brand-facebook text-xl"></i></a>
                            @endif
                            @if($manager->instagram)
                                <a href="{{ $manager->instagram }}" target="_blank" class="text-white hover:text-pink-400"><i class="ti ti-brand-instagram text-xl"></i></a>
                            @endif
                            @if($manager->linkedin)
                                <a href="{{ $manager->linkedin }}" target="_blank" class="text-white hover:text-blue-600"><i class="ti ti-brand-linkedin text-xl"></i></a>
                            @endif
                            @if($manager->twitter)
                                <a href="{{ $manager->twitter }}" target="_blank" class="text-white hover:text-gray-400"><i class="ti ti-brand-x text-xl"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-primary transition-colors">{{ $manager->name }}</h3>
                    <p class="text-primary font-medium text-sm mb-4">{{ $manager->position }}</p>
                    @if($manager->bio)
                    <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">
                        {{ $manager->bio }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <i class="ti ti-users text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada data pengurus</h3>
            <p class="text-gray-500">Data pengurus akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
        </div>
        @endif
    </div>
</section>
@endsection
