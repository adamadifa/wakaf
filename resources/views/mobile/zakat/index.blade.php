@extends('layouts.mobile_layout')

@section('title', 'Zakat')

@section('content')
    <!-- Header -->
    <div class="bg-primary pt-8 pb-12 px-6 rounded-b-[2rem] text-white text-center relative overflow-hidden mb-6">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <i class="ti ti-building-mosque text-[15rem] absolute -bottom-10 -right-10 transform rotate-12"></i>
        </div>
        <h1 class="font-bold text-2xl mb-2 relative z-10">Tunaikan Zakat</h1>
        <p class="text-sm opacity-90 relative z-10">Bersihkan harta dan jiwa dengan menunaikan zakat.</p>
    </div>

    <div class="container px-4 mb-24">
        
        <!-- Zakat Fitrah Section -->
        @if(isset($zakatTypes['fitrah']) && count($zakatTypes['fitrah']) > 0)
            <div class="mb-6">
                <h2 class="font-bold text-gray-800 text-lg mb-3 flex items-center">
                    <i class="ti ti-users text-primary mr-2"></i> Zakat Fitrah
                </h2>
                <div class="space-y-3">
                    @foreach($zakatTypes['fitrah'] as $item)
                        <a href="{{ route('zakat.show', $item->id) }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-primary transition-all group">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xl mr-4 group-hover:bg-primary group-hover:text-white transition-colors">
                                <i class="ti {{ $item->icon ?? 'ti-coins' }}"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                            </div>
                            <div class="text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all">
                                <i class="ti ti-chevron-right"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Zakat Mal Section -->
        @if(isset($zakatTypes['mal']) && count($zakatTypes['mal']) > 0)
            <div>
                <h2 class="font-bold text-gray-800 text-lg mb-3 flex items-center">
                    <i class="ti ti-briefcase text-primary mr-2"></i> Zakat Mal (Harta)
                </h2>
                <div class="space-y-3">
                    @foreach($zakatTypes['mal'] as $item)
                        <a href="{{ route('zakat.show', $item->id) }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-primary transition-all group">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xl mr-4 group-hover:bg-primary group-hover:text-white transition-colors">
                                <i class="ti {{ $item->icon ?? 'ti-coins' }}"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                            </div>
                            <div class="text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all">
                                <i class="ti ti-chevron-right"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Bottom Link -->
        <div class="mt-8 text-center text-sm text-gray-500">
            Butuh konsultasi zakat? <a href="#" class="text-primary font-bold">Chat Kami</a>
        </div>
    </div>
@endsection
