@extends('layouts.frontend')

@section('title', 'Instruksi Pembayaran')
@section('hide_bottom_nav', true)

@push('styles')
<style>
    .success-app {
        background: #f0f4f8;
        min-height: 100vh;
        padding-bottom: 2rem;
        max-width: 100vw;
        overflow-x: hidden;
    }

    /* --- Header --- */
    .success-header {
        background: white;
        padding: 0.875rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 40;
        border-bottom: 1px solid #f3f4f6;
    }

    .success-header .close-btn {
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
    }

    .success-header .close-btn:active {
        transform: scale(0.9);
    }

    .success-header h1 {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    /* --- Success Icon --- */
    .success-icon-wrap {
        text-align: center;
        padding: 2rem 1.25rem 1rem;
    }

    .success-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        position: relative;
    }

    .success-circle.green {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #059669;
    }

    .success-circle i {
        font-size: 2rem;
    }

    .success-circle::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 2px dashed #a7f3d0;
        animation: spin 15s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .success-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .success-subtitle {
        font-size: 0.8rem;
        color: #9ca3af;
        font-weight: 500;
    }

    /* --- Section Card --- */
    .section-card {
        background: white;
        border-radius: 1.25rem;
        padding: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .section-label i {
        color: #2596be;
        font-size: 1rem;
    }

    /* --- Transfer Warning --- */
    .transfer-warning {
        background: linear-gradient(135deg, #fff7ed, #fed7aa);
        border: 1px solid #fdba74;
        border-radius: 0.75rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.65rem;
        font-weight: 700;
        color: #c2410c;
        text-align: center;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    /* --- Amount Row --- */
    .amount-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 0.85rem;
    }

    .amount-row .label {
        color: #6b7280;
        font-weight: 500;
    }

    .amount-row .value {
        font-weight: 700;
        color: #1f2937;
    }

    .amount-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 0 0.5rem;
        border-top: 1.5px dashed #e5e7eb;
        margin-top: 0.5rem;
    }

    .amount-total .label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #2596be;
    }

    .total-value-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .amount-total .value {
        font-size: 1.2rem;
        font-weight: 800;
        color: #2596be;
    }

    .copy-btn {
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        background: rgba(37, 150, 190, 0.1);
        border: none;
        color: #2596be;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .copy-btn:active {
        transform: scale(0.9);
        background: rgba(37, 150, 190, 0.2);
    }

    /* --- Invoice Badge --- */
    .invoice-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 700;
        color: #0284c7;
        margin-top: 0.875rem;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    /* --- Bank Card --- */
    .bank-card {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 1rem;
        border: 1px solid #f3f4f6;
    }

    .bank-logo-wrap {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .bank-logo-wrap img {
        height: 24px;
        object-fit: contain;
    }

    .bank-logo-wrap .bank-abbr {
        font-size: 0.7rem;
        font-weight: 800;
        color: #6b7280;
    }

    .bank-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.1rem;
    }

    .bank-number-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.15rem;
    }

    .bank-number {
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 1rem;
        font-weight: 700;
        color: #374151;
        letter-spacing: 0.075em;
    }

    .copy-text-btn {
        font-size: 0.6rem;
        font-weight: 800;
        color: #2596be;
        background: rgba(37, 150, 190, 0.1);
        border: none;
        padding: 0.2rem 0.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .copy-text-btn:active {
        background: rgba(37, 150, 190, 0.2);
    }

    .bank-holder {
        font-size: 0.7rem;
        color: #9ca3af;
        font-weight: 500;
    }

    /* --- Online Payment --- */
    .online-card {
        text-align: center;
        padding: 1.5rem 1rem;
    }

    .online-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.5rem;
    }

    .online-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .online-desc {
        font-size: 0.7rem;
        color: #9ca3af;
        margin-bottom: 1.25rem;
    }

    .pay-btn {
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

    .pay-btn:active {
        transform: scale(0.97);
    }

    /* --- Upload Area --- */
    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 1rem;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #fafbfc;
    }

    .upload-area:active {
        border-color: #2596be;
        background: rgba(37, 150, 190, 0.03);
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: #9ca3af;
        font-size: 1.5rem;
    }

    .upload-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.25rem;
    }

    .upload-hint {
        font-size: 0.65rem;
        color: #9ca3af;
    }

    .submit-btn {
        width: 100%;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #2596be, #1a7a9e);
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.875rem;
        border-radius: 0.875rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(37, 150, 190, 0.35);
        transition: all 0.2s;
    }

    .submit-btn:active {
        transform: scale(0.97);
    }

    /* --- Status Card --- */
    .status-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 1.25rem;
    }

    .status-card.success {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
    }

    .status-card.pending {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd;
    }

    .status-card i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .status-card.success i { color: #22c55e; }
    .status-card.pending i { color: #0ea5e9; }

    .status-card .status-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .status-card .status-desc {
        font-size: 0.7rem;
        color: #6b7280;
    }

    .home-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem;
        border-radius: 0.875rem;
        border: 1.5px solid #e5e7eb;
        background: white;
        color: #374151;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .home-btn:active {
        background: #f3f4f6;
    }

    /* --- Toast --- */
    .toast {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #1f2937;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 100;
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    .toast.show {
        transform: translateX(-50%) translateY(0);
    }
</style>
@endpush

@section('content')
<div class="success-app">

    <!-- ===== Header ===== -->
    <div class="success-header">
        <a href="{{ route('home') }}" class="close-btn">
            <i class="ti ti-x"></i>
        </a>
        <h1>Pembayaran</h1>
        <div style="width:36px;"></div>
    </div>

    <!-- ===== Success Icon ===== -->
    <div class="success-icon-wrap">
        <div class="success-circle green">
            <i class="ti ti-check"></i>
        </div>
        <h2 class="success-title">Terima Kasih!</h2>
        <p class="success-subtitle">Mohon selesaikan pembayaran donasi Anda</p>
    </div>

    <div style="padding: 0 1.25rem; display:flex; flex-direction:column; gap:1rem;">

        <!-- ===== Amount Card ===== -->
        <div class="section-card">
            @if(!$donation->snap_token)
            <div class="transfer-warning">
                <i class="ti ti-alert-triangle"></i>
                TRANSFER TEPAT SAMPAI 3 DIGIT TERAKHIR
            </div>
            @endif

            <div class="amount-row">
                <span class="label">Nominal Donasi</span>
                <span class="value">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
            @if($donation->admin_fee > 0)
            <div class="amount-row">
                <span class="label">Biaya Admin</span>
                <span class="value">Rp {{ number_format($donation->admin_fee, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="amount-total">
                <span class="label">Total Bayar</span>
                <div class="total-value-wrap">
                    <span class="value">Rp {{ number_format($donation->total_transfer, 0, ',', '.') }}</span>
                    <button onclick="copyAmount('{{ (int)$donation->total_transfer }}')" class="copy-btn">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>
            </div>

            <div class="invoice-badge">
                <i class="ti ti-receipt"></i>
                {{ $donation->invoice_number }}
            </div>
        </div>

        @if($donation->snap_token)
            <!-- ===== Online Payment ===== -->
            <div class="section-card">
                <div class="online-card">
                    <div class="online-icon">
                        <i class="ti ti-credit-card"></i>
                    </div>
                    <div class="online-title">Pembayaran Otomatis</div>
                    <div class="online-desc">Selesaikan melalui QRIS, E-Wallet, atau Virtual Account</div>
                    <button id="pay-button" class="pay-btn">
                        <i class="ti ti-lock"></i>
                        Bayar Sekarang
                    </button>
                </div>
            </div>

            <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
            <script type="text/javascript">
              document.getElementById('pay-button').onclick = function(){
                snap.pay('{{ $donation->snap_token }}', {
                  onSuccess: function(result){ window.location.reload(); },
                  onPending: function(result){ window.location.reload(); },
                  onError: function(result){ alert("Pembayaran gagal!"); window.location.reload(); },
                  onClose: function(){}
                });
              };
            </script>
        @else
            <!-- ===== Bank Transfer Details ===== -->
            <div class="section-card">
                <div class="section-label">
                    <i class="ti ti-building-bank"></i>
                    Transfer ke Rekening
                </div>
                <div class="bank-card">
                    <div class="bank-logo-wrap">
                        @if($donation->paymentMethod->logo_url)
                            <img src="{{ asset($donation->paymentMethod->logo_url) }}" alt="{{ $donation->paymentMethod->bank_name }}">
                        @else
                            <span class="bank-abbr">{{ substr($donation->paymentMethod->bank_name, 0, 4) }}</span>
                        @endif
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div class="bank-name">{{ $donation->paymentMethod->bank_name }}</div>
                        <div class="bank-number-wrap">
                            <span class="bank-number">{{ $donation->paymentMethod->account_number }}</span>
                            <button onclick="copyAmount('{{ $donation->paymentMethod->account_number }}')" class="copy-text-btn">SALIN</button>
                        </div>
                        <div class="bank-holder">a.n {{ $donation->paymentMethod->account_name }}</div>
                    </div>
                </div>
            </div>

            <!-- ===== Upload / Status ===== -->
            @if(session('success'))
                <div class="status-card success">
                    <i class="ti ti-circle-check"></i>
                    <div class="status-title">Upload Berhasil!</div>
                    <div class="status-desc">{{ session('success') }}</div>
                </div>
                <a href="{{ route('home') }}" class="home-btn">
                    <i class="ti ti-home"></i>
                    Kembali ke Beranda
                </a>
            @elseif($donation->payment_proof)
                <div class="status-card pending">
                    <i class="ti ti-clock"></i>
                    <div class="status-title">Sedang Diverifikasi</div>
                    <div class="status-desc">Bukti pembayaran sedang dicek oleh admin</div>
                </div>
                <a href="{{ route('home') }}" class="home-btn">
                    <i class="ti ti-home"></i>
                    Kembali ke Beranda
                </a>
            @else
                <div class="section-card">
                    <div class="section-label">
                        <i class="ti ti-photo-up"></i>
                        Konfirmasi Pembayaran
                    </div>
                    <form action="{{ route('campaign.confirm', ['invoice' => $donation->invoice_number]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-area" onclick="document.getElementById('file-input').click()">
                            <input type="file" id="file-input" name="payment_proof" accept="image/*" required class="hidden" onchange="showPreview(this)">

                            <div id="upload-placeholder">
                                <div class="upload-icon">
                                    <i class="ti ti-cloud-upload"></i>
                                </div>
                                <div class="upload-title">Upload Bukti Transfer</div>
                                <div class="upload-hint">Tap di sini untuk memilih gambar</div>
                            </div>

                            <div id="file-preview" class="hidden">
                                <img id="preview-img" src="" style="max-height:160px; border-radius:0.75rem; margin:0 auto; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <p id="file-name" style="font-size:0.7rem; color:#2596be; margin-top:0.5rem; font-weight:600;"></p>
                                <p style="font-size:0.6rem; color:#9ca3af; margin-top:0.25rem;">Tap untuk mengganti</p>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="ti ti-send"></i>
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>

<!-- Toast Notification -->
<div id="copy-toast" class="toast">
    <i class="ti ti-check"></i>
    <span>Berhasil disalin!</span>
</div>

<script>
    function copyAmount(text) {
        navigator.clipboard.writeText(text).then(() => {
            const toast = document.getElementById('copy-toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        });
    }

    function showPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('file-preview').classList.remove('hidden');
                document.getElementById('file-name').textContent = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
