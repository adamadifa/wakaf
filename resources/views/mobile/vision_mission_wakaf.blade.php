@extends('layouts.frontend')

@section('title', 'Visi & Misi Wakaf')

@section('content')
<div class="bg-primary pt-12 pb-24 px-6 rounded-b-[40px] relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <i class="ti ti-target text-9xl text-white"></i>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Visi & Misi Wakaf</h1>
        <p class="text-white/80 text-sm">Arah dan tujuan pengelolaan wakaf kami.</p>
    </div>
</div>

<div class="px-6 -mt-16 relative z-20 space-y-6 pb-24">
    <!-- Visi Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                <i class="ti ti-eye text-xl"></i>
            </div>
            <h2 class="font-bold text-gray-900 text-lg">Visi Wakaf</h2>
        </div>
        <div class="prose prose-sm max-w-none text-gray-600">
            {!! $visionMission->visi ?? '<p class="text-gray-500 italic">Visi wakaf belum diatur.</p>' !!}
        </div>
    </div>

    <!-- Misi Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center shrink-0">
                <i class="ti ti-list-check text-xl"></i>
            </div>
            <h2 class="font-bold text-gray-900 text-lg">Misi Wakaf</h2>
        </div>
        
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
            <div class="prose prose-sm max-w-none text-gray-600">
                {!! $visionMission->misi ?? '<p class="text-gray-500 italic">Misi wakaf belum diatur.</p>' !!}
            </div>
        </div>
    </div>
</div>
@endsection
