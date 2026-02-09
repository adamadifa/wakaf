@extends('layouts.admin')

@section('title', 'Detail Zakat')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.zakat-transactions.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Verifikasi Zakat
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
                    @if($transaction->status == 'confirmed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Confirmed</span>
                    @elseif($transaction->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">Pending Review</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">Rejected</span>
                    @endif
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Invoice</span>
                     <span class="font-mono font-semibold text-gray-800">{{ $transaction->invoice_number }}</span>
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Tanggal Transaksi</span>
                     <span class="font-medium text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div>
                     <span class="block text-gray-500 mb-1">Metode Pembayaran</span>
                     <span class="font-medium text-gray-800">{{ $transaction->paymentMethod->name ?? 'Manual Transfer' }}</span>
                </div>
            </div>
            
             <hr class="my-6 border-dashed border-gray-200">
             
             <div>
                 <span class="block text-gray-500 mb-1">Nominal Pokok</span>
                 <span class="text-lg font-semibold text-gray-800">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
             </div>
             @if($transaction->unique_code > 0)
             <div class="mt-2">
                 <span class="block text-gray-500 mb-1">Kode Unik</span>
                 <span class="text-sm font-semibold text-gray-800">{{ $transaction->unique_code }}</span>
             </div>
             @endif
             <div class="mt-4 pt-4 border-t border-gray-100">
                 <span class="block text-gray-500 mb-1">Total Transfer (Wajib Dicek)</span>
                 <span class="text-3xl font-bold text-emerald-600">Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}</span>
             </div>
        </div>

        <!-- Muzakki Info -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Detail Muzakki</h2>
            
            <div class="flex items-start gap-4 mb-6">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $transaction->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $transaction->email }}</p>
                    <p class="text-sm text-gray-500">{{ $transaction->phone ?? '-' }}</p>
                </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 border rounded-xl bg-gray-50/50">
                <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 flex items-center justify-center bg-gray-200">
                     <i class="{{ $transaction->zakatType->icon ?? 'ti-package' }} text-2xl text-gray-500"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 line-clamp-1">{{ $transaction->zakatType->name }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($transaction->zakatType->description, 60) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Verification & Proof -->
    <div class="space-y-6">
        <!-- Action Card -->
        @if($transaction->status == 'pending')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Verifikasi</h2>
            <p class="text-sm text-gray-500 mb-6">Pastikan bukti pembayaran valid sebelum melakukan verifikasi.</p>
            
            <div class="flex flex-col gap-3">
                <form action="{{ route('admin.zakat-transactions.update', $transaction->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20" onclick="return confirm('Verifikasi transaksi ini?')">
                        Verifikasi (Terima)
                    </button>
                </form>
                
                <form action="{{ route('admin.zakat-transactions.update', $transaction->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="w-full py-2.5 bg-white text-red-600 border border-red-200 rounded-xl font-semibold hover:bg-red-50 transition-colors" onclick="return confirm('Tolak transaksi ini?')">
                        Tolak Transaksi
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Proof Image -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Bukti Pembayaran</h2>
            @if($transaction->payment_proof)
                <div class="rounded-xl overflow-hidden border border-gray-100 group relative">
                    <img src="{{ Str::startsWith($transaction->payment_proof, 'http') ? $transaction->payment_proof : asset('storage/' . $transaction->payment_proof) }}" class="w-full h-auto">
                    <a href="{{ Str::startsWith($transaction->payment_proof, 'http') ? $transaction->payment_proof : asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-medium transition-opacity">
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
