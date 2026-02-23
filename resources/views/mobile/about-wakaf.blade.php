@extends('layouts.mobile_layout')

@section('title', 'Tentang Wakaf')

@section('content')
<div class="bg-primary pt-12 pb-24 px-6 rounded-b-[40px] relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <i class="ti ti-book text-9xl text-white"></i>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Tentang Wakaf</h1>
        <p class="text-white/80 text-sm">Pelajari lebih dalam mengenai keutamaan dan keberkahan berwakaf.</p>
    </div>
</div>

<div class="px-6 -mt-16 relative z-20 pb-24">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        @if($about && $about->gambar)
            <div class="mb-6 rounded-xl overflow-hidden h-48">
                <img src="{{ Str::startsWith($about->gambar, 'http') ? $about->gambar : asset($about->gambar) }}" alt="{{ $about->judul }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="prose prose-sm max-w-none text-gray-600">
            @if($about)
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ $about->judul }}</h2>
                {!! $about->deskripsi !!}
            @else
                <p class="text-center text-gray-500 italic">Konten "Tentang Wakaf" belum tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endsection
