@extends('layouts.mobile_layout')

@section('title', 'Instruksi Pembayaran')
@section('hide_bottom_nav', true)

@section('content')
<div class="min-h-screen bg-gray-50 pb-32">
    <!-- Header -->
    <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition-colors">
            <i class="ti ti-x text-xl"></i>
        </a>
        <h1 class="font-bold text-lg text-gray-900">Pembayaran</h1>
        <div class="w-5"></div> <!-- Spacer -->
    </div>

    <div class="p-5 space-y-6">
        <!-- Success Message -->
        <div class="text-center py-4">
            <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-check text-3xl"></i>
            </div>
            <h2 class="font-bold text-xl text-gray-900 mb-1">Terima Kasih!</h2>
            <p class="text-sm text-gray-500">Mohon selesaikan pembayaran donasi Anda.</p>
        </div>

        <!-- Amount Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center relative overflow-hidden">
            @if(!$donation->snap_token)
            <div class="absolute top-0 left-0 w-full bg-red-50 text-red-500 text-[10px] font-bold py-1">
                TRANSFER TEPAT SAMPAI 3 DIGIT TERAKHIR
            </div>
            @endif
            
            <div class="space-y-1 mb-4 px-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nominal Donasi</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
                @if($donation->admin_fee > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Biaya Admin</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($donation->admin_fee, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-base pt-2 border-t border-gray-100 mt-2">
                    <span class="font-bold text-primary">Total Bayar</span>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-primary text-xl">Rp {{ number_format($donation->total_transfer, 0, ',', '.') }}</span>
                        <button onclick="copyToClipboard('{{ $donation->total_transfer }}')" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="ti ti-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold">
                    <i class="ti ti-receipt"></i>
                    {{ $donation->invoice_number }}
                </span>
            </div>
        </div>

        @if($donation->snap_token)
            <!-- Online Payment (Midtrans) -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 text-center">
                <div class="mb-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="ti ti-credit-card text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900">Pembayaran Otomatis</h3>
                    <p class="text-xs text-gray-500 mt-1">Selesaikan pembayaran melalui QRIS, E-Wallet, atau Virtual Account.</p>
                </div>
                <button id="pay-button" class="w-full bg-primary text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/30 active:scale-[0.98] transition-all">
                    Bayar Sekarang
                </button>
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
            <!-- Manual Payment Details -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-900 mb-4 pb-2 border-b border-gray-50">Transfer ke Rekening:</p>
                <div class="flex items-start gap-4">
                    @if($donation->paymentMethod->logo_url)
                        <img src="{{ Storage::url($donation->paymentMethod->logo_url) }}" alt="{{ $donation->paymentMethod->bank_name }}" class="h-8 object-contain">
                    @else
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center font-bold text-gray-500">
                            {{ substr($donation->paymentMethod->bank_name, 0, 4) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">{{ $donation->paymentMethod->bank_name }}</p>
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-mono text-gray-600 text-lg tracking-wide">{{ $donation->paymentMethod->account_number }}</p>
                            <button onclick="copyToClipboard('{{ $donation->paymentMethod->account_number }}')" class="text-primary text-xs font-bold hover:underline">SALIN</button>
                        </div>
                        <p class="text-xs text-gray-400">a.n {{ $donation->paymentMethod->account_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Upload Proof -->
            @if(session('success'))
                <div class="bg-green-50 text-green-700 p-4 rounded-xl text-center border border-green-200">
                    <i class="ti ti-circle-check text-2xl mb-1 block"></i>
                    <span class="font-bold">Upload Berhasil!</span>
                    <p class="text-xs mt-1">{{ session('success') }}</p>
                </div>
                <a href="{{ route('home') }}" class="block w-full text-center py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                    Kembali ke Beranda
                </a>
            @elseif($donation->payment_proof)
                <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-center border border-blue-200">
                    <i class="ti ti-clock text-2xl mb-1 block"></i>
                    <span class="font-bold">Sedang Diverifikasi</span>
                    <p class="text-xs mt-1">Bukti pembayaran sedang dicek oleh admin.</p>
                </div>
                <a href="{{ route('home') }}" class="block w-full text-center py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                    Kembali ke Beranda
                </a>
            @else
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm font-bold text-gray-900 mb-4">Konfirmasi Pembayaran</p>
                    <form action="{{ route('campaign.confirm', ['invoice' => $donation->invoice_number]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer" onclick="document.getElementById('file-input').click()">
                            <input type="file" id="file-input" name="payment_proof" accept="image/*" required class="hidden" onchange="showPreview(this)">
                            
                            <div id="upload-placeholder">
                                <i class="ti ti-cloud-upload text-3xl text-gray-300 mb-2"></i>
                                <p class="text-sm font-bold text-gray-600">Upload Bukti Transfer</p>
                                <p class="text-xs text-gray-400 mt-1">Tap disini untuk memilih gambar</p>
                            </div>

                            <div id="file-preview" class="hidden">
                                <img id="preview-img" src="" class="max-h-48 mx-auto rounded-lg shadow-sm">
                                <p id="file-name" class="text-xs text-primary mt-2 font-medium truncate"></p>
                                <p class="text-xs text-gray-400 mt-1">Tap untuk mengganti</p>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-primary text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/30 active:scale-[0.98] transition-all">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Berhasil disalin!');
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
