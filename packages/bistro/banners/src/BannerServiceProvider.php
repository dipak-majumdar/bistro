<?php

namespace Bistro\Banners;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BannerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../src/Database/Migrations');
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'banners');
        
        // Load routes with web middleware group (required for session-based auth)
        Route::middleware('web')->group(function () {
            require __DIR__.'/../routes/web.php';
        });
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/banners'),
        ], 'banners-views');
        
        $this->publishes([
            __DIR__.'/../config/banners.php' => config_path('banners.php'),
        ], 'banners-config');
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/banners.php', 'banners'
        );
    }
}
