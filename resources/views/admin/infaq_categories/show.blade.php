@extends('layouts.admin')

@section('title', 'Detail Program Infaq')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8 pl-1">
        <a href="{{ route('admin.infaq-categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Program Infaq
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">{{ $infaqCategory->name }}</h1>
            <a href="{{ route('admin.infaq-categories.edit', $infaqCategory) }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all text-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Thumbnail -->
        @if($infaqCategory->image)
        <div class="w-full h-56 bg-gray-100">
            <img src="{{ Str::startsWith($infaqCategory->image, 'http') ? $infaqCategory->image : asset($infaqCategory->image) }}" 
                 class="w-full h-full object-cover" alt="{{ $infaqCategory->name }}">
        </div>
        @endif

        <div class="p-6 md:p-8 space-y-6">
            <!-- Info Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Nama Program</div>
                    <div class="text-gray-800 font-semibold">{{ $infaqCategory->name }}</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Icon</div>
                    <div class="flex items-center gap-2 text-gray-800">
                        <i class="ti {{ $infaqCategory->icon ?? 'ti-coins' }} text-xl text-primary"></i>
                        <span class="font-mono text-sm text-gray-500">{{ $infaqCategory->icon ?? 'ti-coins' }}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($infaqCategory->description)
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Deskripsi</div>
                <div class="prose prose-sm max-w-none text-gray-600">
                    {!! $infaqCategory->description !!}
                </div>
            </div>
            @else
            <div class="text-center py-4 text-gray-400 text-sm italic">Belum ada deskripsi.</div>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Terkumpul</div>
                    <div class="text-xl font-bold text-gray-800">Rp {{ number_format($totalCollected, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Jumlah Donatur</div>
                    <div class="text-xl font-bold text-gray-800">{{ $donorCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donors List -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
        <div class="p-6 border-b border-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Daftar Donatur</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500">No</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500">Nama</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500">Email</th>
                        <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500">Nominal</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500">Doa</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($donors as $index => $donor)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-3 px-6 text-sm text-gray-400">{{ $index + 1 }}</td>
                        <td class="py-3 px-6">
                            <div class="text-sm font-semibold text-gray-800">{{ $donor->is_anonymous ? 'Hamba Allah' : $donor->name }}</div>
                            @if($donor->is_anonymous)
                                <div class="text-xs text-gray-400">{{ $donor->name }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm text-gray-500">{{ $donor->email }}</td>
                        <td class="py-3 px-6 text-sm font-semibold text-gray-800 text-right">Rp {{ number_format($donor->amount + $donor->unique_code, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-sm text-gray-500 max-w-[200px] truncate">{{ $donor->message ?? '-' }}</td>
                        <td class="py-3 px-6 text-sm text-gray-400">{{ $donor->confirmed_at ? $donor->confirmed_at->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm">Belum ada donatur.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
