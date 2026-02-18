@extends('layouts.mobile_layout')

@section('title', $category->name)
@section('hide_bottom_nav', true)

@section('content')
<div class="min-h-screen bg-gray-50 pb-32">
    <!-- Hero Image -->
    @if($category->image)
    <div class="relative h-52 w-full bg-gray-200">
        <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : asset($category->image) }}" 
             alt="{{ $category->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/30"></div>
        <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-20">
            <a href="{{ route('infaq.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white">
                <i class="ti ti-arrow-left"></i>
            </a>
            <button onclick="shareInfaq()" class="w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white">
                <i class="ti ti-share"></i>
            </button>
        </div>
    </div>
    @else
    <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center gap-4 sticky top-0 z-40">
        <a href="{{ route('infaq.index') }}" class="text-gray-900"><i class="ti ti-arrow-left text-xl"></i></a>
        <h1 class="font-bold text-lg text-gray-900">{{ $category->name }}</h1>
    </div>
    @endif

    <!-- Category Info -->
    <div class="bg-white {{ $category->image ? 'rounded-t-3xl -mt-6 relative z-10' : '' }} px-5 pt-6 pb-5 shadow-sm">
        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded mb-2 inline-block uppercase tracking-wider">Infaq</span>
        <h1 class="font-bold text-xl text-gray-900 leading-tight mb-4">{{ $category->name }}</h1>

        <!-- Stats -->
        <div class="flex gap-3 mb-5">
            <div class="flex-1 bg-gradient-to-br from-[#0E2C4C] to-[#0F5B73] rounded-xl p-3 text-center text-white">
                <div class="text-lg font-extrabold">Rp {{ number_format($totalCollected, 0, ',', '.') }}</div>
                <div class="text-[10px] opacity-70 uppercase tracking-wider font-bold mt-0.5">Terkumpul</div>
            </div>
            <div class="w-20 bg-green-50 border border-green-100 rounded-xl p-3 text-center flex-shrink-0">
                <div class="text-lg font-extrabold text-primary">{{ $donorCount }}</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mt-0.5">Donatur</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-gray-100">
            <button onclick="switchTab('form')" id="tab-form" class="flex-1 py-3 text-sm font-bold text-primary border-b-2 border-primary transition-colors">Donasi</button>
            <button onclick="switchTab('desc')" id="tab-desc" class="flex-1 py-3 text-sm font-bold text-gray-400 border-b-2 border-transparent transition-colors">Deskripsi</button>
            <button onclick="switchTab('donors')" id="tab-donors" class="flex-1 py-3 text-sm font-bold text-gray-400 border-b-2 border-transparent transition-colors">
                Donatur <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full ml-1">{{ $donorCount }}</span>
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="px-4 pt-5 space-y-4">

        <!-- Form Tab -->
        <div id="content-form" class="tab-content block">
            <form action="{{ route('infaq.store', $category->id) }}" method="POST" id="infaq-form">
                @csrf

                @if($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-xl text-sm mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Nominal -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Nominal Infaq (Rp)</label>
                    <div class="relative mb-4">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                        <input type="number" name="amount" id="amount" class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-primary text-lg font-bold text-gray-900" placeholder="Min. 10.000" min="10000" value="{{ old('amount') }}" required>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setAmount(50000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">50rb</button>
                        <button type="button" onclick="setAmount(100000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">100rb</button>
                        <button type="button" onclick="setAmount(200000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">200rb</button>
                        <button type="button" onclick="setAmount(500000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">500rb</button>
                        <button type="button" onclick="setAmount(1000000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">1jt</button>
                        <button type="button" onclick="setAmount(2000000)" class="py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-primary hover:text-primary transition-all">2jt</button>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        @if(isset($setting) && $setting->is_payment_gateway_active)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_type" value="online" class="peer sr-only" onchange="togglePaymentMethod('online')" checked>
                            <div class="p-3 rounded-xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                                <i class="ti ti-credit-card text-2xl mb-1 text-gray-400 block"></i>
                                <span class="block text-xs font-bold text-gray-700">Otomatis</span>
                            </div>
                        </label>
                        @endif
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_type" value="manual" class="peer sr-only" onchange="togglePaymentMethod('manual')" {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                                <i class="ti ti-building-bank text-2xl mb-1 text-gray-400 block"></i>
                                <span class="block text-xs font-bold text-gray-700">Transfer Manual</span>
                            </div>
                        </label>
                    </div>

                    <!-- Online Info -->
                    <div id="online-payment-info" class="text-center p-4 bg-gray-50 rounded-xl" style="display: {{ (isset($setting) && $setting->is_payment_gateway_active) ? 'block' : 'none' }};">
                        <i class="ti ti-shield-check text-2xl text-green-500 mb-2"></i>
                        <p class="font-bold text-sm text-gray-900">Pembayaran Aman & Otomatis</p>
                        <p class="text-xs text-gray-500 mt-1">QRIS, E-Wallet, Virtual Account</p>
                    </div>

                    <!-- Manual Options -->
                    <div id="manual-payment-options" class="space-y-3" style="display: {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'block' : 'none' }};">
                        @foreach($paymentMethods as $method)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="text-primary focus:ring-primary border-gray-300">
                            <div class="flex-1">
                                @if($method->logo_url)
                                    <img src="{{ $method->logo_url }}" alt="{{ $method->bank_name }}" class="h-6 object-contain mb-1">
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
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <h3 class="font-bold text-sm text-gray-900 mb-4 pb-2 border-b border-gray-100">Data Diri</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Nomor WhatsApp (Opsional)</label>
                            <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-primary text-sm" value="{{ old('phone') }}">
                        </div>
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="is_anonymous" class="text-sm text-gray-600">Sembunyikan nama saya (Hamba Allah)</label>
                        </div>
                    </div>
                </div>

                <!-- Doa -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Doa & Dukungan (Opsional)</label>
                    <textarea name="message" rows="3" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="Tuliskan doa atau dukungan...">{{ old('message') }}</textarea>
                </div>
            </form>
        </div>

        <!-- Description Tab -->
        <div id="content-desc" class="tab-content hidden">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                @if($category->description)
                <div class="prose prose-sm max-w-none text-gray-600">
                    {!! $category->description !!}
                </div>
                @else
                <div class="text-center py-6 text-gray-400">
                    <i class="ti ti-file-text text-2xl mb-2"></i>
                    <p class="text-sm">Belum ada deskripsi.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Donors Tab -->
        <div id="content-donors" class="tab-content hidden space-y-3">
            @forelse($recentDonors as $donor)
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center flex-shrink-0">
                    <i class="ti ti-heart-handshake"></i>
                </div>
                <div class="flex-1 border-b border-gray-50 pb-3">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-gray-900 text-sm">{{ $donor->is_anonymous ? 'Hamba Allah' : $donor->name }}</span>
                        <span class="text-xs text-gray-400">{{ $donor->confirmed_at ? $donor->confirmed_at->diffForHumans() : $donor->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="font-bold text-primary text-sm mb-1">Rp {{ number_format($donor->amount, 0, ',', '.') }}</p>
                    @if($donor->message)
                    <div class="bg-gray-50 p-2 rounded-lg text-xs text-gray-500 italic">"{{ $donor->message }}"</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <i class="ti ti-heart-off text-2xl mb-2"></i>
                <p class="text-sm">Belum ada donatur. Jadilah yang pertama!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Sticky Bottom Button -->
<div id="sticky-btn" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 pb-safe z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
    <button type="submit" form="infaq-form" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
        <span>Salurkan Infaq</span>
        <i class="ti ti-arrow-right"></i>
    </button>
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

    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('block'));
        
        document.querySelectorAll('button[id^="tab-"]').forEach(btn => {
            btn.classList.remove('text-primary', 'border-primary');
            btn.classList.add('text-gray-400', 'border-transparent');
        });

        document.getElementById('content-' + tabName).classList.remove('hidden');
        document.getElementById('content-' + tabName).classList.add('block');

        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove('text-gray-400', 'border-transparent');
        activeBtn.classList.add('text-primary', 'border-primary');

        // Show/hide sticky button based on tab
        const stickyBtn = document.getElementById('sticky-btn');
        stickyBtn.style.display = tabName === 'form' ? 'block' : 'none';
    }

    function shareInfaq() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $category->name }}',
                text: 'Mari berinfaq untuk program: {{ $category->name }}',
                url: window.location.href,
            }).catch(error => console.log('Error sharing', error));
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => alert('Link berhasil disalin!'));
        }
    }
</script>

<style>
    .pb-safe { padding-bottom: max(1rem, env(safe-area-inset-bottom)); }
</style>
@endsection
