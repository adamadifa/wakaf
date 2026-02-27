@extends('layouts.home_layout')

@section('title', $category->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    body { background-color: #F8F9FA; }
    .container { max-width: 1140px; }
    
    .infaq-wrapper {
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
    .infaq-image-container {
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .infaq-image {
        width: 100%;
        height: auto;
        aspect-ratio: 16/9;
        object-fit: cover;
    }
    
    .infaq-title {
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
        background: #1c7494;
        box-shadow: 0 4px 12px rgba(37, 150, 190, 0.3);
    }

    @media (max-width: 900px) {
        .infaq-wrapper {
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
    <div class="infaq-wrapper">
        
        <!-- Left Content: Info -->
        <div>
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a> > <a href="{{ route('infaq.index') }}">Infaq</a> > {{ $category->name }}
            </div>

            @if($category->image)
            <div class="infaq-image-container">
                <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : asset($category->image) }}" 
                     alt="{{ $category->name }}" 
                     class="infaq-image">
            </div>
            @endif

            <h1 class="infaq-title">{{ $category->name }}</h1>

            <div class="prose">
                <div class="text-lg text-gray-600 mb-6">{!! $category->description !!}</div>

                <!-- Stats Banner -->
                <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                    <div style="flex: 1; background: linear-gradient(135deg, #0E2C4C, #0F5B73); color: white; padding: 1.25rem; border-radius: 0.75rem; text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800;">Rp {{ number_format($totalCollected, 0, ',', '.') }}</div>
                        <div style="font-size: 0.8rem; opacity: 0.8; margin-top: 0.25rem;">Terkumpul</div>
                    </div>
                    <div style="flex: 0 0 100px; background: #f0fdf4; padding: 1.25rem; border-radius: 0.75rem; text-align: center; border: 1px solid #dcfce7;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ $donorCount }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Donatur</div>
                    </div>
                </div>

                <!-- Recent Donors -->
                @if($recentDonors->count() > 0)
                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; margin-bottom: 2rem;">
                    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="ti ti-users" style="color: var(--primary);"></i>
                        <h4 style="font-weight: 700; font-size: 0.95rem; margin: 0;">Donatur Terbaru</h4>
                    </div>
                    <div style="max-height: 320px; overflow-y: auto;">
                        @foreach($recentDonors as $donor)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1.25rem; border-bottom: 1px solid #f8f8f8; {{ $loop->last ? 'border-bottom: none;' : '' }}">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); display: flex; align-items: center; justify-content: center; color: #4caf50; font-weight: 700; font-size: 0.85rem;">
                                    {{ strtoupper(substr($donor->is_anonymous ? 'H' : $donor->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.9rem; color: #1a1a1a;">{{ $donor->is_anonymous ? 'Hamba Allah' : $donor->name }}</div>
                                    @if($donor->message)
                                        <div style="font-size: 0.75rem; color: #6b7280; font-style: italic;">"{{ Str::limit($donor->message, 50) }}"</div>
                                    @else
                                        <div style="font-size: 0.75rem; color: #9ca3af;">{{ $donor->confirmed_at ? $donor->confirmed_at->diffForHumans() : $donor->created_at->diffForHumans() }}</div>
                                    @endif
                                </div>
                            </div>
                            <div style="font-weight: 700; font-size: 0.9rem; color: var(--primary);">
                                Rp {{ number_format($donor->amount, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Content: Transaction Form -->
        <div class="transaction-card">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <i class="ti ti-heart-handshake"></i>
                </div>
                Salurkan Infaq
            </h2>

            <form action="{{ route('infaq.store', $category->id) }}" method="POST" id="infaq-form">
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

                <!-- Payment Form -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nominal Infaq</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="amount" class="form-input pl-12 font-bold text-lg text-primary" placeholder="Masukkan Nominal" value="{{ old('amount') }}" required>
                        </div>
                    </div>

                    <!-- Quick Amount Buttons -->
                    <div class="grid grid-cols-3 gap-2" id="quick-amounts">
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(50000)">50rb</button>
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(100000)">100rb</button>
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(200000)">200rb</button>
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(500000)">500rb</button>
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(1000000)">1jt</button>
                        <button type="button" class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all" onclick="setAmount(2000000)">2jt</button>
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

                    <div>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_anonymous" value="1" style="accent-color: var(--primary);">
                            <span class="text-sm text-gray-600">Sembunyikan nama saya (Hamba Allah)</span>
                        </label>
                    </div>

                    <div>
                        <label class="form-label">Doa & Dukungan (Opsional)</label>
                        <textarea name="message" rows="3" class="form-input" placeholder="Tulis doa atau dukungan Anda...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit">
                        <span id="btn-text">Salurkan Infaq Sekarang</span>
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
    function setAmount(value) {
        document.querySelector('input[name="amount"]').value = value;
        // Highlight active button
        document.querySelectorAll('#quick-amounts button').forEach(btn => {
            btn.style.borderColor = '#e5e7eb';
            btn.style.backgroundColor = 'white';
        });
        event.target.style.borderColor = 'var(--primary)';
        event.target.style.backgroundColor = '#f0fdf4';
    }

    function togglePaymentMethod(type) {
        const manualOptions = document.getElementById('manual-payment-options');
        const onlineInfo = document.getElementById('online-payment-info');
        const bankInputs = document.querySelectorAll('input[name="payment_method_id"]');
        
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

    const style = document.createElement('style');
    style.innerHTML = `
        .bank-option:has(input:checked) {
            border-color: var(--primary) !important;
            background-color: #f0f9ff !important;
        }
    `;
    document.head.appendChild(style);

    document.addEventListener('DOMContentLoaded', function() {
        const checkedInput = document.querySelector('input[name="payment_type"]:checked');
        if(checkedInput) {
            togglePaymentMethod(checkedInput.value);
        }

        // Form Submission Loading State
        const form = document.getElementById('infaq-form');
        const btn = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'not-allowed';
            btnText.innerHTML = `<i class="ti ti-loader-2 animate-spin mr-2"></i> Memproses...`;
            
            // Show full-page overlay
            const overlay = document.getElementById('loading-overlay');
            if (overlay) overlay.style.display = 'flex';
        });
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
