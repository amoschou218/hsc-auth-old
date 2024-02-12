<?php

use HamiltonSC\Auth\App\Http\Controllers\GoogleLoginController;
use AMoschou\RemoteAuth\App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

$google = config('remote_auth.socialite.google', false);

$LoginController__class = $google ? GoogleLoginController::class : LoginController::class;

Route::middleware('guest')->group(function () use ($google) {
    Route::get('/auth/login', function () { return view('vendor.laravel-remote-auth.login'); })->name('login');
    if ($google) {
        Route::post('/auth/login', [GoogleLoginController::class, 'authenticate'])->name('login.post');
    } else {
        Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('login.post');
    }
});

Route::middleware('auth')->group(function () use ($google) {
    if ($google) {
        Route::get('/auth/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');
    }

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', function () { return view('home'); })->name('home');
    Route::get('/dashboard', function () { return view('dashboard', ['user' => Auth::user()]); })->name('dashboard');
});

