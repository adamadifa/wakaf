<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('admin.partials.sidebar', function ($view) {
            $pendingDonationsCount = \App\Models\Donation::where('status', 'pending')->count();
            $pendingZakatsCount = \App\Models\ZakatTransaction::where('status', 'pending')->count();
            $pendingInfaqCount = \App\Models\InfaqTransaction::where('status', 'pending')->count();

            $view->with('pendingDonationsCount', $pendingDonationsCount)
                 ->with('pendingZakatsCount', $pendingZakatsCount)
                 ->with('pendingInfaqCount', $pendingInfaqCount);
        });
    }
}
