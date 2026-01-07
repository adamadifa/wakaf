@extends('layouts.admin')

@section('title', 'Manage Campaigns')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Data Program Wakaf</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola semua program wakaf aktif dan arsip.</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Buat Program Baru
        </a>
    </div>

    <!-- Multi-Filter Section -->
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <form action="{{ route('admin.campaigns.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-12 gap-4">
                <!-- Search -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Pencarian</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul/deskripsi..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm">
                        <svg class="absolute left-3 top-2.5 text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                </div>

                <!-- Category -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Kategori</label>
                    <select name="category_id" class="w-full px-3 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1rem_1rem] bg-no-repeat bg-[right_0.75rem_center]">
                        <option value="">Semua</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1rem_1rem] bg-no-repeat bg-[right_0.75rem_center]">
                        <option value="">Semua</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="lg:col-span-2">
                     <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Periode</label>
                     <div class="flex items-center gap-2">
                         <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="Mulai" class="datepicker w-full px-3 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-xs">
                         <span class="text-gray-400">-</span>
                         <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="Sampai" class="datepicker w-full px-3 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-xs">
                     </div>
                </div>
                
                <!-- Buttons -->
                <div class="lg:col-span-2 flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-gray-800 text-white px-4 py-2 rounded-xl font-semibold hover:bg-gray-900 transition-colors text-sm flex items-center justify-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter
                    </button>
                    @if(request()->anyFilled(['q', 'category_id', 'status', 'start_date', 'end_date']))
                    <a href="{{ route('admin.campaigns.index') }}" class="px-3 py-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-colors" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-6">
    @forelse($campaigns as $campaign)
    <div class="group bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
        <!-- Card Image -->
        <div class="relative h-48 w-full shrink-0">
            <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute top-4 right-4">
                @if($campaign->status == 'active')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100/90 text-emerald-700 backdrop-blur-sm shadow-sm">Active</span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100/90 text-amber-700 backdrop-blur-sm shadow-sm">{{ ucfirst($campaign->status) }}</span>
                @endif
            </div>
        </div>

        <!-- Card Content -->
        <div class="p-6 flex-1 flex flex-col">
            <div class="text-xs font-bold text-primary uppercase tracking-wider mb-2">
                {{ $campaign->category->name ?? 'Uncategorized' }}
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">
                <a href="{{ route('admin.campaigns.show', $campaign) }}" class="hover:text-primary transition-colors">
                    {{ Str::limit($campaign->title, 50) }}
                </a>
            </h3>
            
            <p class="text-sm text-gray-500 mb-6 leading-relaxed flex-1">
                {{ Str::limit($campaign->description, 80) }}
            </p>

            <!-- Progress Bar -->
            <div class="mt-auto">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-500">Terkumpul</span>
                    <span class="font-bold text-primary">{{ round(($campaign->current_amount / $campaign->target_amount) * 100) }}%</span>
                </div>
                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden mb-3">
                    <div class="h-full bg-primary rounded-full" style="width: {{ ($campaign->current_amount / $campaign->target_amount) * 100 }}%"></div>
                </div>
                
                <div class="flex justify-between items-center text-sm">
                    <div>
                        <div class="text-gray-400 text-xs">Target</div>
                        <div class="font-semibold text-gray-700">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</div>
                    </div>
                     <div class="text-right">
                        <div class="text-gray-400 text-xs">Perolehan</div>
                        <div class="font-bold text-primary">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Footer (Actions) -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                 <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                     {{ substr($campaign->user->name ?? 'A', 0, 1) }}
                 </div>
                 <span class="text-xs text-gray-500 font-medium">{{ Str::limit($campaign->user->name ?? 'Admin', 15) }}</span>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-emerald-50 rounded-lg transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </a>
                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Hapus program ini?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
        <p class="text-gray-500">Belum ada program wakaf yang dibuat.</p>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $campaigns->links() }}
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j M Y",
            allowInput: true,
            locale: {
                firstDayOfWeek: 1
            }
        });
    });
</script>
@endpush
