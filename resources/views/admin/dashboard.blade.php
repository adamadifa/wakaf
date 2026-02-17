@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Donation Today -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(37,150,190,0.1)] hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-full flex items-center justify-center bg-primary/10 text-primary">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Total Donasi (Hari Ini)</h3>
                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format(\App\Models\Donation::where('status', 'confirmed')->whereDate('created_at', today())->sum('amount'), 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Donation Count Today -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(37,150,190,0.1)] hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-full flex items-center justify-center bg-secondary/10 text-secondary">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Transaksi (Hari Ini)</h3>
                <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Donation::where('status', 'confirmed')->whereDate('created_at', today())->count() }} Transaksi</div>
            </div>
        </div>
    </div>

    <!-- New Donors Today -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(37,150,190,0.1)] hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-full flex items-center justify-center bg-accent/10 text-accent">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Donatur Baru (Hari Ini)</h3>
                <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Donor::whereDate('created_at', today())->count() }} Donatur</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Lists -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Analytics Chart -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-bold text-gray-900">Analytics</h4>
            <select class="border border-gray-200 text-sm rounded-lg px-3 py-1.5 outline-none focus:border-primary">
                <option>Monthly</option>
                <option>Weekly</option>
            </select>
        </div>
        <div class="relative h-[300px] w-full">
            <canvas id="donationChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity / List -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-bold text-gray-900">Donasi Terkini</h4>
        </div>
        <div class="space-y-4">
             @foreach(\App\Models\Donation::where('status', 'confirmed')->latest()->take(7)->get() as $donation)
             <div class="flex items-center gap-4">
                 <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center font-bold text-gray-500">
                     {{ $donation->is_anonymous ? 'H' : substr($donation->donor->name ?? 'G', 0, 1) }}
                 </div>
                 <div class="flex-1">
                     <div class="font-semibold text-sm text-gray-900">
                        {{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Donatur') }}
                     </div>
                     <div class="text-xs text-gray-500">Donasi {{ Str::limit($donation->campaign->title, 20) }}</div>
                 </div>
                 <div class="font-bold text-sm text-emerald-500">+Rp {{ number_format($donation->amount/1000, 0) }}k</div>
             </div>
             @endforeach
        </div>
    </div>
</div>

<!-- Campaign List / Active Projects -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h4 class="text-lg font-bold text-gray-900">Program Wakaf Aktif</h4>
        <div class="relative">
             <input type="text" placeholder="Search campaign..." class="pl-3 pr-10 py-2 border border-gray-200 rounded-lg text-sm w-full md:w-64 focus:border-primary outline-none">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Program</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Target</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Terkumpul</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Progress</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach(\App\Models\Campaign::where('status', 'active')->take(5)->get() as $campaign)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            <div class="font-semibold text-gray-900 text-sm">{{ Str::limit($campaign->title, 30) }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Active</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($campaign->target_amount, 0) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">Rp {{ number_format($campaign->current_amount, 0) }}</td>
                    <td class="px-6 py-4">
                        <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: {{ ($campaign->current_amount / $campaign->target_amount) * 100 }}%"></div>
                        </div>
                         <div class="text-xs text-gray-500 mt-1">{{ round(($campaign->current_amount / $campaign->target_amount) * 100) }}%</div>
                    </td>
                    <td class="px-6 py-4">
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    const chartData = @json($chartData ?? ['labels' => [], 'data' => []]);

    const ctx = document.getElementById('donationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Total Donation',
                data: chartData.data,
                borderColor: '#2596be',
                backgroundColor: 'rgba(37, 150, 190, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [5, 5] },
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rp ' + (value/1000000).toFixed(0) + 'jt';
                        }
                    }
                },
                x: { grid: { display: false } }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush
@endsection
