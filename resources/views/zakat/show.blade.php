@extends('layouts.home_layout')

@section('title', $zakatType->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    body { background-color: #F8F9FA; }
    .container { max-width: 1140px; }
    
    .zakat-wrapper {
        padding: 3rem 0 5rem;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
        align-items: start;
    }

    .breadcrumb {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* Left Content */
    .zakat-image-container {
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .zakat-image {
        width: 100%;
        height: auto;
        aspect-ratio: 16/9;
        object-fit: cover;
    }
    
    .zakat-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .prose {
        color: #4a4a4a;
        line-height: 1.7;
    }

    /* Sticky Right Sidebar (Transaction Form) */
    .transaction-card {
        position: sticky;
        top: 6rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 2rem;
        border: 1px solid #f0f0f0;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        background-color: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .form-input:focus {
        background-color: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        outline: none;
    }

    .calculator-box {
        background: #f0fdf4;
        border: 1px dashed #10b981;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .btn-submit {
        display: block;
        width: 100%;
        text-align: center;
        padding: 1rem;
        background: var(--primary);
        color: white;
        font-weight: 700;
        border-radius: 50px;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 1rem;
    }
    .btn-submit:hover {
        background: #1c7494; /* Darker shade of primary */
        box-shadow: 0 4px 12px rgba(37, 150, 190, 0.3);
    }

    @media (max-width: 900px) {
        .zakat-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .transaction-card {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="zakat-wrapper">
        
        <!-- Left Content: Info -->
        <div>
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a> > <a href="{{ route('zakat.index') }}">Zakat</a> > {{ $zakatType->name }}
            </div>

            <div class="zakat-image-container">
                <img src="{{ Str::startsWith($zakatType->image, 'http') ? $zakatType->image : asset($zakatType->image) }}" 
                     alt="{{ $zakatType->name }}" 
                     class="zakat-image">
            </div>

            <h1 class="zakat-title">{{ $zakatType->name }}</h1>

            <div class="prose">
                <p class="text-lg text-gray-600 mb-6">{{ $zakatType->description }}</p>
                
                <h3 class="text-xl font-bold text-gray-800 mb-3">Tentang {{ $zakatType->name }}</h3>
                <p>
                    Zakat adalah kewajiban bagi setiap Muslim yang memenuhi syarat. 
                    Dengan menunaikan zakat, Anda membersihkan harta dan membantu mereka yang membutuhkan.
                    Pastikan niat Anda ikhlas karena Allah Ta'ala.
                </p>
            </div>
        </div>

        <!-- Right Content: Transaction Form -->
        <div class="transaction-card">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <i class="ti ti-calculator"></i>
                </div>
                Hitung & Bayar Zakat
            </h2>

            <!-- Mobile Sticky / Form Content -->
            <form action="{{ route('zakat.store', $zakatType->id) }}" method="POST" id="zakat-form">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-50 text-red-500 p-3 rounded-lg mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if($zakatType->category == 'mal')
                <!-- Simple Calculator for Zakat Mal -->
                <div class="calculator-box">
                    <label class="form-label text-teal">Kalkulator Zakat (2.5%)</label>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 mb-1 block">Total Aset / Penghasilan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" id="asset_amount" class="form-input pl-10" placeholder="0">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Payment Form -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nominal Zakat</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="amount" id="zakat_amount" class="form-input pl-12 font-bold text-lg text-primary" placeholder="Masukkan Nominal" value="{{ old('amount') }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Metode Pembayaran</label>
                        
                        <!-- Payment Type Selection -->
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                            @if(isset($setting) && $setting->is_payment_gateway_active)
                            <label style="flex: 1; text-align: center; padding: 1rem; border: 1px solid #ddd; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;" class="payment-type-option">
                                <input type="radio" name="payment_type" value="online" onchange="togglePaymentMethod('online')" checked style="display: none;">
                                <i class="ti ti-credit-card" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block; color: var(--primary);"></i>
                                <span style="font-weight: 600; display: block;">Otomatis</span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">QRIS, E-Wallet, VA</span>
                            </label>
                            @endif
                            
                            <label style="flex: 1; text-align: center; padding: 1rem; border: 1px solid #ddd; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;" class="payment-type-option">
                                <input type="radio" name="payment_type" value="manual" onchange="togglePaymentMethod('manual')" {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'checked' : '' }} style="display: none;">
                                <i class="ti ti-building-bank" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block; color: var(--primary);"></i>
                                <span style="font-weight: 600; display: block;">Transfer Manual</span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">Cek Manual Admin</span>
                            </label>
                        </div>

                        <!-- Manual Payment Options -->
                        <div id="manual-payment-options" style="display: {{ (!isset($setting) || !$setting->is_payment_gateway_active) ? 'grid' : 'none' }}; gap: 1rem;">
                            @foreach($paymentMethods as $method)
                            <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #ddd; border-radius: 0.5rem; cursor: pointer;" class="bank-option">
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}">
                                @if($method->logo_url)
                                    <img src="{{ $method->logo_url }}" style="height: 30px; object-fit: contain;">
                                @else
                                    <span style="font-weight: 600;">{{ $method->bank_name }}</span>
                                @endif
                                <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $method->account_number }} (a.n {{ $method->account_name }})</span>
                            </label>
                            @endforeach
                        </div>
                        
                        <!-- Online Payment Info -->
                        <div id="online-payment-info" style="display: {{ (isset($setting) && $setting->is_payment_gateway_active) ? 'block' : 'none' }}; text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 0.5rem;">
                            <i class="ti ti-shield-check" style="font-size: 2rem; color: #198754; margin-bottom: 0.5rem;"></i>
                            <p style="font-weight: 600; margin-bottom: 0.25rem;">Pembayaran Aman & Otomatis</p>
                            <p style="font-size: 0.9rem; color: var(--text-muted);">Anda akan diarahkan ke halaman pembayaran Midtrans.</p>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" placeholder="Nama Anda (Hamba Allah)" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="phone" class="form-input" placeholder="08123xxxx" value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" placeholder="email@example.com" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit">
                        <span id="btn-text">Tunaikan Zakat Sekarang</span>
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-4">
                        <i class="ti ti-lock"></i> Transaksi Anda aman & terpercaya
                    </p>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function togglePaymentMethod(type) {
        const manualOptions = document.getElementById('manual-payment-options');
        const onlineInfo = document.getElementById('online-payment-info');
        const bankInputs = document.querySelectorAll('input[name="payment_method_id"]');
        
        // Update UI
        document.querySelectorAll('.payment-type-option').forEach(el => {
            const input = el.querySelector('input');
            if(input.checked) {
                el.style.borderColor = 'var(--primary)';
                el.style.backgroundColor = '#f0f9ff';
            } else {
                el.style.borderColor = '#ddd';
                el.style.backgroundColor = 'white';
            }
        });

        if (type === 'manual') {
            manualOptions.style.display = 'grid';
            onlineInfo.style.display = 'none';
            // Enable required for bank inputs
            bankInputs.forEach(input => input.required = true);
        } else {
            manualOptions.style.display = 'none';
            onlineInfo.style.display = 'block';
            // Disable required and uncheck bank inputs
            bankInputs.forEach(input => {
                input.required = false;
                input.checked = false;
            });
        }
    }

    // Add CSS for active state
    const style = document.createElement('style');
    style.innerHTML = `
        .bank-option:has(input:checked) {
            border-color: var(--primary) !important;
            background-color: #f0f9ff !important;
        }
    `;
    document.head.appendChild(style);

    document.addEventListener('DOMContentLoaded', function() {
        // Payment Toggle Init
        const checkedInput = document.querySelector('input[name="payment_type"]:checked');
        if(checkedInput) {
            togglePaymentMethod(checkedInput.value);
        }

        // Calculator
        const assetInput = document.getElementById('asset_amount');
        const zakatInput = document.getElementById('zakat_amount');
        if(assetInput && zakatInput) {
            assetInput.addEventListener('input', function() {
                const assets = parseFloat(assetInput.value) || 0;
                // Calculate 2.5%
                const zakat = Math.round(assets * 0.025);
                zakatInput.value = zakat;
            });
        }

        // Form Submission Loading State
        const form = document.getElementById('zakat-form');
        const btn = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');

        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.style.opacity = '0.7';
                btn.style.cursor = 'not-allowed';
                btnText.innerHTML = `<i class="ti ti-loader-2 animate-spin mr-2"></i> Memproses...`;
                
                // Show full-page overlay
                const overlay = document.getElementById('loading-overlay');
                if (overlay) overlay.style.display = 'flex';
            });
        }
    });

    // Add animation style if not exists
    if (!document.getElementById('animate-spin-style')) {
        const style = document.createElement('style');
        style.id = 'animate-spin-style';
        style.innerHTML = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .animate-spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
            .mr-2 { margin-right: 0.5rem; }
        `;
        document.head.appendChild(style);
    }
</script>
@endsection
