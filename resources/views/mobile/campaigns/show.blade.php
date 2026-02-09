@extends('layouts.mobile_layout')

@section('title', $campaign->title)
@section('hide_bottom_nav', true)

@section('content')
<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Hero Image -->
    <div class="relative h-64 w-full bg-gray-200">
        <img src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" 
             alt="{{ $campaign->title }}" 
             class="w-full h-full object-cover">
        
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/30"></div>

        <!-- Top Nav -->
        <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-20">
            <a href="{{ route('programs.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white hover:bg-black/40 transition-colors">
                <i class="ti ti-arrow-left"></i>
            </a>
            <button onclick="shareCampaign()" class="w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white hover:bg-black/40 transition-colors">
                <i class="ti ti-share"></i>
            </button>
        </div>
    </div>

    <!-- Campaign Info -->
    <div class="bg-white rounded-t-3xl -mt-6 relative px-5 pt-8 pb-6 shadow-sm z-10">
        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded mb-2 inline-block uppercase tracking-wider">
            {{ $campaign->category->name ?? 'Umum' }}
        </span>
        <h1 class="font-bold text-xl text-gray-900 leading-tight mb-4">{{ $campaign->title }}</h1>

        <!-- Organizer -->
        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-primary">
                <i class="ti ti-building-mosque"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase font-bold">Penggalang Dana</p>
                <div class="flex items-center gap-1">
                    <p class="text-sm font-bold text-gray-900">{{ $campaign->user->name }}</p>
                    <i class="ti ti-discount-check-filled text-blue-500 text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Progress Stats -->
        <div class="mb-6">
            <div class="flex justify-between items-end mb-2">
                <div>
                    <p class="text-xs text-gray-400">Terkumpul</p>
                    <p class="text-lg font-bold text-primary">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Target</p>
                    <p class="text-sm font-bold text-gray-700">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden mb-2">
                <div class="bg-primary h-2 rounded-full" style="width: {{ $campaign->target_amount > 0 ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) : 0 }}%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 font-medium">
                <span>{{ $campaign->donations->where('status', 'confirmed')->count() }} Donatur</span>
                @php
                    $daysLeft = $campaign->end_date ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false) : null;
                @endphp
                <span>
                    @if($daysLeft !== null && $daysLeft >= 0)
                        {{ $daysLeft }} Hari Lagi
                    @else
                        Unlimited
                    @endif
                </span>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-gray-100">
            <button onclick="switchTab('desc')" id="tab-desc" class="flex-1 py-3 text-sm font-bold text-primary border-b-2 border-primary transition-colors">Deskripsi</button>
            <button onclick="switchTab('updates')" id="tab-updates" class="flex-1 py-3 text-sm font-bold text-gray-400 border-b-2 border-transparent transition-colors">
                Kabar <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full ml-1">{{ $campaign->updates->count() }}</span>
            </button>
            <button onclick="switchTab('donors')" id="tab-donors" class="flex-1 py-3 text-sm font-bold text-gray-400 border-b-2 border-transparent transition-colors">
                Donatur <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full ml-1">{{ $campaign->donations->count() }}</span>
            </button>
        </div>

        <!-- Tab Contents -->
        <div class="pt-6 min-h-[200px]">
            <!-- Description -->
            <div id="content-desc" class="tab-content block">
                <div class="prose prose-sm prose-green max-w-none text-gray-600">
                    {!! $campaign->full_description !!}
                </div>
            </div>

            <!-- Updates -->
            <div id="content-updates" class="tab-content hidden space-y-4">
                @forelse($campaign->updates as $update)
                <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-gray-900 text-sm">{{ $update->title }}</h4>
                        <span class="text-[10px] text-gray-400">{{ $update->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $update->content }}</p>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="ti ti-news text-2xl mb-2"></i>
                    <p class="text-sm">Belum ada kabar terbaru.</p>
                </div>
                @endforelse
            </div>

            <!-- Donors -->
            <div id="content-donors" class="tab-content hidden space-y-4">
                @forelse($campaign->donations->where('status', 'confirmed')->take(20) as $donation)
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-heart-handshake"></i>
                    </div>
                    <div class="flex-1 border-b border-gray-50 pb-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-gray-900 text-sm">{{ $donation->is_anonymous ? 'Hamba Allah' : ($donation->donor->name ?? 'Tamu') }}</span>
                            <span class="text-xs text-gray-400">{{ $donation->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="font-bold text-primary text-sm mb-1">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                        @if($donation->message)
                        <div class="bg-gray-50 p-2 rounded-lg text-xs text-gray-500 italic">
                            "{{ $donation->message }}"
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="ti ti-heart-off text-2xl mb-2"></i>
                    <p class="text-sm">Belum ada donatur. Jadilah yang pertama!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Sticky Bottom Action -->
<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 pb-safe z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
    <a href="{{ route('campaign.donate', $campaign->slug) }}" class="block w-full bg-primary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-light active:scale-[0.98] transition-all text-center">
        Donasi Sekarang
    </a>
</div>

<script>
    function switchTab(tabName) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('block'));
        
        // Reset tabs style
        document.querySelectorAll('button[id^="tab-"]').forEach(btn => {
            btn.classList.remove('text-primary', 'border-primary');
            btn.classList.add('text-gray-400', 'border-transparent');
        });

        // Show active content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        document.getElementById('content-' + tabName).classList.add('block');

        // Style active tab
        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove('text-gray-400', 'border-transparent');
        activeBtn.classList.add('text-primary', 'border-primary');
    }

    function shareCampaign() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $campaign->title }}',
                text: 'Bantu program kebaikan ini: {{ $campaign->title }}',
                url: window.location.href,
            })
            .catch((error) => console.log('Error sharing', error));
        } else {
            // Fallback
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    }
</script>

<style>
    .pb-safe { padding-bottom: max(1rem, env(safe-area-inset-bottom)); }
</style>
@endsection
