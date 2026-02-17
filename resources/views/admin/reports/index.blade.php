@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle ?? 'Laporan Transaksi' }}</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau dan cetak laporan transaksi</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.export', array_merge(request()->all(), isset($forceType) ? ['type' => $forceType] : [])) }}" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="ti ti-file-spreadsheet"></i>
                Export Excel
            </a>
            <a href="{{ route('admin.reports.print', array_merge(request()->all(), isset($forceType) ? ['type' => $forceType] : [])) }}" target="_blank" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2">
                <i class="ti ti-printer"></i>
                Cetak Laporan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 no-print">
        <form action="{{ $forceType == 'zakat' ? route('admin.reports.zakat') : ($forceType == 'donation' ? route('admin.reports.donation') : ($forceType == 'infaq' ? route('admin.reports.infaq') : route('admin.reports.index'))) }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
            </div>
            @if(!isset($forceType))
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                <select name="type" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua Transaksi</option>
                    <option value="zakat" {{ $type == 'zakat' ? 'selected' : '' }}>Zakat</option>
                    <option value="donation" {{ $type == 'donation' ? 'selected' : '' }}>Donasi</option>
                </select>
            </div>
            @else
                <input type="hidden" name="type" value="{{ $forceType }}">
            @endif

            @if(isset($forceType) && $forceType == 'zakat')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Jenis Zakat</label>
                <select name="zakat_type_id" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
                    <option value="">Semua Jenis Zakat</option>
                    @foreach($zakatTypes as $zakatType)
                        <option value="{{ $zakatType->id }}" {{ request('zakat_type_id') == $zakatType->id ? 'selected' : '' }}>
                            {{ $zakatType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(isset($forceType) && $forceType == 'donation')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Program Wakaf</label>
                <select name="campaign_id" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
                    <option value="">Semua Program</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                            {{ \Illuminate\Support\Str::limit($campaign->title, 30) }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(isset($forceType) && $forceType == 'infaq')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Program Infaq</label>
                <select name="infaq_category_id" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
                    <option value="">Semua Program</option>
                    @foreach($infaqCategories as $infaqCategory)
                        <option value="{{ $infaqCategory->id }}" {{ request('infaq_category_id') == $infaqCategory->id ? 'selected' : '' }}>
                            {{ $infaqCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                <select name="status" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Berhasil (Confirmed)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-colors font-medium">
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="ti ti-cash"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Terkonfirmasi</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="ti ti-receipt"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="ti ti-clock"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Menunggu Pembayaran</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($pendingTransactions) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-bold text-lg text-gray-900">Rincian Transaksi</h2>
            <div class="text-sm text-gray-500">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">
                            @if(isset($forceType) && $forceType == 'zakat')
                                Jenis Zakat
                            @elseif(isset($forceType) && $forceType == 'donation')
                                Program Wakaf
                            @elseif(isset($forceType) && $forceType == 'infaq')
                                Program Infaq
                            @else
                                Tipe / Detail
                            @endif
                        </th>
                        <th class="px-6 py-4">Donatur</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs">
                            {{ $transaction->invoice_number }}
                        </td>
                        <td class="px-6 py-4">
                            @if(isset($forceType) && $forceType != 'all')
                                <div class="font-medium text-gray-900">{{ $transaction->details }}</div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type == 'Zakat' ? 'bg-purple-100 text-purple-800' : ($transaction->type == 'Infaq' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $transaction->type }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">{{ $transaction->details }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $transaction->name }}</div>
                            <div class="text-xs text-gray-500">{{ $transaction->email }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp {{ number_format($transaction->total_transfer, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->status == 'confirmed')
                                <span class="text-green-600 font-medium flex items-center gap-1">
                                    <i class="ti ti-check-circle"></i> Berhasil
                                </span>
                            @elseif($transaction->status == 'pending')
                                <span class="text-orange-600 font-medium flex items-center gap-1">
                                    <i class="ti ti-clock"></i> Pending
                                </span>
                            @else
                                <span class="text-red-600 font-medium flex items-center gap-1">
                                    <i class="ti ti-x-circle"></i> Gagal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="ti ti-folder-off text-3xl"></i>
                                <p>Tidak ada data transaksi ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transactions->count() > 0)
                <tfoot class="bg-gray-50 font-bold text-gray-900">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right">Total</td>
                        <td class="px-6 py-4">Rp {{ number_format($transactions->sum('total_transfer'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr
        flatpickr("input[type=date]", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
        });

        // Initialize Select2
        $(document).ready(function() {
            $('select[name="zakat_type_id"]').select2({
                placeholder: "Pilih Jenis Zakat",
                allowClear: true,
                width: '100%'
            });
            $('select[name="campaign_id"]').select2({
                placeholder: "Pilih Program Wakaf",
                allowClear: true,
                width: '100%'
            });
            $('select[name="infaq_category_id"]').select2({
                placeholder: "Pilih Program Infaq",
                allowClear: true,
                width: '100%'
            });
            $('select[name="status"]').select2({
                 placeholder: "Pilih Status",
                 allowClear: true,
                 width: '100%',
                 minimumResultsForSearch: Infinity 
            });
        });
    });
</script>

<style>
    /* Select2 Custom Styling to match Tailwind */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-radius: 0.75rem !important; /* rounded-xl */
        border-color: #e5e7eb !important; /* border-gray-200 */
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6b7280 !important; /* text-gray-500 */
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white !important;
        }
        aside, header, footer {
            display: none !important;
        }
        .lg\:ml-\[260px\] {
            margin-left: 0 !important;
        }
        main {
            padding: 0 !important;
        }
    }
</style>
@endsection
