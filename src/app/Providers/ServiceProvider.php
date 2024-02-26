<?php

namespace HamiltonSC\Auth\App\Providers;

use AMoschou\RemoteAuth\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
    */
    public function register(): void
    {
        Settings::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
    */
    public function boot(): void
    {
        $this->loadRoutesFrom($this->path('routes/web.php'));
    }

    private function path($path): string
    {
        return __DIR__ . '/../../' . $path;
    }
}
