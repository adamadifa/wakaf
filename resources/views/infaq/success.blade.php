@extends('layouts.home_layout')

@section('title', 'Instruksi Pembayaran Infaq')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    body { background: #f0f4f8; }

    .success-container {
        max-width: 620px;
        margin: 0 auto;
        padding: 3rem 1rem 4rem;
    }

    /* Header Card */
    .success-header {
        background: linear-gradient(135deg, #0E2C4C, #0F5B73);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .success-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .success-header::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -20%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }
    .success-icon {
        width: 72px;
        height: 72px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        backdrop-filter: blur(10px);
        animation: bounceIn 0.6s ease;
    }
    .success-icon i {
        font-size: 2rem;
        color: #4ade80;
    }
    .success-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .success-header p {
        opacity: 0.8;
        font-size: 0.95rem;
    }
    .invoice-badge {
        display: inline-block;
        margin-top: 1rem;
        background: rgba(255,255,255,0.12);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    /* Info Card */
    .info-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .info-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a1a1a;
    }
    .info-card-header i {
        color: var(--primary);
        font-size: 1.2rem;
    }
    .info-card-body {
        padding: 1.5rem;
    }

    /* Detail Rows */
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
    }
    .detail-row:not(:last-child) {
        border-bottom: 1px dashed #f0f0f0;
    }
    .detail-label {
        color: #6b7280;
        font-size: 0.9rem;
    }
    .detail-value {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 0.95rem;
    }
    .detail-total {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        margin: 0.75rem -1.5rem -1.5rem;
        padding: 1.25rem 1.5rem;
        border-radius: 0 0 1rem 1rem;
    }
    .detail-total .detail-label {
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a1a;
    }
    .detail-total .detail-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
    }
    .unique-warning {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding: 0.6rem 1rem;
        background: #fef2f2;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        color: #dc2626;
        font-weight: 600;
    }

    /* Bank Card */
    .bank-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .bank-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--teal));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .bank-name {
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a1a;
        margin-bottom: 0.15rem;
    }
    .bank-number {
        font-size: 1.15rem;
        font-family: monospace;
        letter-spacing: 1.5px;
        color: var(--primary);
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .bank-number:hover { opacity: 0.8; }
    .bank-account-name {
        font-size: 0.8rem;
        color: #9ca3af;
    }
    .copy-toast {
        display: none;
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: #1a1a1a;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        z-index: 1000;
        animation: fadeUp 0.3s ease;
    }

    /* Pay Button */
    .pay-btn {
        display: block;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #0066cc, #0052a3);
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(0, 102, 204, 0.3);
    }
    .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(0, 102, 204, 0.4);
    }

    /* Status Cards */
    .status-success {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .status-success .status-icon {
        width: 56px;
        height: 56px;
        background: #22c55e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }
    .status-pending {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1px solid #fde68a;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .status-pending .status-icon {
        width: 56px;
        height: 56px;
        background: #f59e0b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
        animation: pulse 2s infinite;
    }

    /* Upload Section */
    .upload-section {
        border-top: 1px dashed #e5e7eb;
        padding-top: 1.5rem;
    }
    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fafafa;
    }
    .upload-area:hover {
        border-color: var(--primary);
        background: #f0f9ff;
    }
    .upload-icon {
        width: 56px;
        height: 56px;
        background: #f0f9ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--primary);
        font-size: 1.5rem;
    }
    .upload-btn {
        display: block;
        width: 100%;
        padding: 0.85rem;
        background: var(--primary);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 0.95rem;
        margin-top: 1rem;
        transition: all 0.2s;
    }
    .upload-btn:hover {
        background: #1c7494;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Home Button */
    .home-btn {
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.85rem;
        border: 2px solid #e5e7eb;
        color: #374151;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .home-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #f0f9ff;
    }

    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 2rem;
    }
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    .step-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }
    .step-dot.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 150, 190, 0.3);
    }
    .step-dot.done {
        background: #22c55e;
        color: white;
    }
    .step-dot.pending {
        background: #e5e7eb;
        color: #9ca3af;
    }
    .step-label {
        font-size: 0.7rem;
        color: #9ca3af;
        text-align: center;
        max-width: 70px;
    }
    .step-label.active { color: var(--primary); font-weight: 600; }
    .step-label.done { color: #22c55e; }
    .step-line {
        width: 60px;
        height: 2px;
        background: #e5e7eb;
        margin-bottom: 1.5rem;
    }
    .step-line.done { background: #22c55e; }

    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translate(-50%, 10px); }
        to { opacity: 1; transform: translate(-50%, 0); }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @media (max-width: 640px) {
        .success-container { padding: 1.5rem 1rem 3rem; }
        .success-header { padding: 2rem 1.5rem; }
        .success-header h1 { font-size: 1.25rem; }
        .step-line { width: 30px; }
    }
</style>
@endpush

@section('content')
<div class="success-container">

    <!-- Stepper -->
    <div class="stepper">
        <div class="step">
            <div class="step-dot done"><i class="ti ti-check" style="font-size: 1rem;"></i></div>
            <span class="step-label done">Isi Form</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-dot {{ $transaction->payment_proof || session('success') ? 'done' : 'active' }}">
                @if($transaction->payment_proof || session('success'))
                    <i class="ti ti-check" style="font-size: 1rem;"></i>
                @else
                    2
                @endif
            </div>
            <span class="step-label {{ $transaction->payment_proof || session('success') ? 'done' : 'active' }}">Pembayaran</span>
        </div>
        <div class="step-line {{ $transaction->status === 'confirmed' ? 'done' : '' }}"></div>
        <div class="step">
            <div class="step-dot {{ $transaction->status === 'confirmed' ? 'done' : 'pending' }}">
                @if($transaction->status === 'confirmed')
                    <i class="ti ti-check" style="font-size: 1rem;"></i>
                @else
                    3
                @endif
            </div>
            <span class="step-label {{ $transaction->status === 'confirmed' ? 'done' : '' }}">Selesai</span>
        </div>
    </div>

    <!-- Header Card -->
    <div class="success-header">
        <div class="success-icon">
            <i class="ti ti-heart-handshake"></i>
        </div>
        <h1>Jazakallahu Khairan!</h1>
        <p>Terima kasih atas infaq Anda. Semoga menjadi amal jariyah.</p>
        <div class="invoice-badge">
            <i class="ti ti-receipt" style="margin-right: 0.3rem;"></i> {{ $transaction->invoice_number }}
        </div>
    </div>

    <!-- Payment Detail Card -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="ti ti-file-invoice"></i>
            Rincian Pembayaran
        </div>
        <div class="info-card-body">
            <div class="detail-row">
                <span class="detail-label">Program</span>
                <span class="detail-value">{{ $transaction->infaqCategory->name ?? 'Infaq' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama</span>
                <span class="detail-value">{{ $transaction->is_anonymous ? 'Hamba Allah' : $transaction->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nominal Infaq</span>
                <span class="detail-value">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
            </div>
            @if($transaction->admin_fee > 0)
            <div class="detail-row">
                <span class="detail-label">Biaya Admin</span>
                <span class="detail-value" style="color: #6b7280;">Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($transaction->unique_code > 0)
            <div class="detail-row">
                <span class="detail-label">Kode Unik</span>
                <span class="detail-value" style="color: #f59e0b;">+ Rp {{ number_format($transaction->unique_code, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="detail-total">
                <div class="detail-row" style="border: none; padding: 0;">
                    <span class="detail-label">Total Transfer</span>
                    <span class="detail-value">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</span>
                </div>
                @if(!$transaction->snap_token && $transaction->unique_code > 0)
                <div class="unique-warning">
                    <i class="ti ti-alert-triangle"></i>
                    Transfer TEPAT sampai 3 digit terakhir agar terverifikasi otomatis
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Method / Gateway -->
    @if($transaction->snap_token && isset($setting) && $setting->is_payment_gateway_active)
        <div class="info-card">
            <div class="info-card-body" style="padding: 1.5rem;">
                <button id="pay-button" class="pay-btn">
                    <i class="ti ti-credit-card" style="margin-right: 0.5rem;"></i> Bayar Sekarang
                </button>
                <p style="text-align: center; margin-top: 0.75rem; font-size: 0.8rem; color: #9ca3af;">
                    <i class="ti ti-shield-check" style="color: #22c55e; margin-right: 0.25rem;"></i> Pembayaran aman via Midtrans
                </p>
            </div>
        </div>
    @elseif($transaction->paymentMethod)
        <div class="info-card">
            <div class="info-card-header">
                <i class="ti ti-building-bank"></i>
                Transfer ke Rekening
            </div>
            <div class="info-card-body">
                <div class="bank-card">
                    <div class="bank-icon" style="background: white; border: 1px solid #eee; padding: 5px; overflow: hidden;">
                        @if($transaction->paymentMethod->logo_url)
                            <img src="{{ asset($transaction->paymentMethod->logo_url) }}" alt="{{ $transaction->paymentMethod->bank_name }}" style="width: 100%; height: 100%; object-fit: contain;">
                        @else
                            <i class="ti ti-building-bank"></i>
                        @endif
                    </div>
                    <div>
                        <div class="bank-name">{{ $transaction->paymentMethod->bank_name }}</div>
                        <div class="bank-number" onclick="copyNumber('{{ $transaction->paymentMethod->account_number }}')">
                            {{ $transaction->paymentMethod->account_number }}
                            <i class="ti ti-copy" style="font-size: 0.9rem; opacity: 0.6;"></i>
                        </div>
                        <div class="bank-account-name">a.n {{ $transaction->paymentMethod->account_name }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Status / Upload Section -->
    @if($transaction->status === 'confirmed')
        <div class="status-success">
            <div class="status-icon"><i class="ti ti-circle-check"></i></div>
            <h3 style="font-weight: 700; font-size: 1.1rem; color: #166534; margin-bottom: 0.25rem;">Infaq Anda Telah Dikonfirmasi ✅</h3>
            <p style="color: #4ade80; font-size: 0.9rem;">Jazakallahu khairan, infaq Anda telah diterima dan diverifikasi oleh admin.</p>
        </div>
        <a href="{{ route('home') }}" class="home-btn">
            <i class="ti ti-home" style="margin-right: 0.5rem;"></i> Kembali ke Beranda
        </a>
    @elseif(session('success'))
        <div class="status-success">
            <div class="status-icon"><i class="ti ti-check"></i></div>
            <h3 style="font-weight: 700; font-size: 1.1rem; color: #166534; margin-bottom: 0.25rem;">Bukti Berhasil Diupload!</h3>
            <p style="color: #4ade80; font-size: 0.9rem;">Admin akan segera memverifikasi infaq Anda.</p>
        </div>
        <a href="{{ route('home') }}" class="home-btn">
            <i class="ti ti-home" style="margin-right: 0.5rem;"></i> Kembali ke Beranda
        </a>
    @elseif($transaction->payment_proof)
        <div class="status-pending">
            <div class="status-icon"><i class="ti ti-clock"></i></div>
            <h3 style="font-weight: 700; font-size: 1.1rem; color: #92400e; margin-bottom: 0.25rem;">Sedang Diverifikasi</h3>
            <p style="color: #d97706; font-size: 0.9rem;">Bukti pembayaran Anda sedang dicek oleh admin.</p>
        </div>
        <a href="{{ route('home') }}" class="home-btn">
            <i class="ti ti-home" style="margin-right: 0.5rem;"></i> Kembali ke Beranda
        </a>
    @else
        <div class="info-card">
            <div class="info-card-header">
                <i class="ti ti-camera"></i>
                Konfirmasi Pembayaran
            </div>
            <div class="info-card-body">
                <form action="{{ route('infaq.confirm', ['invoice' => $transaction->invoice_number]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-area" onclick="document.getElementById('file-input').click()">
                        <div class="upload-icon">
                            <i class="ti ti-cloud-upload"></i>
                        </div>
                        <p style="font-weight: 600; margin-bottom: 0.25rem; color: #374151;">Upload Bukti Transfer</p>
                        <p style="font-size: 0.8rem; color: #9ca3af;">Klik untuk memilih foto struk / screenshot</p>
                        <input type="file" id="file-input" name="payment_proof" accept="image/*" required style="display: none;" onchange="showPreview(this)">
                        <div id="file-preview" style="margin-top: 1rem; display: none;">
                            <img id="preview-img" src="" style="max-height: 180px; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <p id="file-name" style="font-size: 0.8rem; margin-top: 0.5rem; color: var(--primary); font-weight: 600;"></p>
                        </div>
                    </div>
                    <button type="submit" class="upload-btn">
                        <i class="ti ti-send" style="margin-right: 0.5rem;"></i> Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Doa Section -->
    @if($transaction->message)
    <div style="text-align: center; margin-top: 1.5rem; padding: 1.25rem; background: white; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <p style="font-size: 0.8rem; color: #9ca3af; margin-bottom: 0.5rem;">Doa Anda</p>
        <p style="font-style: italic; color: #374151; line-height: 1.6;">"{{ $transaction->message }}"</p>
    </div>
    @endif

</div>

<!-- Copy Toast -->
<div id="copy-toast" class="copy-toast">
    <i class="ti ti-check" style="margin-right: 0.5rem;"></i> Nomor rekening disalin!
</div>

<script>
    function showPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('file-preview').style.display = 'block';
                document.getElementById('file-name').textContent = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function copyNumber(number) {
        navigator.clipboard.writeText(number).then(() => {
            const toast = document.getElementById('copy-toast');
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 2000);
        });
    }
</script>

@if($transaction->snap_token && isset($setting) && $setting->is_payment_gateway_active)
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaction->snap_token }}', {
          onSuccess: function(result){ window.location.reload(); },
          onPending: function(result){ window.location.reload(); },
          onError: function(result){ alert("Pembayaran gagal!"); window.location.reload(); },
          onClose: function(){}
        });
      };
    </script>
@endif
@endsection
