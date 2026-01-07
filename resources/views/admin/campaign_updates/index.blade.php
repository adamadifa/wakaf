@extends('layouts.admin')

@section('title', 'Kabar Terbaru')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kabar Terbaru</h1>
        <p class="text-gray-500 mt-1">Update perkembangan program wakaf kepada donatur.</p>
    </div>
    <a href="{{ route('admin.campaign-updates.create') }}" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Buat Update
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm mb-6">
    <form action="{{ route('admin.campaign-updates.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." 
                       class="w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all">
            </div>
            <div class="md:col-span-4">
                <select name="campaign_id" class="select2 w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all">
                    <option value="">Semua Campaign</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ Str::limit($campaign->title, 40) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <div class="flex gap-2">
                    <button type="submit" class="w-full px-4 py-2.5 bg-gray-800 text-white rounded-xl font-semibold hover:bg-gray-900 transition-colors">
                        Filter
                    </button>
                    @if(request()->anyFilled(['q', 'campaign_id']))
                        <a href="{{ route('admin.campaign-updates.index') }}" class="px-3 py-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- List -->
<div class="grid grid-cols-1 gap-6">
    @forelse($updates as $update)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                <div>
                     <span class="text-xs font-semibold uppercase tracking-wider text-primary mb-2 block">
                        {{ $update->campaign->title }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 leading-tight group-hover:text-primary transition-colors">
                        {{ $update->title }}
                    </h3>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                     <a href="{{ route('admin.campaign-updates.edit', $update->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-emerald-50 transition-all border border-gray-100">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    </a>
                    <form action="{{ route('admin.campaign-updates.destroy', $update->id) }}" method="POST" onsubmit="return confirm('Hapus update ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all border border-gray-100">
                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="prose prose-sm text-gray-600 mb-4 line-clamp-3">
                {!! nl2br(e($update->content)) !!}
            </div>

            <div class="flex items-center text-sm text-gray-400 border-t border-gray-50 pt-4">
                <svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                Dipublikasikan: {{ $update->published_at->format('d M Y') }}
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        <p>Belum ada kabar terbaru.</p>
    </div>
    @endforelse
</div>

@if($updates->hasPages())
<div class="mt-6">
    {{ $updates->links() }}
</div>
@endif

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Campaign",
            allowClear: true,
            width: '100%'
        });
    });
</script>
<style>
    /* Custom Select2 Styling */
    .select2-container .select2-selection--single {
        height: 46px !important; /* Larger for filters */
        background-color: #f9fafb !important;
        border: 1px solid #f3f4f6 !important;
        border-radius: 0.75rem !important;
        padding-top: 8px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }
</style>
@endpush
@endsection
