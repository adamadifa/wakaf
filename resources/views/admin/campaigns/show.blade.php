@extends('layouts.admin')

@section('title', 'Detail Campaign')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.campaigns.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Campaign
    </a>
</div>

<div class="max-w-5xl mx-auto">
    <!-- Campaign Header -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden mb-6">
        <div class="relative h-80 overflow-hidden">
            <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                 class="w-full h-full object-cover" 
                 alt="{{ $campaign->title }}">
            <div class="absolute top-4 right-4">
                @if($campaign->status == 'active')
                    <span class="px-3 py-1.5 bg-green-500 text-white text-xs font-semibold rounded-full">Aktif</span>
                @elseif($campaign->status == 'completed')
                    <span class="px-3 py-1.5 bg-blue-500 text-white text-xs font-semibold rounded-full">Selesai</span>
                @elseif($campaign->status == 'draft')
                    <span class="px-3 py-1.5 bg-gray-500 text-white text-xs font-semibold rounded-full">Draft</span>
                @else
                    <span class="px-3 py-1.5 bg-red-500 text-white text-xs font-semibold rounded-full">Suspended</span>
                @endif
            </div>
        </div>

        <div class="p-8">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $campaign->title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            {{ $campaign->category->name }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            {{ $campaign->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all text-sm">
                        Edit Campaign
                    </a>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progress Donasi</span>
                    <span class="text-sm font-bold text-primary">{{ number_format(($campaign->current_amount / $campaign->target_amount) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary to-emerald-400 h-full rounded-full transition-all duration-500" 
                         style="width: {{ min(($campaign->current_amount / $campaign->target_amount) * 100, 100) }}%"></div>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-600">Terkumpul: <strong class="text-gray-900">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</strong></span>
                    <span class="text-sm text-gray-600">Target: <strong class="text-gray-900">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong></span>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Singkat</h3>
                <p class="text-gray-700 leading-relaxed mb-6">{{ $campaign->short_description }}</p>

                <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Lengkap</h3>
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($campaign->full_description)) !!}
                </div>
            </div>

            <!-- Campaign Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-6 border-t border-gray-100">
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Tanggal Mulai</h4>
                    <p class="text-gray-900 font-medium">{{ $campaign->start_date ? \Carbon\Carbon::parse($campaign->start_date)->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Tanggal Selesai</h4>
                    <p class="text-gray-900 font-medium">{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') : 'Tidak ditentukan' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Dibuat Oleh</h4>
                    <p class="text-gray-900 font-medium">{{ $campaign->user->name }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Terakhir Diupdate</h4>
                    <p class="text-gray-900 font-medium">{{ $campaign->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
