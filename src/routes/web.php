<?php

use AMoschou\RemoteAuth\App\Http\Controllers\LoginController;
use AMoschou\RemoteAuth\App\Http\Middleware\Authenticate as Auth;
use AMoschou\RemoteAuth\App\Http\Middleware\RedirectIfAuthenticated as SoftGuest;
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

    Route::middleware(SoftGuest::class)->group(function () use ($google) {

        Route::get('login', fn () => return view('remote-auth::login'))->name('login');

        Route::post('login', [$google ? GoogleLoginController::class : LoginController::class, 'authenticate'])->name('login.post');

    });

    Route::middleware(Auth::class)->group(function () use ($google) {

        if ($google) {
            Route::get('/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');
        }

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    });

});
