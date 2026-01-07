@extends('layouts.admin')

@section('title', 'Manajemen Penyaluran')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Data Penyaluran Dana</h2>
            <p class="text-sm text-gray-500 mt-1">Rekapitulasi penggunaan dana program wakaf.</p>
        </div>
        <a href="{{ route('admin.distributions.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Input Penyaluran
        </a>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
        <form action="{{ route('admin.distributions.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                
                <!-- Search -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Pencarian</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul / keterangan..." 
                               class="w-full pl-10 pr-4 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm">
                        <svg class="absolute left-3 top-2.5 text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                </div>

                <!-- Campaign -->
                <div class="lg:col-span-3">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Program Wakaf</label>
                    <select name="campaign_id" class="select2 w-full px-3 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm appearance-none">
                        <option value="">Semua Program</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ Str::limit($campaign->title, 25) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Date Range -->
                <div class="lg:col-span-3">
                     <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Penyaluran</label>
                     <div class="flex items-center gap-2">
                         <input type="text" name="start_date" value="{{ request('start_date') }}" placeholder="Mulai" class="datepicker w-full px-3 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm">
                         <span class="text-gray-400">-</span>
                         <input type="text" name="end_date" value="{{ request('end_date') }}" placeholder="Sampai" class="datepicker w-full px-3 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm">
                     </div>
                </div>
                
                <!-- Buttons -->
                <div class="lg:col-span-2 flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-gray-800 text-white px-4 h-[42px] rounded-xl font-semibold hover:bg-gray-900 transition-colors text-sm flex items-center justify-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter
                    </button>
                    @if(request()->anyFilled(['q', 'campaign_id', 'start_date', 'end_date']))
                    <a href="{{ route('admin.distributions.index') }}" class="px-3 h-[42px] bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Judul Penyaluran</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Program Wakaf</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Dokumentasi</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($distributions as $distribution)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($distribution->distributed_at)->format('d M Y') }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-medium text-gray-800">{{ $distribution->title }}</div>
                        <div class="text-xs text-gray-500 max-w-xs truncate">{{ $distribution->description }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm text-gray-600 max-w-[200px] truncate" title="{{ $distribution->campaign->title }}">
                            {{ $distribution->campaign->title }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-800">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6">
                        @if($distribution->documentation_url)
                            <a href="{{ asset('storage/' . $distribution->documentation_url) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-primary hover:text-primary-dark font-medium">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                Lihat File
                            </a>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2 text-right">
                            <a href="{{ route('admin.distributions.edit', $distribution->id) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-emerald-50 rounded-lg transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.distributions.destroy', $distribution->id) }}" method="POST" onsubmit="return confirm('Hapus data penyaluran ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-400">
                         <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <p>Belum ada data penyaluran.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($distributions->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $distributions->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init Flatpickr
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j M Y",
            allowInput: true,
            locale: {
                firstDayOfWeek: 1
            }
        });

        // Init Select2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Program Wakaf",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>

<style>
    /* Custom Select2 Styling to match Tailwind */
    .select2-container .select2-selection--single {
        height: 42px !important;
        background-color: #f9fafb !important; /* bg-gray-50 */
        border: 1px solid #f3f4f6 !important; /* border-gray-100 */
        border-radius: 0.75rem !important; /* rounded-xl */
        padding-top: 6px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: #10b981 !important; /* border-primary */
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }
</style>
@endpush
