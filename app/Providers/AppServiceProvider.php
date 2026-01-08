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
            $settings = \App\Models\Setting::get();
            if (!$settings) {
                $settings = new \App\Models\Setting();
            }
            \Illuminate\Support\Facades\View::share('site_settings', $settings);
        } catch (\Exception $e) {
            // Fails gracefully during migration
        }
    }
}
