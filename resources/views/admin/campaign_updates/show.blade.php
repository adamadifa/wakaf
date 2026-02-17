@extends('layouts.admin')

@section('title', 'Detail Kabar Terbaru')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.campaign-updates.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Daftar
    </a>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8">
            <div class="mb-6">
                <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-3">
                    {{ $campaignUpdate->campaign->title }}
                </span>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $campaignUpdate->title }}</h1>
                <div class="flex items-center text-sm text-gray-500 gap-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ $campaignUpdate->published_at->format('d F Y') }}
                    </span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Admin
                    </span>
                </div>
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                {!! $campaignUpdate->content !!}
            </div>
        </div>
        
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.campaign-updates.edit', $campaignUpdate->id) }}" class="px-4 py-2 bg-yellow-400 text-yellow-900 rounded-lg font-semibold hover:bg-yellow-500 transition-colors flex items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                Edit
            </a>
            <form action="{{ route('admin.campaign-updates.destroy', $campaignUpdate->id) }}" method="POST" onsubmit="return confirm('Hapus update ini?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-semibold hover:bg-red-200 transition-colors flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
