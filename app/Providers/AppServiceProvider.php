<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useTailwind();
        try {
            $settings = \App\Models\Setting::first();
            if (!$settings) {
                 // Prevent error if table exists but empty, though controller creates it.
                 // Ideally create a dummy object or handle it in view.
                 $settings = new \App\Models\Setting();
            }
            \Illuminate\Support\Facades\View::share('site_settings', $settings);
        } catch (\Exception $e) {
            // Fails gracefully during migration or if table missing
        }
    }
}
