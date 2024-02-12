<?php

namespace HamiltonSC\Auth\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
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
        Route::prefix(config('remote_auth.route_prefix'))->name('remote_auth.')->middleware('web')->group(function () {
            $this->loadRoutesFrom($this->path('routes/auth.php'));
        });
    }

    private function path($path): string
    {
        return __DIR__ . '/../../' . $path;
    }
}
