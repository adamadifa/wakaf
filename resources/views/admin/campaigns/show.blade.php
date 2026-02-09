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

<div class="max-w-6xl mx-auto">
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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 pt-6 border-t border-gray-100">
                <div class="bg-emerald-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-600">{{ $donations->count() }}</div>
                    <div class="text-xs text-emerald-600 font-medium">Total Donatur</div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $distributions->count() }}</div>
                    <div class="text-xs text-blue-600 font-medium">Penyaluran</div>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-amber-600">{{ $updates->count() }}</div>
                    <div class="text-xs text-amber-600 font-medium">Kabar Berita</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($distributions->sum('amount'), 0, ',', '.') }}</div>
                    <div class="text-xs text-purple-600 font-medium">Dana Disalurkan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="border-b border-gray-100">
            <nav class="flex" id="tabs">
                <button type="button" data-tab="info" class="tab-btn active flex-1 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-primary border-b-2 border-transparent transition-all">
                    <i class="ti ti-info-circle mr-2"></i>Informasi
                </button>
                <button type="button" data-tab="updates" class="tab-btn flex-1 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-primary border-b-2 border-transparent transition-all">
                    <i class="ti ti-news mr-2"></i>Kabar Berita <span class="ml-1 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $updates->count() }}</span>
                </button>
                <button type="button" data-tab="distributions" class="tab-btn flex-1 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-primary border-b-2 border-transparent transition-all">
                    <i class="ti ti-send mr-2"></i>Penyaluran <span class="ml-1 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $distributions->count() }}</span>
                </button>
                <button type="button" data-tab="donors" class="tab-btn flex-1 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-primary border-b-2 border-transparent transition-all">
                    <i class="ti ti-users mr-2"></i>Data Donatur <span class="ml-1 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $donations->count() }}</span>
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Info Tab -->
            <div id="tab-info" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Singkat</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">{{ $campaign->short_description }}</p>

                        <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Lengkap</h3>
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($campaign->full_description)) !!}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Campaign</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Tanggal Mulai</span>
                                <span class="text-sm font-medium text-gray-900">{{ $campaign->start_date ? $campaign->start_date->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Tanggal Selesai</span>
                                <span class="text-sm font-medium text-gray-900">{{ $campaign->end_date ? $campaign->end_date->format('d M Y') : 'Tidak ditentukan' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Dibuat Oleh</span>
                                <span class="text-sm font-medium text-gray-900">{{ $campaign->user->name }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Terakhir Diupdate</span>
                                <span class="text-sm font-medium text-gray-900">{{ $campaign->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Updates/News Tab -->
            <div id="tab-updates" class="tab-content hidden">
                @if($updates->count() > 0)
                <div class="space-y-4">
                    @foreach($updates as $update)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="font-bold text-gray-900">{{ $update->title }}</h4>
                            <span class="text-xs text-gray-500">{{ $update->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $update->content }}</p>
                        @if($update->image_url)
                        <img src="{{ asset('storage/' . $update->image_url) }}" class="mt-3 rounded-lg max-h-48 object-cover" alt="">
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-news text-2xl text-gray-400"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Belum Ada Kabar Berita</h4>
                    <p class="text-sm text-gray-500">Kabar berita campaign akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>

            <!-- Distributions Tab -->
            <div id="tab-distributions" class="tab-content hidden">
                @if($distributions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-700 font-semibold text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                                <th class="px-4 py-3">Kegiatan</th>
                                <th class="px-4 py-3">Nominal</th>
                                <th class="px-4 py-3">Dicatat Oleh</th>
                                <th class="px-4 py-3 rounded-r-lg">Dokumentasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($distributions as $distribution)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">{{ $distribution->distributed_at->format('d M Y') }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-gray-900">{{ $distribution->title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ Str::limit($distribution->description, 50) }}</div>
                                </td>
                                <td class="px-4 py-4 font-semibold text-gray-900">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $distribution->user->name ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    @if($distribution->documentation_url)
                                    <a href="{{ asset('storage/' . $distribution->documentation_url) }}" target="_blank" class="text-primary hover:underline text-xs">Lihat</a>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right">Total Penyaluran:</td>
                                <td colspan="3" class="px-4 py-3 text-primary">Rp {{ number_format($distributions->sum('amount'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-send text-2xl text-gray-400"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Belum Ada Data Penyaluran</h4>
                    <p class="text-sm text-gray-500">Data penyaluran dana campaign akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>

            <!-- Donors Tab -->
            <div id="tab-donors" class="tab-content hidden">
                @if($donations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-700 font-semibold text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                                <th class="px-4 py-3">Donatur</th>
                                <th class="px-4 py-3">Nominal</th>
                                <th class="px-4 py-3">Pesan</th>
                                <th class="px-4 py-3 rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($donations as $donation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">{{ $donation->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-4">
                                    @if($donation->is_anonymous)
                                        <div class="font-medium text-gray-900">Hamba Allah</div>
                                        <div class="text-xs text-gray-500">Donasi Anonim</div>
                                    @else
                                        <div class="font-medium text-gray-900">{{ $donation->donor->name ?? 'Guest' }}</div>
                                        <div class="text-xs text-gray-500">{{ $donation->donor->email ?? '-' }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-semibold text-gray-900">Rp {{ number_format($donation->total_transfer, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ Str::limit($donation->message ?? '-', 30) }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Confirmed</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right">Total Donasi:</td>
                                <td colspan="3" class="px-4 py-3 text-primary">Rp {{ number_format($donations->sum('total_transfer'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-users text-2xl text-gray-400"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Belum Ada Data Donatur</h4>
                    <p class="text-sm text-gray-500">Data donatur yang berdonasi akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .tab-btn.active {
        color: #10b981;
        border-bottom-color: #10b981;
        background-color: #ecfdf5;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const tabId = this.dataset.tab;

                // Remove active from all buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                // Add active to clicked button
                this.classList.add('active');

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));
                // Show selected tab content
                document.getElementById('tab-' + tabId).classList.remove('hidden');
            });
        });
    });
</script>
@endsection
