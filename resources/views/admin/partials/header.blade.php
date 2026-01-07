<div class="px-6 lg:px-8 py-4 h-auto lg:h-20 mb-6 lg:mb-0 flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-0 border-b border-gray-100 bg-white">
    <div class="flex items-center gap-4">
        <!-- Mobile Toggle -->
        <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-gray-600">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        
        @if(request()->routeIs('dashboard'))
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Siang, {{ auth()->user()->name ?? 'Admin' }} 👋</h1>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Berikut adalah ringkasan perkembangan wakaf hari ini.</p>
            </div>
        @else
            <h1 class="text-2xl font-bold text-gray-900">@yield('title')</h1>
        @endif
    </div>

    @if(request()->routeIs('dashboard'))
    <div class="flex flex-col lg:flex-row gap-4 w-full lg:w-auto">
        <div class="flex items-center gap-3 bg-white border border-gray-200 px-4 py-2.5 rounded-xl flex-1 lg:w-80 shadow-sm focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary transition-all">
            <svg class="text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="Cari donatur, invoice..." class="border-none outline-none w-full text-sm placeholder-gray-400">
        </div>
        <a href="{{ route('admin.campaigns.create') }}" class="hidden lg:flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Buat Campaign
        </a>
    </div>
    @endif
</div>
