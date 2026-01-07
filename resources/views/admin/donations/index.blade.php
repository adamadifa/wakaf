@extends('layouts.admin')

@section('title', 'Manajemen Donasi')

@section('content')
<!-- Header & Filter -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
             <h1 class="text-2xl font-bold text-gray-800">Verifikasi Donasi</h1>
             <p class="text-gray-500 mt-1">Kelola dan verifikasi donasi masuk dari para wakif.</p>
        </div>
    </div>

    <!-- Multi-Filter Section -->
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <form action="{{ route('admin.donations.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-12 gap-4">
                <!-- Search -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Pencarian</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari invoice / nama donatur..." 
                               class="w-full pl-10 pr-4 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm">
                        <svg class="absolute left-3 top-2.5 text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                </div>

                <!-- Campaign -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Campaign</label>
                    <select name="campaign_id" class="select2 w-full px-3 py-2 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm appearance-none">
                        <option value="">Semua</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ Str::limit($campaign->title, 20) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full px-3 h-[42px] bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all text-sm appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1rem_1rem] bg-no-repeat bg-[right_0.75rem_center]">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="lg:col-span-2">
                     <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Periode</label>
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
                    @if(request()->anyFilled(['q', 'campaign_id', 'status', 'start_date', 'end_date']))
                    <a href="{{ route('admin.donations.index') }}" class="px-3 h-[42px] bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Donation List -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Invoice</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Donatur</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Program Wakaf</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($donations as $donation)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <span class="font-mono text-xs font-semibold text-gray-500">#{{ $donation->invoice_code ?? substr($donation->id, 0, 8) }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-medium text-gray-800">{{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->user->name ?? 'Tamu') }}</div>
                        <div class="text-xs text-gray-500">{{ $donation->user->email ?? '-' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm text-gray-600 max-w-[200px] truncate" title="{{ $donation->campaign->title }}">
                            {{ $donation->campaign->title }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-800">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6">
                        @if($donation->status == 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                            </span>
                        @elseif($donation->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                            </span>
                        @else
                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-xs text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2 text-right">
                            <a href="{{ route('admin.donations.show', $donation->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:text-primary hover:bg-emerald-50 transition-all border border-gray-100" title="Detail & Verifikasi">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-400">
                         <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <p>Belum ada data donasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($donations->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $donations->links() }}
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
                placeholder: "Pilih Campaign",
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
