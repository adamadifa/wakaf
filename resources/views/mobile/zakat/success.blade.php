@extends('layouts.mobile_layout')

@section('title', 'Pembayaran Zakat')

@section('content')
<div class="min-h-screen bg-gray-50 pb-32">
    <!-- Header -->
    <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition-colors">
            <i class="ti ti-x text-xl"></i>
        </a>
        <h1 class="font-bold text-lg text-gray-800">Rincian Pembayaran</h1>
        <div class="w-5"></div> <!-- Spacer for center alignment -->
    </div>

    <div class="p-6">
        <!-- Status Icon -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <i class="ti ti-check text-4xl"></i>
            </div>
            <h2 class="font-bold text-2xl text-gray-900 mb-2">Terima Kasih!</h2>
            <p class="text-gray-500 text-sm">Donasi zakat Anda telah tercatat.<br>Segera selesaikan pembayaran Anda.</p>
        </div>

        <!-- Payment Details Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
            
            <div class="space-y-1 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nominal Zakat</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                @if($transaction->admin_fee > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Biaya Admin</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-base pt-2 border-t border-gray-100">
                    <span class="font-bold text-primary">Total Bayar</span>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-primary text-xl">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</span>
                        <button onclick="copyToClipboard('{{ (int)$transaction->total_transfer }}')" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="ti ti-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            @if(!$transaction->snap_token)
            <div class="bg-red-50 text-red-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block mx-auto mt-2 text-center w-full">
                PENTING: Transfer TEPAT sampai 3 digit terakhir
            </div>
            @endif
        </div>

        @if($transaction->snap_token)
            <!-- Online Payment (Midtrans) -->
            <button id="pay-button" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-light active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <i class="ti ti-credit-card"></i> Bayar Sekarang
            </button>
        @elseif($transaction->paymentMethod)
            <!-- Manual Payment -->
            <div class="space-y-6">
                <!-- Bank Info -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="ti ti-building-bank text-primary"></i> Transfer ke Rekening
                    </h3>
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center p-2 border border-gray-100 overflow-hidden">
                            @if($transaction->paymentMethod->logo_url)
                                <img src="{{ asset($transaction->paymentMethod->logo_url) }}" alt="{{ $transaction->paymentMethod->bank_name }}" class="w-full h-full object-contain">
                            @else
                                <i class="ti ti-building-bank text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-lg">{{ $transaction->paymentMethod->bank_name }}</p>
                            <div class="flex items-center gap-2">
                                <p class="text-gray-600 font-mono text-base tracking-wide">{{ $transaction->paymentMethod->account_number }}</p>
                                <button onclick="copyToClipboard('{{ $transaction->paymentMethod->account_number }}')" class="text-primary text-sm font-bold">SALIN</button>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">a.n {{ $transaction->paymentMethod->account_name }}</p>
                        </div>
                    </div>
                </div>


                <!-- Proof Upload -->
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-4 rounded-xl text-center border border-green-200">
                        <i class="ti ti-circle-check text-3xl mb-2 block"></i>
                        <p class="font-bold">Bukti Terkirim!</p>
                        <p class="text-sm">Admin kami akan segera memverifikasi.</p>
                        <a href="{{ route('home') }}" class="block mt-4 text-green-700 underline font-bold text-sm">Kembali ke Beranda</a>
                    </div>
                @elseif($transaction->payment_proof)
                    <div class="bg-gray-100 text-gray-600 p-4 rounded-xl text-center border border-gray-200">
                        <i class="ti ti-clock text-3xl mb-2 block"></i>
                        <p class="font-bold">Sedang Diverifikasi</p>
                        <p class="text-sm">Bukti pembayaran sedang dicek admin.</p>
                        <a href="{{ route('home') }}" class="block mt-4 text-gray-600 underline font-bold text-sm">Kembali ke Beranda</a>
                    </div>
                @else
                    <div class="border-t border-dashed border-gray-300 pt-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-center">Sudah Transfer?</h3>
                        <form action="{{ route('zakat.confirm', ['invoice' => $transaction->invoice_number]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="block w-full aspect-[3/1] rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center cursor-pointer hover:bg-white hover:border-primary transition-all group" id="upload-area">
                                <div class="text-center group-hover:-translate-y-1 transition-transform">
                                    <i class="ti ti-camera text-3xl text-gray-400 mb-2 group-hover:text-primary"></i>
                                    <p class="text-xs font-bold text-gray-500 group-hover:text-primary">Tap untuk upload bukti</p>
                                </div>
                                <input type="file" name="payment_proof" class="hidden" accept="image/*" onchange="previewFile(this)">
                                <img id="preview" class="hidden w-full h-full object-cover rounded-xl">
                            </label>
                            <button type="submit" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl mt-4 shadow-lg shadow-primary/20">
                                Kirim Konfirmasi
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@if($transaction->snap_token)
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

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Berhasil disalin!');
        });
    }

    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const area = document.getElementById('upload-area').querySelector('div');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                area.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
