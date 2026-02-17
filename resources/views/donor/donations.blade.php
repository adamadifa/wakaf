@extends('layouts.home_layout')

@section('title', 'Riwayat Donasi')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-5">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Donasi</h1>
            <a href="{{ route('donor.dashboard') }}" class="btn btn-outline flex items-center gap-2">
                <i class="ti ti-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Program</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($donations as $donation)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $donation->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $donation->campaign->title }}</div>
                                <div class="text-xs text-gray-500">{{ $donation->invoice_number }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-primary">
                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusClass = $statusClasses[$donation->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($donation->status === 'confirmed')
                                <a href="{{ route('donor.receipt', $donation->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                    <i class="ti ti-download"></i> Kwitansi
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ti ti-heart-off text-4xl mb-3 text-gray-300"></i>
                                    <p class="font-medium">Belum ada riwayat donasi.</p>
                                    <a href="{{ route('programs.index') }}" class="mt-3 btn btn-primary btn-sm">Mulai Berbagi</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($donations->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $donations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
