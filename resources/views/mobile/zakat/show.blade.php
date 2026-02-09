@extends('layouts.mobile_layout')

@section('title', $zakatType->name)
@section('hide_bottom_nav', true)

@section('content')
    <!-- Header Image -->
    <div class="relative h-48 w-full bg-gray-100">
        <img src="{{ Str::startsWith($zakatType->image, 'http') ? $zakatType->image : asset($zakatType->image) }}" 
             alt="{{ $zakatType->name }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        <div class="absolute bottom-10 left-4 right-4 text-white z-10">
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 bg-primary rounded text-[10px] font-bold uppercase tracking-wider">
                    {{ $zakatType->category == 'fitrah' ? 'Zakat Fitrah' : 'Zakat Mal' }}
                </span>
            </div>
            <h1 class="font-bold text-xl leading-tight">{{ $zakatType->name }}</h1>
        </div>
        
        <!-- Back Button -->
        <a href="{{ route('zakat.index') }}" class="absolute top-4 left-4 w-8 h-8 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white/40 transition-colors">
            <i class="ti ti-arrow-left"></i>
        </a>
    </div>

    <!-- Content Form -->
    <div class="bg-white rounded-t-3xl -mt-4 relative px-5 pt-8 pb-32">
        
        <form action="{{ route('zakat.store', $zakatType->id) }}" method="POST">
            @csrf
            
            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Calculator (Only for Mal) -->
            @if($zakatType->category == 'mal')
            <div class="bg-green-50 rounded-xl p-4 border border-green-100 mb-6">
                <label class="block text-xs font-bold text-teal uppercase tracking-wider mb-2">
                    <i class="ti ti-calculator mr-1"></i> Kalkulator Zakat (2.5%)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold text-sm">Rp</span>
                    <input type="number" id="asset_amount" class="w-full pl-9 pr-3 py-2 rounded-lg border-gray-200 focus:border-primary focus:ring-0 text-sm bg-white" placeholder="Total Aset / Penghasilan">
                </div>
            </div>
            @endif

            <!-- Nominal Input -->
            <div class="mb-6">
                <label class="block font-bold text-gray-800 mb-2">Nominal Zakat</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                    <input type="number" name="amount" id="zakat_amount" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xl font-bold text-gray-900 bg-gray-50 placeholder-gray-300" placeholder="0" value="{{ old('amount') }}" required>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mb-6">
                <label class="block font-bold text-gray-800 mb-3">Metode Pembayaran</label>
                
                @if(isset($setting) && $setting->is_payment_gateway_active)
                <label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white mb-2 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5 transition-all">
                    <input type="radio" name="payment_type" value="online" class="hidden" checked onchange="togglePaymentMethod('online')">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3">
                        <i class="ti ti-credit-card"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm">Pembayaran Otomatis</div>
                        <div class="text-xs text-gray-500">QRIS, E-Wallet, Virtual Account</div>
                    </div>
                    <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center text-white peer-checked:bg-primary peer-checked:border-primary">
                        <i class="ti ti-check text-xs hidden peer-checked:block"></i>
                    </div>
                </label>
                @endif
                
                <label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5 transition-all">
                    <input type="radio" name="payment_type" value="manual" class="hidden" {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'checked' : '' }} onchange="togglePaymentMethod('manual')">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-3">
                        <i class="ti ti-building-bank"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm">Transfer Manual</div>
                        <div class="text-xs text-gray-500">Cek manual oleh admin</div>
                    </div>
                </label>
            </div>

            <!-- Manual Bank List -->
            <div id="manual-payment-options" class="space-y-2 mb-6" style="display: {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'block' : 'none' }}">
                <p class="text-xs font-bold text-gray-500 uppercase mb-2">Pilih Rekening Tujuan</p>
                @foreach($paymentMethods as $method)
                <label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5 transition-all">
                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="hidden">
                    <div class="flex-1">
                        <div class="font-bold text-sm">{{ $method->bank_name }}</div>
                        <div class="text-xs text-gray-500">{{ $method->account_number }} a.n {{ $method->account_name }}</div>
                    </div>
                    <div class="w-4 h-4 rounded-full border border-gray-300"></div>
                </label>
                @endforeach
            </div>

            <!-- Personal Info -->
            <div class="space-y-4 mb-8">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-0 text-sm bg-gray-50" placeholder="Nama / Hamba Allah" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-0 text-sm bg-gray-50" placeholder="email@contoh.com" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor WhatsApp (Opsional)</label>
                    <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-0 text-sm bg-gray-50" placeholder="08123xxxx" value="{{ old('phone') }}">
                </div>
            </div>

            <!-- Bottom Action Bar -->
            <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 pb-safe z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
                <button type="submit" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-light active:scale-[0.98] transition-all flex items-center justify-center">
                    <i class="ti ti-check mr-2"></i> Tunaikan Zakat
                </button>
            </div>
            
        </form>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script>
        function togglePaymentMethod(type) {
            const manualOptions = document.getElementById('manual-payment-options');
            const bankInputs = document.querySelectorAll('input[name="payment_method_id"]');
            
            if (type === 'manual') {
                manualOptions.style.display = 'block';
                bankInputs.forEach(input => input.required = true);
            } else {
                manualOptions.style.display = 'none';
                bankInputs.forEach(input => {
                    input.required = false;
                    input.checked = false;
                });
            }
        }

        // Calculator Logic
        document.addEventListener('DOMContentLoaded', function() {
            const assetInput = document.getElementById('asset_amount');
            const zakatInput = document.getElementById('zakat_amount');
            
            if(assetInput && zakatInput) {
                assetInput.addEventListener('input', function() {
                    const assets = parseFloat(assetInput.value) || 0;
                    const zakat = Math.round(assets * 0.025);
                    zakatInput.value = zakat;
                });
            }

            // Radio Button styling for Bank Options
            const bankRadios = document.querySelectorAll('input[name="payment_method_id"]');
            bankRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Reset all
                    bankRadios.forEach(r => {
                        const circle = r.parentElement.querySelector('.w-4');
                        circle.classList.remove('bg-primary', 'border-primary');
                        circle.classList.add('border-gray-300');
                    });
                    
                    // Set active
                    if(this.checked) {
                        const circle = this.parentElement.querySelector('.w-4');
                        circle.classList.remove('border-gray-300');
                        circle.classList.add('bg-primary', 'border-primary');
                    }
                });
            });
        });
    </script>
    <style>
        .pb-safe { padding-bottom: max(1rem, env(safe-area-inset-bottom)); }
        /* Hide global bottom nav for this page to show payment button */
        body > nav.fixed.bottom-0 { display: none !important; }
        /* Reset body padding */
        body { padding-bottom: 0 !important; }
        /* Hide scrollbar for clean look if needed */
        body::-webkit-scrollbar { width: 0; }
    </style>
    @endpush
@endsection
