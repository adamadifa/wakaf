@extends('layouts.mobile_layout')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Header -->
<div class="bg-primary pt-12 pb-24 px-6 rounded-b-[40px] relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <i class="ti ti-headset text-9xl text-white"></i>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Hubungi Kami</h1>
        <p class="text-white/80 text-sm">Kami siap membantu dan menjawab pertanyaan Anda.</p>
    </div>
</div>

<!-- Contact Cards -->
<div class="px-6 -mt-16 relative z-20 space-y-4">
    
    <!-- Address -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center shrink-0 text-primary">
            <i class="ti ti-map-pin text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Alamat Kantor</h3>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $setting->address ?? 'Alamat belum diatur.' }}</p>
        </div>
    </div>

    <!-- Phone -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center shrink-0 text-primary">
            <i class="ti ti-phone text-xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Telepon / WhatsApp</h3>
            <p class="text-xs text-gray-500 mb-2">Hubungi kami untuk respon cepat.</p>
            @if($setting->phone_number)
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $setting->phone_number)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors">
                    <i class="ti ti-brand-whatsapp text-sm"></i>
                    Chat WhatsApp
                </a>
            @else
                <span class="text-xs text-gray-400">-</span>
            @endif
        </div>
    </div>
    
    <!-- Social Media -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 text-sm mb-4">Ikuti Kami</h3>
        <div class="flex justify-between">
             @if($setting->facebook)
                <a href="{{ $setting->facebook }}" target="_blank" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 group-active:scale-95 transition-all">
                        <i class="ti ti-brand-facebook text-xl"></i>
                    </div>
                    <span class="text-[10px] text-gray-400">Facebook</span>
                </a>
            @endif
            @if($setting->instagram)
                <a href="{{ $setting->instagram }}" target="_blank" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 group-active:scale-95 transition-all">
                        <i class="ti ti-brand-instagram text-xl"></i>
                    </div>
                    <span class="text-[10px] text-gray-400">Instagram</span>
                </a>
            @endif
            @if($setting->twitter)
                <a href="{{ $setting->twitter }}" target="_blank" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 group-active:scale-95 transition-all">
                        <i class="ti ti-brand-x text-xl"></i>
                    </div>
                    <span class="text-[10px] text-gray-400">Twitter</span>
                </a>
            @endif
             @if($setting->youtube)
                <a href="{{ $setting->youtube }}" target="_blank" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 group-active:scale-95 transition-all">
                        <i class="ti ti-brand-youtube text-xl"></i>
                    </div>
                    <span class="text-[10px] text-gray-400">YouTube</span>
                </a>
            @endif
             @if($setting->linkedin)
                <a href="{{ $setting->linkedin }}" target="_blank" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 group-active:scale-95 transition-all">
                        <i class="ti ti-brand-linkedin text-xl"></i>
                    </div>
                    <span class="text-[10px] text-gray-400">LinkedIn</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Maps -->
    <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
        @if($setting->maps_embed)
            <iframe src="{{ $setting->maps_embed }}" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-xl"></iframe>
        @else
            <div class="w-full h-[200px] bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <i class="ti ti-map-off text-2xl mb-2"></i>
                    <p class="text-xs">Peta lokasi belum diatur.</p>
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Bottom Spacer for Tab Bar -->
<div class="h-24"></div>
@endsection
