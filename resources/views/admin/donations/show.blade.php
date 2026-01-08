@extends('layouts.admin')

@section('title', 'Detail Donasi')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.donations.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Donasi
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Transaksi</h2>
            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div>
                    <span class="block text-gray-500 mb-1">Status</span>
                    @if($donation->status == 'confirmed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Verified</span>
                    @elseif($donation->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">Pending Review</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">Rejected</span>
                    @endif
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Invoice</span>
                     <span class="font-mono font-semibold text-gray-800">#{{ $donation->invoice_code ?? $donation->id }}</span>
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Tanggal Donasi</span>
                     <span class="font-medium text-gray-800">{{ $donation->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Metode Pembayaran</span>
                     <span class="font-medium text-gray-800">{{ $donation->paymentMethod->name ?? 'Manual Transfer' }}</span>
                </div>
            </div>
            
             <hr class="my-6 border-dashed border-gray-200">
             
             <div>
                 <span class="block text-gray-500 mb-1">Nominal Donasi</span>
                 <span class="text-3xl font-bold text-emerald-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
             </div>
        </div>

        <!-- Donatur & Campaign Info -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Detail Donatur & Program</h2>
            
            <div class="flex items-start gap-4 mb-6">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Guest User') }}</h3>
                    <p class="text-sm text-gray-500">{{ $donation->donor->email ?? 'No email' }}</p>
                    @if($donation->note)
                        <div class="mt-3 bg-gray-50 p-3 rounded-lg text-sm text-gray-600 italic">
                            "{{ $donation->note }}"
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 border rounded-xl bg-gray-50/50">
                <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0">
                    <img src="{{ Str::startsWith($donation->campaign->image_url, 'http') ? $donation->campaign->image_url : asset('storage/' . $donation->campaign->image_url) }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 line-clamp-1">{{ $donation->campaign->title }}</h4>
                    <p class="text-xs text-gray-500 mt-1">Target: Rp {{ number_format($donation->campaign->target_amount, 0, ',', '.') }}</p>
                    <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                        @php
                            $percentage = ($donation->campaign->current_amount / $donation->campaign->target_amount) * 100;
                        @endphp
                        <div class="bg-primary h-1.5 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Verification & Proof -->
    <div class="space-y-6">
        <!-- Action Card -->
        @if($donation->status == 'pending')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Verifikasi</h2>
            <p class="text-sm text-gray-500 mb-6">Pastikan bukti pembayaran valid sebelum melakukan verifikasi.</p>
            
            <div class="flex flex-col gap-3">
                <form action="{{ route('admin.donations.update', $donation->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20" onclick="return confirm('Verifikasi donasi ini? Saldo campaign akan bertambah.')">
                        Verifikasi (Terima)
                    </button>
                </form>
                
                <form action="{{ route('admin.donations.update', $donation->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="w-full py-2.5 bg-white text-red-600 border border-red-200 rounded-xl font-semibold hover:bg-red-50 transition-colors" onclick="return confirm('Tolak donasi ini?')">
                        Tolak Donasi
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Proof Image -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Bukti Pembayaran</h2>
            @if($donation->payment_proof)
                <div class="rounded-xl overflow-hidden border border-gray-100 group relative">
                    <img src="{{ Str::startsWith($donation->payment_proof, 'http') ? $donation->payment_proof : asset('storage/' . $donation->payment_proof) }}" class="w-full h-auto">
                    <a href="{{ Str::startsWith($donation->payment_proof, 'http') ? $donation->payment_proof : asset('storage/' . $donation->payment_proof) }}" target="_blank" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-medium transition-opacity">
                        Lihat Ukuran Penuh
                    </a>
                </div>
            @else
                <div class="p-8 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <p class="text-sm">Tidak ada bukti pembayaran</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
