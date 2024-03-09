<?php

use AMoschou\RemoteAuth\App\Http\Controllers\LoginController;
use AMoschou\RemoteAuth\App\Http\Middleware\Authenticate as AuthMiddleware;
use AMoschou\RemoteAuth\App\Http\Middleware\RedirectIfAuthenticated as GuestMiddleware;
use HamiltonSC\Auth\App\Http\Controllers\GoogleLoginController;

$google = config('remote_auth.socialite.google', false);

$web = [
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
];

Route::prefix('auth')->middleware($web)->group(function () use ($google) {

    Route::middleware(GuestMiddleware::class)->group(function () use ($google) {
        Route::get('login', function () {
            return view('remote-auth::login');
        })->name('login');

        if ($google) {
            Route::post('login', [GoogleLoginController::class, 'authenticate'])->name('login.post');
        } else {
            Route::post('login', [LoginController::class, 'authenticate'])->name('login.post');
        }
    });

    Route::middleware(AuthMiddleware::class)->group(function () use ($google) {
        if ($google) {
            Route::get('/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');
        }

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

});
