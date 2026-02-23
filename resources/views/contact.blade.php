@extends('layouts.home_layout')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-primary/10 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x600?contact')] bg-cover bg-center opacity-10"></div>
    <div class="container relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami siap melayani dan menjawab pertanyaan Anda seputar program kebaikan kami.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            
            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    <p class="text-gray-600 mb-8">Jangan ragu untuk menghubungi kami melalui saluran komunikasi berikut atau kunjungi kantor kami.</p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                        <i class="ti ti-map-pin text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Alamat Kantor</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $setting->address ?? 'Alamat belum diatur.' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                        <i class="ti ti-phone text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Telepon / WhatsApp</h3>
                        <p class="text-gray-600">
                            @if($setting->phone_number)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $setting->phone_number)) }}" target="_blank" class="hover:text-primary transition-colors">
                                    {{ $setting->phone_number }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="pt-8 border-t border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="flex gap-4">
                        @if($setting->facebook)
                            <a href="{{ $setting->facebook }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#1877F2] hover:text-white transition-all">
                                <i class="ti ti-brand-facebook text-xl"></i>
                            </a>
                        @endif
                        @if($setting->instagram)
                            <a href="{{ $setting->instagram }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#E4405F] hover:text-white transition-all">
                                <i class="ti ti-brand-instagram text-xl"></i>
                            </a>
                        @endif
                        @if($setting->twitter)
                            <a href="{{ $setting->twitter }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#1DA1F2] hover:text-white transition-all">
                                <i class="ti ti-brand-x text-xl"></i>
                            </a>
                        @endif
                        @if($setting->youtube)
                            <a href="{{ $setting->youtube }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#FF0000] hover:text-white transition-all">
                                <i class="ti ti-brand-youtube text-xl"></i>
                            </a>
                        @endif
                        @if($setting->linkedin)
                            <a href="{{ $setting->linkedin }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-[#0A66C2] hover:text-white transition-all">
                                <i class="ti ti-brand-linkedin text-xl"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Maps -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 h-full min-h-[400px]">
                @if($setting->maps_embed)
                    <iframe src="{{ $setting->maps_embed }}" width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy" class="rounded-xl"></iframe>
                @else
                    <div class="w-full h-full min-h-[400px] bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <i class="ti ti-map-off text-4xl mb-2"></i>
                            <p>Peta lokasi belum diatur.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
