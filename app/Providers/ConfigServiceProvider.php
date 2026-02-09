<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class ConfigServiceProvider extends ServiceProvider
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
        try {
            // Check if settings table exists to avoid errors during initial migration
            if (Schema::hasTable('settings')) {
                $setting = Setting::first();
                
                if ($setting) {
                    if ($setting->midtrans_merchant_id) {
                        config(['services.midtrans.merchant_id' => $setting->midtrans_merchant_id]);
                    }
                    
                    if ($setting->midtrans_client_key) {
                        config(['services.midtrans.client_key' => $setting->midtrans_client_key]);
                    }
                    
                    if ($setting->midtrans_server_key) {
                        config(['services.midtrans.server_key' => $setting->midtrans_server_key]);
                    }

                    // Override is_production based on setting
                    config(['services.midtrans.is_production' => $setting->midtrans_is_production]);
                    
                    // Force sanitized/3ds to true as best practice
                    config(['services.midtrans.is_sanitized' => true]);
                    config(['services.midtrans.is_3ds' => true]);
                }
            }
        } catch (\Exception $e) {
            // Fail silently if database connection fails or other issues
        }
    }
}
