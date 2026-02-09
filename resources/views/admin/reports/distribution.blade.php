@extends('layouts.admin')

@section('title', 'Laporan Penyaluran Dana')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle ?? 'Laporan Penyaluran Dana' }}</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau dan cetak laporan penyaluran dana wakaf</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.distribution.export', request()->all()) }}" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="ti ti-file-spreadsheet"></i>
                Export Excel
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2">
                <i class="ti ti-printer"></i>
                Cetak Laporan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 no-print">
        <form action="{{ route('admin.reports.distribution') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 outline-none">
            </div>
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
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-colors font-medium">
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="ti ti-cash-banknote"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Dana Disalurkan</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="ti ti-send"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Jumlah Penyaluran</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalDistributions) }} Kegiatan</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-bold text-lg text-gray-900">Rincian Penyaluran Dana</h2>
            <div class="text-sm text-gray-500">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Nama Kegiatan</th>
                        <th class="px-6 py-4">Program Wakaf</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($distributions as $distribution)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $distribution->distributed_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $distribution->title }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($distribution->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $distribution->campaign->title ?? '-' }}</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                {{ $distribution->campaign->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp {{ number_format($distribution->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $distribution->user->name ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="ti ti-folder-off text-3xl"></i>
                                <p>Tidak ada data penyaluran ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($distributions->count() > 0)
                <tfoot class="bg-gray-50 font-bold text-gray-900">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right">Total</td>
                        <td class="px-6 py-4">Rp {{ number_format($distributions->sum('amount'), 0, ',', '.') }}</td>
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
        flatpickr("input[type=date]", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
        });

        $(document).ready(function() {
            $('select[name="campaign_id"]').select2({
                placeholder: "Pilih Program Wakaf",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>

<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-radius: 0.75rem !important;
        border-color: #e5e7eb !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
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
