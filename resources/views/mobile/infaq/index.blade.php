@extends('layouts.mobile_layout')

@section('title', 'Infaq & Sedekah')

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">

    <!-- Hero Header -->
    <div class="relative bg-gradient-to-br from-[#0e2c4c] to-[#0f5b73] px-5 pt-12 pb-16 text-white text-center overflow-hidden">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative z-10">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-heart-handshake text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-extrabold mb-1">Infaq & Sedekah</h1>
            <p class="text-sm text-white/70 max-w-[280px] mx-auto leading-relaxed">Salurkan infaq terbaik Anda untuk kebaikan umat</p>

            <!-- Stats -->
            <div class="flex justify-center gap-6 mt-6">
                <div class="text-center">
                    <div class="text-xl font-extrabold">{{ $categories->count() }}</div>
                    <div class="text-[10px] text-white/60 uppercase tracking-wider font-bold">Program</div>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <div class="text-xl font-extrabold">{{ \App\Models\InfaqTransaction::where('status', 'confirmed')->count() }}</div>
                    <div class="text-[10px] text-white/60 uppercase tracking-wider font-bold">Donatur</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="px-4 -mt-8 relative z-10 space-y-4">

        @forelse($categories as $item)
        <a href="{{ route('infaq.show', $item->id) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden active:scale-[0.98] transition-transform">
            @if($item->image)
            <div class="relative h-40 w-full bg-gray-100">
                <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" 
                     alt="{{ $item->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                <span class="absolute top-3 right-3 bg-[#0f5b73]/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Infaq</span>
            </div>
            @else
            <div class="relative h-32 w-full bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center">
                <i class="ti ti-heart-handshake text-4xl text-emerald-300"></i>
                <span class="absolute top-3 right-3 bg-[#0f5b73]/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Infaq</span>
            </div>
            @endif

            <div class="p-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-teal-500 flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                        <i class="ti {{ $item->icon ?? 'ti-coins' }} text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-tight mb-1">{{ $item->name }}</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-400">
                            <i class="ti ti-users text-sm"></i>
                            <span>{{ $item->transactions()->where('status', 'confirmed')->count() }} donatur</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                        <i class="ti ti-chevron-right text-sm"></i>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-2xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-heart-off text-2xl text-gray-300"></i>
            </div>
            <h3 class="font-bold text-gray-700 mb-1">Belum Ada Program</h3>
            <p class="text-sm text-gray-400">Program infaq sedang disiapkan. Nantikan segera!</p>
        </div>
        @endforelse

    </div>

    <!-- Motivation Card -->
    <div class="px-4 mt-6">
        <div class="bg-gradient-to-br from-[#0e2c4c] to-[#0f5b73] rounded-2xl p-6 text-white text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <p class="text-lg font-bold mb-2 relative z-10">🌟 Keutamaan Infaq</p>
            <p class="text-sm text-white/80 italic leading-relaxed relative z-10">"Perumpamaan orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan sebutir benih yang menumbuhkan tujuh bulir..."</p>
            <p class="text-xs text-white/50 mt-2 relative z-10">— QS. Al-Baqarah: 261</p>
        </div>
    </div>

</div>
@endsection
