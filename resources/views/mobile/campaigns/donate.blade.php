@extends('layouts.frontend')

@section('title', 'Donasi Sekarang')
@section('hide_bottom_nav', true)

@push('styles')
<style>
    .donate-app {
        background: #f0f4f8;
        min-height: 100vh;
        padding-bottom: 6rem;
        max-width: 100vw;
        overflow-x: hidden;
    }

    /* --- Header --- */
    .donate-header {
        background: white;
        padding: 0.875rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        position: sticky;
        top: 0;
        z-index: 40;
        border-bottom: 1px solid #f3f4f6;
    }

    .donate-header .back-btn {
        width: 36px;
        height: 36px;
        border-radius: 0.75rem;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #374151;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .donate-header .back-btn:active {
        transform: scale(0.9);
        background: #e5e7eb;
    }

    .donate-header h1 {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    /* --- Section Card --- */
    .section-card {
        background: white;
        border-radius: 1.25rem;
        padding: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #2596be;
        font-size: 1.1rem;
    }

    /* --- Campaign Info --- */
    .campaign-info {
        display: flex;
        gap: 0.875rem;
        align-items: center;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd;
        border-radius: 1rem;
        padding: 0.875rem;
    }

    .campaign-info img {
        width: 52px;
        height: 52px;
        border-radius: 0.75rem;
        object-fit: cover;
        flex-shrink: 0;
    }

    .campaign-info .info-label {
        font-size: 0.6rem;
        font-weight: 600;
        color: #2596be;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.15rem;
    }

    .campaign-info .info-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1e3a5f;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* --- Amount Input --- */
    .amount-input-wrap {
        position: relative;
        margin-bottom: 1rem;
    }

    .amount-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.9rem;
        font-weight: 700;
        color: #9ca3af;
    }

    .amount-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        background: #fafbfc;
        outline: none;
        transition: all 0.2s;
    }

    .amount-input:focus {
        border-color: #2596be;
        background: white;
        box-shadow: 0 0 0 3px rgba(37, 150, 190, 0.1);
    }

    .amount-input::placeholder {
        color: #d1d5db;
        font-weight: 600;
    }

    /* --- Amount Chips --- */
    .amount-chips {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
    }

    .amount-chip {
        padding: 0.625rem 0;
        border-radius: 0.75rem;
        border: 1.5px solid #e5e7eb;
        background: white;
        font-size: 0.7rem;
        font-weight: 700;
        color: #4b5563;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .amount-chip:active,
    .amount-chip.active {
        border-color: #2596be;
        background: rgba(37, 150, 190, 0.05);
        color: #2596be;
        transform: scale(0.96);
    }

    /* --- Payment Type --- */
    .payment-types {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .payment-type-card {
        position: relative;
        cursor: pointer;
    }

    .payment-type-card input {
        position: absolute;
        opacity: 0;
    }

    .payment-type-inner {
        padding: 1rem 0.75rem;
        border-radius: 1rem;
        border: 2px solid #e5e7eb;
        text-align: center;
        transition: all 0.25s;
    }

    .payment-type-card input:checked ~ .payment-type-inner {
        border-color: #2596be;
        background: linear-gradient(135deg, rgba(37,150,190,0.05), rgba(37,150,190,0.1));
    }

    .payment-type-inner i {
        font-size: 1.75rem;
        color: #9ca3af;
        display: block;
        margin-bottom: 0.4rem;
        transition: color 0.2s;
    }

    .payment-type-card input:checked ~ .payment-type-inner i {
        color: #2596be;
    }

    .payment-type-inner .type-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #4b5563;
        display: block;
    }

    .payment-type-card input:checked ~ .payment-type-inner .type-label {
        color: #2596be;
    }

    .payment-type-inner .type-desc {
        font-size: 0.6rem;
        color: #9ca3af;
        margin-top: 0.15rem;
        display: block;
    }

    /* --- Online Info --- */
    .online-info {
        text-align: center;
        padding: 1.25rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
        border-radius: 1rem;
    }

    .online-info i {
        font-size: 1.75rem;
        color: #22c55e;
        margin-bottom: 0.4rem;
    }

    .online-info .info-main {
        font-size: 0.8rem;
        font-weight: 700;
        color: #166534;
    }

    .online-info .info-sub {
        font-size: 0.65rem;
        color: #4ade80;
        margin-top: 0.25rem;
    }

    /* --- Bank Option --- */
    .bank-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .bank-option:has(input:checked) {
        border-color: #2596be;
        background: rgba(37, 150, 190, 0.03);
    }

    .bank-option input[type="radio"] {
        accent-color: #2596be;
        flex-shrink: 0;
    }

    .bank-option .bank-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1f2937;
    }

    .bank-option .bank-detail {
        font-size: 0.65rem;
        color: #9ca3af;
    }

    /* --- Form Input --- */
    .form-group {
        margin-bottom: 0.875rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 0.375rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.875rem;
        font-size: 0.85rem;
        color: #1f2937;
        background: #fafbfc;
        outline: none;
        transition: all 0.2s;
    }

    .form-input:focus {
        border-color: #2596be;
        background: white;
        box-shadow: 0 0 0 3px rgba(37, 150, 190, 0.1);
    }

    /* --- Checkbox --- */
    .checkbox-wrap {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 0.875rem;
        margin-top: 0.5rem;
    }

    .checkbox-wrap input {
        accent-color: #2596be;
        width: 1rem;
        height: 1rem;
        flex-shrink: 0;
    }

    .checkbox-wrap label {
        font-size: 0.8rem;
        color: #4b5563;
        font-weight: 500;
    }

    /* --- Sticky CTA --- */
    .donate-cta {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 0.875rem 1.25rem;
        padding-bottom: max(0.875rem, env(safe-area-inset-bottom));
        border-top: 1px solid #f3f4f6;
        z-index: 50;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
    }

    .donate-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #2596be, #1a7a9e);
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.95rem;
        border-radius: 0.875rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(37, 150, 190, 0.35);
        transition: all 0.2s;
    }

    .donate-btn:active {
        transform: scale(0.97);
    }
