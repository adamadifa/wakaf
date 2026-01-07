@extends('layouts.admin')

@section('title', 'Manajemen Metode Pembayaran')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h1>
        <p class="text-gray-500 mt-1">Kelola rekening bank dan instruksi pembayaran.</p>
    </div>
    <a href="{{ route('admin.payment-methods.create') }}" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Tambah Rekening
    </a>
</div>

<!-- List -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Bank & Logo</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nomor Rekening</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Atas Nama</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($paymentMethods as $method)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center p-1 overflow-hidden">
                                @if($method->logo_url)
                                    <img src="{{ $method->logo_url }}" alt="{{ $method->bank_name }}" class="w-full h-full object-contain">
                                @else
                                    <svg class="text-gray-300 w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 10a2 2 0 1 0 4 0 2 2 0 0 0-4 0z"/></svg>
                                @endif
                            </div>
                            <span class="font-medium text-gray-900">{{ $method->bank_name }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="font-mono text-gray-600 font-medium">{{ $method->account_number }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-gray-800">{{ $method->account_name }}</div>
                    </td>
                    <td class="py-4 px-6">
                        @if($method->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-emerald-50 transition-all" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                            <p>Belum ada metode pembayaran.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($paymentMethods->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $paymentMethods->links() }}
    </div>
    @endif
</div>
@endsection
