<?php

use AMoschou\RemoteAuth\App\Http\Controllers\LoginController;
use HamiltonSC\Auth\App\Http\Controllers\GoogleLoginController;
use Illuminate\Support\Facades\Auth;

$google = config('remote_auth.socialite.google', false);

Route::prefix('auth')->middleware('web')->group(function () use ($google) {

    Route::middleware('guest')->group(function () use ($google) {
        Route::get('login', function () { return view('vendor.laravel-remote-auth.login'); })->name('login');

        if ($google) {
            Route::post('login', [GoogleLoginController::class, 'authenticate']);
        } else {
            Route::post('login', [LoginController::class, 'authenticate']);
        }
    });

    Route::middleware('auth')->group(function () use ($google) {
        if ($google) {
            Route::get('/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');
        }

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

});
