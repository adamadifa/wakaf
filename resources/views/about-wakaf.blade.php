@extends('layouts.home_layout')

@section('title', 'Tentang Wakaf')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-primary/10 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1590076176736-459efd7863bf?q=80&w=1920&auto=format&fit=crop')] bg-cover bg-center opacity-10"></div>
    <div class="container relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Tentang Wakaf</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pelajari lebih dalam mengenai keutamaan dan keberkahan berwakaf.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="container">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            @if(isset($about->gambar))
            <div class="h-64 md:h-96 overflow-hidden">
                <img src="{{ Str::startsWith($about->gambar, 'http') ? $about->gambar : asset($about->gambar) }}" alt="{{ $about->judul }}" class="w-full h-full object-cover">
            </div>
            @endif
            
            <div class="p-8 md:p-12">
                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                    @if($about)
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $about->judul }}</h2>
                        {!! $about->deskripsi !!}
                    @else
                        <div class="text-center py-12">
                            <i class="ti ti-info-circle text-4xl text-gray-300 mb-4 block"></i>
                            <p>Konten "Tentang Wakaf" belum diatur oleh admin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
