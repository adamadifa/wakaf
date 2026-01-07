<aside id="sidebar" class="sidebar-transition fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-gray-100 z-50 transform -translate-x-full lg:translate-x-0 overflow-y-auto">
    <!-- Brand -->
    <div class="h-20 flex items-center px-8 border-b border-gray-50 mb-6">
        <div class="flex items-center gap-3 font-bold text-xl text-gray-800">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <span>WakafApp</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="px-4 space-y-1">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('dashboard') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</div>

        <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.campaigns.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Data Campaign
        </a>

        <a href="{{ route('admin.campaign-updates.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.campaign-updates.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Kabar Terbaru
        </a>

        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Kategori Program
        </a>

        <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.donations.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            Verifikasi Donasi
        </a>

        <a href="{{ route('admin.distributions.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.distributions.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            Data Penyaluran
        </a>

        <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.payment-methods.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
            Metode Pembayaran
        </a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengguna</div>

        <a href="{{ route('admin.users.index', ['type' => 'internal']) }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request('type') == 'internal' ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Manajemen User
        </a>

        <a href="{{ route('admin.users.index', ['role' => 'donor']) }}" class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request('role') == 'donor' ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            Data Donatur
        </a>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 w-full p-4 border-t border-gray-50 bg-white">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-red-500 hover:bg-red-50 transition-all duration-200">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Log out
            </button>
        </form>
    </div>
</aside>
