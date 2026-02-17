@extends('layouts.home_layout')

@section('title', 'Riwayat Donasi')

@push('styles')
<style>
    .program-card {
        transition: transform 0.2s;
    }
    .program-card:active {
        transform: scale(0.98);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen pb-24">
    <!-- Header -->
    <div class="bg-white px-4 py-4 shadow-sm sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <a href="{{ route('donor.dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                <i class="ti ti-arrow-left text-xl text-gray-700"></i>
            </a>
            <h1 class="text-lg font-bold text-gray-900">Riwayat Donasi</h1>
        </div>
    </div>

    <!-- Content -->
    <div class="px-4 py-4 space-y-4">
        @forelse($donations as $donation)
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="text-xs text-gray-400 mb-1">{{ $donation->created_at->format('d M Y H:i') }}</div>
                        <div class="font-semibold text-gray-900 line-clamp-1">{{ $donation->campaign->title }}</div>
                    </div>
                    @php
                        $statusColor = 'bg-gray-100 text-gray-500';
                        $statusLabel = 'Pending';
                        if($donation->status == 'confirmed') {
                            $statusColor = 'bg-green-100 text-green-600';
                            $statusLabel = 'Berhasil';
                        } elseif($donation->status == 'rejected') {
                            $statusColor = 'bg-red-100 text-red-600';
                            $statusLabel = 'Gagal';
                        }
                    @endphp
                    <span class="px-2 py-1 rounded-md text-xs font-medium {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                
                <div class="flex justify-between items-end">
                    <div>
                        <div class="text-xs text-gray-500">Nominal Donasi</div>
                        <div class="font-bold text-primary">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                    </div>
                    <a href="#" class="text-xs text-gray-400 hover:text-primary flex items-center gap-1">
                        Detail <i class="ti ti-chevron-right"></i>
                    </a>
                </div>

                @if($donation->status == 'confirmed')
                <div class="mt-3 pt-3 border-t border-gray-50">
                    <a href="{{ route('donor.receipt', $donation->id) }}" class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-gray-50 text-gray-600 text-xs font-medium hover:bg-gray-100 transition-colors">
                        <i class="ti ti-download"></i> Download Kwitansi
                    </a>
                </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                    <i class="ti ti-heart-off text-3xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Belum Ada Donasi</h3>
                <p class="text-sm max-w-[200px]">Anda belum melakukan donasi apapun saat ini.</p>
                <a href="{{ route('programs.index') }}" class="mt-4 btn btn-primary px-6 py-2 rounded-full text-sm">Mulai Berbagi</a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($donations->hasPages())
            <div class="mt-6">
                {{ $donations->links('pagination.mobile') }}
            </div>
        @endif
    </div>
</div>

<!-- Bottom Navigation -->

@endsection
