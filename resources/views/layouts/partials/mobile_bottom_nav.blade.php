@unless(View::hasSection('hide_bottom_nav'))
<!-- Mobile Bottom Navigation -->
<nav class="fixed bottom-0 left-0 z-50 w-full bg-white border-t border-gray-200 pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] md:hidden">
    <div class="grid h-16 max-w-lg grid-cols-4 mx-auto font-medium">
        <a href="{{ route('home') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('home') ? 'text-secondary' : 'text-gray-500' }}">
            <i class="ti ti-home text-2xl mb-1 group-hover:text-secondary"></i>
            <span class="text-[10px] group-hover:text-secondary">Beranda</span>
        </a>
        
        <a href="{{ route('programs.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('programs.*') ? 'text-secondary' : 'text-gray-500' }}">
            <i class="ti ti-apps text-2xl mb-1 group-hover:text-secondary"></i>
            <span class="text-[10px] group-hover:text-secondary">Program</span>
        </a>

        <a href="{{ route('news.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('news.*') ? 'text-secondary' : 'text-gray-500' }}">
            <i class="ti ti-news text-2xl mb-1 group-hover:text-secondary"></i>
            <span class="text-[10px] group-hover:text-secondary">Berita</span>
        </a>

        @if(session('donor_id') || Auth::check())
            <a href="{{ route('donor.dashboard') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('donor.*') || request()->routeIs('dashboard') ? 'text-secondary' : 'text-gray-500' }}">
                <i class="ti ti-user text-2xl mb-1 group-hover:text-secondary"></i>
                <span class="text-[10px] group-hover:text-secondary">Akun</span>
            </a>
        @else
            <a href="{{ route('donor.login') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('donor.*') ? 'text-secondary' : 'text-gray-500' }}">
                <i class="ti ti-login text-2xl mb-1 group-hover:text-secondary"></i>
                <span class="text-[10px] group-hover:text-secondary">Masuk</span>
            </a>
        @endif
    </div>
</nav>

<style>
    /* Add safe area padding for iPhones with home indicator */
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
    /* Add padding to body to prevent content from being hidden behind bottom nav on mobile */
    @media (max-width: 768px) {
        body {
            padding-bottom: 5rem !important;
        }
    }
</style>
@endunless
