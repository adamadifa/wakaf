@extends('layouts.mobile_layout')

@section('title', 'Struktur Pengurus')

@section('content')
<div class="bg-primary pt-12 pb-24 px-6 rounded-b-[40px] relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <i class="ti ti-users text-9xl text-white"></i>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Struktur Pengurus</h1>
        <p class="text-white/80 text-sm">Tim yang berdedikasi untuk umat.</p>
    </div>
</div>

<div class="px-6 -mt-16 relative z-20 pb-24">
    <div class="space-y-4">
        @forelse($managers as $manager)
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-all">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 shrink-0 border-2 border-primary/20">
                     @if($manager->image_url)
                        <img src="{{ asset('storage/' . $manager->image_url) }}" alt="{{ $manager->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="ti ti-user text-2xl"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $manager->name }}</h3>
                    <p class="text-xs text-primary font-medium px-2 py-1 bg-primary/10 rounded-full inline-block">{{ $manager->position }}</p>
                    @if($manager->bio)
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $manager->bio }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                <i class="ti ti-users-off text-3xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 text-sm">Belum ada data pengurus.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