</style>
@endpush

@section('content')
<div class="donate-app">

    <!-- ===== Header ===== -->
    <div class="donate-header">
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="ti ti-arrow-left"></i>
        </a>
        <h1>Donasi Sekarang</h1>
    </div>

    <form action="{{ route('campaign.store', $campaign->slug) }}" method="POST" id="donation-form">
        @csrf

        <div style="padding: 1rem 1.25rem; display:flex; flex-direction:column; gap:1rem;">

            <!-- Campaign Info -->
            <div class="campaign-info">
                <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                     alt="{{ $campaign->title }}">
                <div style="flex:1; min-width:0;">
                    <div class="info-label">Donasi untuk Program</div>
                    <div class="info-title">{{ $campaign->title }}</div>
                </div>
            </div>

            <!-- Nominal -->
            <div class="section-card">
                <div class="section-title">
                    <i class="ti ti-coins"></i> Nominal Donasi
                </div>
                <div class="amount-input-wrap">
                    <span class="amount-prefix">Rp</span>
                    <input type="number" name="amount" id="amount" class="amount-input" placeholder="Min. 10.000" min="10000" required>
                </div>
                <div class="amount-chips">
                    <button type="button" onclick="setAmount(50000)" class="amount-chip">50rb</button>
                    <button type="button" onclick="setAmount(100000)" class="amount-chip">100rb</button>
                    <button type="button" onclick="setAmount(200000)" class="amount-chip">200rb</button>
                    <button type="button" onclick="setAmount(500000)" class="amount-chip">500rb</button>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="section-card">
                <div class="section-title">
                    <i class="ti ti-credit-card"></i> Metode Pembayaran
                </div>

                <div class="payment-types">
                    @if(isset($setting) && $setting->is_payment_gateway_active)
                    <label class="payment-type-card">
                        <input type="radio" name="payment_type" value="online" onchange="togglePaymentMethod('online')" checked>
                        <div class="payment-type-inner">
                            <i class="ti ti-credit-card"></i>
                            <span class="type-label">Otomatis</span>
                            <span class="type-desc">QRIS, E-Wallet, VA</span>
                        </div>
                    </label>
                    @endif

                    <label class="payment-type-card">
                        <input type="radio" name="payment_type" value="manual" onchange="togglePaymentMethod('manual')" {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'checked' : '' }}>
                        <div class="payment-type-inner">
                            <i class="ti ti-building-bank"></i>
                            <span class="type-label">Transfer Manual</span>
                            <span class="type-desc">Cek Admin</span>
                        </div>
                    </label>
                </div>

                <!-- Online Info -->
                <div id="online-payment-info" class="online-info" style="display: {{ (isset($setting) && $setting->is_payment_gateway_active) ? 'block' : 'none' }};">
                    <i class="ti ti-shield-check"></i>
                    <div class="info-main">Pembayaran Aman & Otomatis</div>
                    <div class="info-sub">QRIS, E-Wallet, Virtual Account — Verifikasi Otomatis</div>
                </div>

                <!-- Manual Options -->
                <div id="manual-payment-options" style="display: {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'flex' : 'none' }}; flex-direction:column; gap:0.625rem;">
                    @foreach($paymentMethods as $method)
                    <label class="bank-option">
                        <input type="radio" name="payment_method_id" value="{{ $method->id }}">
                        <div style="flex:1; min-width:0;">
                            @if($method->logo_url)
                                <img src="{{ $method->logo_url }}" alt="{{ $method->bank_name }}" style="height:22px; object-fit:contain; margin-bottom:2px;">
                            @else
                                <div class="bank-name">{{ $method->bank_name }}</div>
                            @endif
                            <div class="bank-detail">{{ $method->account_number }} a.n {{ $method->account_name }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Data Diri -->
            <div class="section-card">
                <div class="section-title">
                    <i class="ti ti-user"></i> Data Diri
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp (Opsional)</label>
                    <input type="text" name="phone" class="form-input" value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                </div>
                <div class="checkbox-wrap">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous">
                    <label for="is_anonymous">Sembunyikan nama saya (Hamba Allah)</label>
                </div>
            </div>

            <!-- Doa -->
            <div class="section-card">
                <div class="section-title">
                    <i class="ti ti-message-heart"></i> Doa & Dukungan <span style="font-size:0.65rem; color:#9ca3af; font-weight:500;">(Opsional)</span>
                </div>
                <textarea name="message" rows="3" class="form-input" style="resize:none;" placeholder="Tuliskan doa atau dukungan untuk program ini..."></textarea>
            </div>

        </div>

        <!-- Sticky CTA -->
        <div class="donate-cta">
            <button type="submit" class="donate-btn">
                <i class="ti ti-heart-handshake"></i>
                Lanjut Pembayaran
            </button>
        </div>
    </form>
</div>

<script>
    function setAmount(value) {
        document.getElementById('amount').value = value;
        // Highlight active chip
        document.querySelectorAll('.amount-chip').forEach(chip => chip.classList.remove('active'));
        event.target.classList.add('active');
    }

    function togglePaymentMethod(type) {
        const manualOptions = document.getElementById('manual-payment-options');
        const onlineInfo = document.getElementById('online-payment-info');
        const bankInputs = document.querySelectorAll('input[name="payment_method_id"]');

        if (type === 'manual') {
            manualOptions.style.display = 'flex';
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
@endsection
