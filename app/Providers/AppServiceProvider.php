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
        try {
            $sourceLogo = "C:/Users/PC/.gemini/antigravity/brain/026b0e9d-0a2a-46fd-b4a4-8ab485e50ac9/smart_city_logo_1779220311771.png";
            $destLogo = public_path('images/logo.png');
            if (file_exists($sourceLogo)) {
                if (!file_exists(dirname($destLogo))) {
                    mkdir(dirname($destLogo), 0755, true);
                }
                if (!file_exists($destLogo) || md5_file($sourceLogo) !== md5_file($destLogo)) {
                    copy($sourceLogo, $destLogo);
                }
            }
        } catch (\Exception $e) {
            // Do nothing
        }

        try {
            if (\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                view()->share('platformSettings', $settings);
            }
        } catch (\Exception $e) {
            // Do nothing
        }
    }
}
