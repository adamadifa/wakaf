@extends('layouts.mobile_layout')

@section('title', 'Rekening Donasi')

@section('content')
<!-- Header -->
<div class="bg-primary pt-12 pb-24 px-6 rounded-b-[40px] relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <i class="ti ti-wallet text-9xl text-white"></i>
    </div>
    <div class="relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Rekening Donasi</h1>
        <p class="text-white/80 text-sm">Salurkan donasi terbaik Anda.</p>
    </div>
</div>

<!-- Account List -->
<div class="px-6 -mt-16 relative z-20 space-y-4">
    
    @forelse($accounts as $account)
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center p-2 border border-gray-100">
                     @if($account->image)
                        <img src="{{ asset('storage/' . $account->image) }}" alt="{{ $account->name }}" class="w-full h-full object-contain">
                    @else
                        <i class="ti ti-building-bank text-2xl text-gray-400"></i>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $account->name }}</h3>
                    <span class="text-[10px] px-2 py-0.5 bg-green-50 text-green-700 rounded-full font-medium">Aktif</span>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-3 border border-dashed border-gray-200 mb-3 flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-gray-500 mb-1">Nomor Rekening</p>
                    <p class="font-mono font-bold text-gray-800 text-base" id="rek-mobile-{{ $account->id }}">{{ $account->account_number }}</p>
                </div>
                <button onclick="copyToClipboard('rek-mobile-{{ $account->id }}')" class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm text-primary hover:bg-primary hover:text-white transition-all active:scale-95">
                    <i class="ti ti-copy"></i>
                </button>
            </div>
            
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500">Atas Nama:</span>
                <span class="font-semibold text-gray-800">{{ $account->account_name }}</span>
            </div>
        </div>
    @empty
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
            <i class="ti ti-wallet-off text-4xl text-gray-300 mb-3"></i>
            <p class="text-sm text-gray-500">Belum ada rekening tersedia.</p>
        </div>
    @endforelse

    <!-- Info Box -->
    <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 flex gap-3">
        <i class="ti ti-info-circle text-blue-600 text-xl shrink-0 mt-0.5"></i>
        <div class="text-xs text-blue-800">
            <p class="font-bold mb-1">Konfirmasi Donasi</p>
            <p>Setelah transfer, mohon konfirmasi melalui menu <a href="{{ route('wakaf.index') }}" class="underline font-semibold">Wakaf</a> atau hubungi admin.</p>
        </div>
    </div>

</div>

<!-- Bottom Spacer -->
<div class="h-24"></div>

@push('scripts')
<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(copyText).then(function() {
            // Toast notification could be added here
           alert('Disalin!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush
@endsection
