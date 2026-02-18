<aside id="sidebar" class="sidebar-transition fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-gray-100 z-50 transform -translate-x-full lg:translate-x-0 flex flex-col h-screen">
    <!-- Brand -->
    <div class="h-20 flex items-center px-8 border-b border-gray-50 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 font-bold text-xl text-gray-800">
            <img src="{{ asset('images/logo_dashboard.png') }}" alt="WakafApp" class="h-12 w-auto object-contain">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 space-y-1 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('dashboard') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>
        
        <!-- Manajemen Infaq -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Infaq</div>

        <a href="{{ route('admin.infaq-categories.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.infaq-categories.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Program Infaq
        </a>

        <a href="{{ route('admin.infaq-transactions.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.infaq-transactions.*') ? 'active-nav' : '' }}">
            <div class="flex items-center gap-3.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Verifikasi Infaq
            </div>
            @if(isset($pendingInfaqCount) && $pendingInfaqCount > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingInfaqCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.reports.infaq') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.reports.infaq') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Laporan Infaq
        </a>
        
        <!-- Wakaf Management -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Wakaf</div>

        <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.campaigns.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Data Campaign
        </a>



        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Kategori Program
        </a>

        <a href="{{ route('admin.campaign-updates.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.campaign-updates.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Kabar Terbaru
        </a>

        <a href="{{ route('admin.donations.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.donations.*') ? 'active-nav' : '' }}">
            <div class="flex items-center gap-3.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Verifikasi Donasi
            </div>
            @if(isset($pendingDonationsCount) && $pendingDonationsCount > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingDonationsCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.distributions.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.distributions.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            Data Penyaluran
        </a>

        <a href="{{ route('admin.reports.donation') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.reports.donation') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Laporan Wakaf
        </a>

        <a href="{{ route('admin.reports.distribution') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.reports.distribution') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Laporan Penyaluran
        </a>

        <!-- Zakat Management -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Zakat</div>

        <a href="{{ route('admin.zakat-types.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.zakat-types.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            Jenis Zakat
        </a>

        <a href="{{ route('admin.zakat-transactions.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.zakat-transactions.*') ? 'active-nav' : '' }}">
            <div class="flex items-center gap-3.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Verifikasi Zakat
            </div>
            @if(isset($pendingZakatsCount) && $pendingZakatsCount > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingZakatsCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.reports.zakat') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.reports.zakat') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Laporan Zakat
        </a>

        <!-- Content -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Konten</div>

        <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.news.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2-3h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-2m-2-4h2"></path></svg>
            Manajemen Berita
        </a>

        <a href="{{ route('admin.news-categories.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.news-categories.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Kategori Berita
        </a>

        <a href="{{ route('admin.albums.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.albums.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            Galeri / Album
        </a>

        <a href="{{ route('admin.vision-mission.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.vision-mission.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
            Visi & Misi
        </a>

        <a href="{{ route('admin.vision-mission-wakaf.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.vision-mission-wakaf.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
            Visi & Misi Wakaf
        </a>

        <a href="{{ route('admin.managers.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.managers.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Pengurus
        </a>

        <a href="{{ route('admin.about.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.about.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            Tentang Kami
        </a>
        
        <!-- Users -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengguna</div>

        <a href="{{ route('admin.users.index', ['type' => 'internal']) }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request('type') == 'internal' ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Manajemen User
        </a>

        <a href="{{ route('admin.donors.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.donors.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            Data Donatur
        </a>

        <!-- Settings -->
        <div class="pt-3 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</div>

        <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.payment-methods.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
            Metode Pembayaran
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-gray-500 hover:bg-gray-50 hover:text-primary transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'active-nav' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            Pengaturan
        </a>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-gray-50 bg-white flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-red-500 hover:bg-red-50 transition-all duration-200">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Log out
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const activeNav = document.querySelector('#sidebar .active-nav');
        if (activeNav) {
            activeNav.scrollIntoView({ behavior: 'instant', block: 'center' });
        }
    });
</script>
