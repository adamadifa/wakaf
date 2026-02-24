@extends('layouts.frontend')

@section('title', 'Instruksi Pembayaran')

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 600px;">
    <div class="card" style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow); text-align: center;">
        <div style="color: var(--primary); font-size: 3rem; margin-bottom: 1rem;">✓</div>
        <h1 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Terima Kasih atas Donasi Anda!</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Mohon segera selesaikan pembayaran agar donasi Anda tercatat.</p>

        <div style="background: #e9ecef; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Nominal Donasi</span>
                <span style="font-weight: 600;">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
            @if($donation->admin_fee > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #666;">
                <span>Biaya Admin</span>
                <span>Rp {{ number_format($donation->admin_fee, 0, ',', '.') }}</span>
            </div>
            @endif
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 1.25rem; font-weight: 700;">
                <span>Total Bayar</span>
                <span style="color: #0066cc;">Rp {{ number_format($donation->total_transfer, 0, ',', '.') }}</span>
            </div>
            @if(!$donation->snap_token)
                <p style="font-size: 0.85rem; color: #dc3545; background: #fff; display: inline-block; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">PENTING: Transfer TEPAT sampai 3 digit terakhir</p>
            @endif
        </div>

        @if($donation->snap_token)
            <!-- Payment Gateway Button -->
            <div style="margin-bottom: 2rem;">
                <button id="pay-button" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; font-weight: bold; background-color: #0066cc; border: none;">
                    Bayar Sekarang
                </button>
            </div>
        @else
            <div style="text-align: left; border: 1px solid #ddd; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
                <p style="margin-bottom: 1rem; font-weight: 600;">Silakan transfer ke:</p>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <img src="{{ asset($donation->paymentMethod->logo_url) }}" style="height: 40px; border-radius: 4px; border: 1px solid #eee; padding: 2px;">
                    <div>
                        <p style="font-weight: 700; font-size: 1.1rem;">{{ $donation->paymentMethod->bank_name }}</p>
                        <p style="font-size: 1.25rem; font-family: monospace; letter-spacing: 1px;">{{ $donation->paymentMethod->account_number }}</p>
                        <p style="font-size: 0.9rem; color: var(--text-muted);">a.n {{ $donation->paymentMethod->account_name }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d1e7dd; color: #0f5132; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; text-align: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.5rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <br>
                <strong>Upload Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline" style="width: 100%">Kembali ke Beranda</a>
        @elseif($donation->payment_proof)
            <div style="background: #e2e3e5; color: #41464b; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; text-align: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.5rem;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <br>
                <strong>Sedang Diverifikasi</strong>
                <p>Bukti pembayaran Anda sudah kami terima dan sedang dalam proses pengecekan oleh admin.</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline" style="width: 100%">Kembali ke Beranda</a>
        @else
            <div style="margin-bottom: 2rem; border-top: 1px dashed #ddd; padding-top: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Konfirmasi Pembayaran</h3>
                <form action="{{ route('campaign.confirm', ['invoice' => $donation->invoice_number]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="upload-area" onclick="document.getElementById('file-input').click()">
                        <div style="color: var(--primary); margin-bottom: 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        </div>
                        <p style="font-weight: 600; margin-bottom: 0.5rem;">Upload Bukti Transfer</p>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Klik disini untuk memilih foto struk / screenshot</p>
                        <input type="file" id="file-input" name="payment_proof" accept="image/*" required style="display: none;" onchange="showPreview(this)">
                        <div id="file-preview" style="margin-top: 1rem; display: none;">
                            <img id="preview-img" src="" style="max-height: 200px; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <p id="file-name" style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--primary);"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Kirim Bukti Pembayaran</button>
                </form>
            </div>
        @endif
    </div>
</div>

<style>
    .upload-area {
        border: 2px dashed #ddd;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8f9fa;
    }
    .upload-area:hover {
        border-color: var(--primary);
        background: #f0fdf4;
    }
</style>

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
</script>

@if($donation->snap_token)
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $donation->snap_token }}', {
          // Optional
          onSuccess: function(result){
            /* You may add your own implementation here */
            // alert("payment success!"); 
            window.location.reload();
          },
          onPending: function(result){
            /* You may add your own implementation here */
            // alert("wating your payment!"); 
            window.location.reload();
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); 
            window.location.reload();
          },
          onClose: function(){
            /* You may add your own implementation here */
            // alert('you closed the popup without finishing the payment');
          }
        });
      };
      
      // Auto open snap if status is pending
      // document.getElementById('pay-button').click();
    </script>
@endif
@endsection
