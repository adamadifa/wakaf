@extends('layouts.frontend')

@section('title', 'Donasi - ' . $campaign->title)

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
    <div class="text-center mb-2">
        <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem;">Masukan Nominal Donasi</h1>
        <p style="color: var(--text-muted);">Program: <strong>{{ $campaign->title }}</strong></p>
    </div>

    <div class="card" style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow);">
        <form action="{{ route('campaign.store', $campaign->slug) }}" method="POST" id="donation-form">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nominal Donasi (Rp)</label>
                <input type="number" name="amount" class="form-control" placeholder="Min. 10.000" min="10000" required
                    style="width: 100%; padding: 1rem; font-size: 1.25rem; border: 2px solid #eee; border-radius: 0.5rem; font-weight: 700;">
                
                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <button type="button" onclick="setAmount(50000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 50.000</button>
                    <button type="button" onclick="setAmount(100000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 100.000</button>
                    <button type="button" onclick="setAmount(500000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 500.000</button>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Metode Pembayaran</h3>
                
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
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Anda akan diarahkan ke halaman pembayaran Midtrans. Status donasi akan otomatis terupdate setelah pembayaran berhasil.</p>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Data Diri</h3>
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required value="{{ Auth::check() ? Auth::user()->name : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ Auth::check() ? Auth::user()->email : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Nomor WhatsApp (Opsional)</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_anonymous">
                        <span>Sembunyikan nama saya (Hamba Allah)</span>
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.25rem;">Doa & Dukungan (Opsional)</label>
                <textarea name="message" rows="3" 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" id="btn-submit" style="width: 100%; padding: 1rem; font-size: 1.1rem;">
                <span id="btn-text">Lanjut Pembayaran</span>
            </button>
        </form>
    </div>
</div>

<script>
    function setAmount(value) {
        document.querySelector('input[name="amount"]').value = value;
    }

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

    // Initialize styling
    document.addEventListener('DOMContentLoaded', function() {
        const checkedInput = document.querySelector('input[name="payment_type"]:checked');
        if(checkedInput) {
            togglePaymentMethod(checkedInput.value);
        }

        // Form Submission Loading State
        const form = document.getElementById('donation-form');
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

    // Add CSS for active state
    const style = document.createElement('style');
    style.innerHTML = `
        .bank-option:has(input:checked) {
            border-color: var(--primary) !important;
            background-color: #f0f9ff !important;
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
