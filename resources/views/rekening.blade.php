@extends('layouts.home_layout')

@section('title', 'Rekening Donasi')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-primary/10 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x600?finance')] bg-cover bg-center opacity-10"></div>
    <div class="container relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Rekening Donasi</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Salurkan kebaikan Anda melalui rekening resmi kami.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="container">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($accounts as $account)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center p-2">
                             @if($account->image)
                                <img src="{{ asset('storage/' . $account->image) }}" alt="{{ $account->name }}" class="w-full h-full object-contain">
                            @else
                                <i class="ti ti-building-bank text-3xl text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 line-clamp-1">{{ $account->name }}</h3>
                            <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full font-medium">Aktif</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nomor Rekening</p>
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl border border-dashed border-gray-200">
                                <span class="font-mono font-bold text-lg text-gray-800" id="rek-{{ $account->id }}">{{ $account->account_number }}</span>
                                <button onclick="copyToClipboard('rek-{{ $account->id }}')" class="text-primary hover:text-primary-dark transition-colors" title="Salin">
                                    <i class="ti ti-copy text-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Atas Nama</p>
                            <p class="font-medium text-gray-800">{{ $account->account_name }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500">
                    <div class="mb-4">
                        <i class="ti ti-wallet-off text-6xl text-gray-200"></i>
                    </div>
                    <p>Belum ada rekening donasi yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center shrink-0 text-blue-600">
                <i class="ti ti-info-circle text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 mb-2">Informasi Penting</h4>
                <p class="text-sm text-blue-800 leading-relaxed">
                    Pastikan Anda mentransfer ke nomor rekening yang tertera di atas atas nama Yayasan Kami. 
                    Setelah melakukan transfer, mohon konfirmasi donasi Anda melalui halaman <a href="{{ route('wakaf.index') }}" class="underline font-semibold hover:text-blue-600">Konfirmasi Donasi</a> atau hubungi admin kami.
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(copyText).then(function() {
            // Optional: Show tooltip or toast
            alert('Nomor rekening berhasil disalin!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush
@endsection
