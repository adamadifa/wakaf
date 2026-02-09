@extends('layouts.mobile_layout')

@section('title', 'Donasi Sekarang')
@section('hide_bottom_nav', true)

@section('content')
<div class="min-h-screen bg-gray-50 pb-32">
    <!-- Header -->
    <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center gap-4 sticky top-0 z-40">
        <a href="{{ url()->previous() }}" class="text-gray-900 hover:text-primary transition-colors">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <h1 class="font-bold text-lg text-gray-900">Masukan Nominal Donasi</h1>
    </div>

    <form action="{{ route('campaign.store', $campaign->slug) }}" method="POST" id="donation-form">
        @csrf
        
        <div class="p-5 space-y-6">
            <!-- Campaign Info -->
            <div class="flex gap-3 bg-white p-3 rounded-2xl shadow-sm border border-gray-100">
                <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                     alt="{{ $campaign->title }}" 
                     class="w-16 h-16 rounded-xl object-cover bg-gray-100">
                <div class="flex-1 min-w-0 flex flex-col justify-center">
                    <p class="text-xs text-primary font-bold mb-0.5">Donasi untuk Program</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-tight line-clamp-2">{{ $campaign->title }}</h3>
                </div>
            </div>

            <!-- Nominal Input -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-900 mb-2">Nominal Donasi (Rp)</label>
                <div class="relative mb-4">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                    <input type="number" name="amount" id="amount" class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-primary focus:ring-primary text-lg font-bold text-gray-900" placeholder="Min. 10.000" min="10000" required>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="setAmount(50000)" class="py-2.5 px-4 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">Rp 50.000</button>
                    <button type="button" onclick="setAmount(100000)" class="py-2.5 px-4 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">Rp 100.000</button>
                    <button type="button" onclick="setAmount(200000)" class="py-2.5 px-4 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">Rp 200.000</button>
                    <button type="button" onclick="setAmount(500000)" class="py-2.5 px-4 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">Rp 500.000</button>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-900 mb-3">Metode Pembayaran</label>
                
                <div class="grid grid-cols-2 gap-3 mb-4">
                    @if(isset($setting) && $setting->is_payment_gateway_active)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_type" value="online" class="peer sr-only" onchange="togglePaymentMethod('online')" checked>
                        <div class="p-3 rounded-xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <i class="ti ti-credit-card text-2xl mb-1 text-gray-400 peer-checked:text-primary block"></i>
                            <span class="block text-xs font-bold text-gray-700 peer-checked:text-primary">Otomatis</span>
                        </div>
                    </label>
                    @endif
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_type" value="manual" class="peer sr-only" onchange="togglePaymentMethod('manual')" {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'checked' : '' }}>
                        <div class="p-3 rounded-xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <i class="ti ti-building-bank text-2xl mb-1 text-gray-400 peer-checked:text-primary block"></i>
                            <span class="block text-xs font-bold text-gray-700 peer-checked:text-primary">Transfer Manual</span>
                        </div>
                    </label>
                </div>

                <!-- Online Info -->
                <div id="online-payment-info" class="text-center p-4 bg-gray-50 rounded-xl" style="display: {{ (isset($setting) && $setting->is_payment_gateway_active) ? 'block' : 'none' }};">
                    <i class="ti ti-shield-check text-2xl text-green-500 mb-2"></i>
                    <p class="font-bold text-sm text-gray-900">Pembayaran Aman & Otomatis</p>
                    <p class="text-xs text-gray-500 mt-1">QRIS, E-Wallet, Virtual Account (Verifikasi Otomatis)</p>
                </div>

                <!-- Manual Options -->
                <div id="manual-payment-options" class="space-y-3" style="display: {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'block' : 'none' }};">
                    @foreach($paymentMethods as $method)
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="text-primary focus:ring-primary border-gray-300">
                        <div class="flex-1">
                            @if($method->logo_url)
                                <img src="{{ Storage::url($method->logo_url) }}" alt="{{ $method->bank_name }}" class="h-6 object-contain mb-1">
                            @else
                                <p class="font-bold text-sm text-gray-900">{{ $method->bank_name }}</p>
                            @endif
                            <p class="text-xs text-gray-500">{{ $method->account_number }} a.n {{ $method->account_name }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Donor Details -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Diri</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Nomor WhatsApp (Opsional)</label>
                        <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                    </div>
                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <label for="is_anonymous" class="text-sm text-gray-600">Sembunyikan nama saya (Hamba Allah)</label>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-900 mb-2">Doa & Dukungan (Opsional)</label>
                <textarea name="message" rows="3" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="Tuliskan doa atau dukungan untuk program ini..."></textarea>
            </div>
        </div>

        <!-- Sticky Bottom Button -->
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 pb-safe z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
            <button type="submit" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-light active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span>Lanjut Pembayaran</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<script>
    function setAmount(value) {
        document.getElementById('amount').value = value;
    }

    function togglePaymentMethod(type) {
        const manualOptions = document.getElementById('manual-payment-options');
        const onlineInfo = document.getElementById('online-payment-info');
        const bankInputs = document.querySelectorAll('input[name="payment_method_id"]');
        
        if (type === 'manual') {
            manualOptions.style.display = 'block';
            onlineInfo.style.display = 'none';
            bankInputs.forEach(input => input.required = true);
        } else {
            manualOptions.style.display = 'none';
            onlineInfo.style.display = 'block';
            bankInputs.forEach(input => {
                input.required = false;
                input.checked = false;
            });
        }
    }
</script>

<style>
    .pb-safe { padding-bottom: max(1rem, env(safe-area-inset-bottom)); }
</style>
@endsection
