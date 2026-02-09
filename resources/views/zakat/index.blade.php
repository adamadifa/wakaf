@extends('layouts.home_layout')

@section('title', 'Zakat')

@section('content')
    <!-- Hero Section -->
    <header class="hero" style="background: linear-gradient(rgba(14, 44, 76, 0.9), rgba(15, 91, 115, 0.8)), url('https://images.unsplash.com/photo-1579619623838-6f68bf262241?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
        <div class="container">
            <h1>Tunaikan Zakat</h1>
            <p>Bersihkan harta dan jiwa dengan menunaikan kewajiban zakat sesuai syariat.</p>
        </div>
    </header>

    <div class="container mb-24">
        
            <!-- Section Title (Optional, if we want to explain) -->
            <div class="text-center mb-10">
                <h2 class="section-title">Pilih Jenis Zakat</h2>
                <p class="section-subtitle">Silakan pilih jenis zakat yang ingin Anda tunaikan</p>
            </div>

            <!-- Zakat Fitrah Group -->
            <div class="mb-12">
                    <div class="bg-gray-50 px-6 py-3 text-xs font-bold text-teal uppercase tracking-widest rounded-t-xl mb-6">
                    Zakat Fitrah
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                    @if(isset($zakatTypes['fitrah']))
                        @foreach($zakatTypes['fitrah'] as $item)
                            <a href="{{ route('zakat.show', $item->id) }}" class="group block bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all relative">
                                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="ti ti-photo-off text-3xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 text-white">
                                        <i class="ti {{ $item->icon ?? 'ti-coins' }} text-xl mb-1 block opacity-80"></i>
                                        <h3 class="font-bold text-sm leading-tight">{{ $item->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Zakat Mal Group -->
            <div>
                <div class="bg-gray-50 px-6 py-3 text-xs font-bold text-teal uppercase tracking-widest rounded-t-xl mb-6">
                    Zakat Mal (Harta)
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                    @if(isset($zakatTypes['mal']))
                        @foreach($zakatTypes['mal'] as $item)
                            <a href="{{ route('zakat.show', $item->id) }}" class="group block bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all relative">
                                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="ti ti-photo-off text-3xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 text-white">
                                        <i class="ti {{ $item->icon ?? 'ti-coins' }} text-xl mb-1 block opacity-80"></i>
                                        <h3 class="font-bold text-sm leading-tight">{{ $item->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

        <!-- Bottom CTA -->
        <div class="mt-16 text-center">
            <p class="text-gray-500 mb-6">Konsultasikan zakat Anda bersama kami</p>
            <a href="#" class="btn btn-outline rounded-full px-8">
                <i class="ti ti-brand-whatsapp text-lg mr-2"></i> Chat Konsultan Zakat
            </a>
        </div>
        
    </div>
@endsection
