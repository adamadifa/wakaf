@extends('layouts.frontend')

@section('title', 'Visi & Misi')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-primary/10 overflow-hidden">
    <!-- Decorative Background Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#2596be 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
    
    <div class="container relative z-10 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-white border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">Tentang Kami</span>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 font-serif">Visi & Misi</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Komitmen teguh kami dalam membangun peradaban umat melalui pengelolaan wakaf yang amanah, produktif, dan berkelanjutan.
        </p>
    </div>
</section>

<!-- Vision Section -->
<section class="py-16 relative">
    <div class="container">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-12">
                <div class="w-20 h-20 bg-primary text-white rounded-3xl rotate-3 flex items-center justify-center mx-auto mb-6 shadow-xl shadow-primary/20">
                    <i class="ti ti-eye text-4xl -rotate-3"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Visi Kami</h2>
                <div class="h-1 w-24 bg-primary mx-auto rounded-full"></div>
            </div>
            
            <div class="relative bg-white rounded-[2rem] p-10 md:p-14 shadow-xl border border-gray-100">
                <!-- Quote Icon -->
                <div class="absolute top-0 left-0 -mt-6 -ml-6 md:-ml-8 text-primary/20">
                    <i class="ti ti-quote text-8xl"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="prose prose-xl mx-auto text-gray-800 font-medium leading-relaxed font-serif">
                        @if($visionMission && $visionMission->visi)
                             {!! $visionMission->visi !!}
                        @else
                            <p class="text-gray-400 italic">"Menjadi lembaga pengelola wakaf terpercaya untuk kemaslahatan umat."</p>
                        @endif
                    </div>
                </div>
                
                 <!-- Decorative elements -->
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-primary/5 to-transparent rounded-tl-[100px] rounded-br-[2rem]"></div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-16 bg-gray-50 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-px h-full bg-gradient-to-b from-transparent via-gray-200 to-transparent left-1/2 -translate-x-1/2 hidden md:block"></div>
    
    <div class="container relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <i class="ti ti-target text-3xl text-secondary"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Misi Kami</h2>
            <p class="text-gray-500 mt-2">Langkah nyata untuk mewujudkan visi besar.</p>
        </div>

        <div class="max-w-5xl mx-auto">
             <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100">
                <div class="prose prose-lg max-w-none text-gray-600">
                     @if($visionMission && $visionMission->misi)
                        <!-- If the user content is a list, styling is handled by prose. If plain text, we wrap it. -->
                         {!! $visionMission->misi !!}
                    @else
                        <ul class="space-y-4 list-none pl-0">
                            <li class="flex items-start gap-3">
                                <i class="ti ti-check w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1 text-xs"></i>
                                <span>Mengelola aset wakaf secara produktif dan profesional.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ti ti-check w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1 text-xs"></i>
                                <span>Menyalurkan manfaat wakaf kepada mauquf 'alaih yang tepat sasaran.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ti ti-check w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1 text-xs"></i>
                                <span>Meningkatkan literasi wakaf di tengah masyarakat.</span>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values / Call to Action -->
<section class="py-20">
    <div class="container">
        <div class="bg-primary rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 font-serif">Bergabung Dalam Gerakan Kebaikan</h2>
                <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">Bersama kita wujudkan peradaban yang lebih baik melalui wakaf.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('wakaf.index') }}" class="px-8 py-3.5 bg-white text-primary rounded-xl font-bold hover:bg-gray-50 transition-colors shadow-lg shadow-black/5">
                        Mulai Berwakaf
                    </a>
                    <a href="{{ route('programs.index') }}" class="px-8 py-3.5 bg-primary-dark/30 text-white border border-white/30 rounded-xl font-bold hover:bg-primary-dark/50 transition-colors backdrop-blur-sm">
                        Lihat Program
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
