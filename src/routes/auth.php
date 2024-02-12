<?php

use HamiltonSC\Auth\App\Http\Controllers\GoogleLoginController;
use AMoschou\RemoteAuth\App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

$LoginController__class = config('remote_auth.socialite.google', false) ? GoogleLoginController::class : LoginController::class;

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', function () { return view('vendor.laravel-remote-auth.login'); })->name('login');
    Route::post('/auth/login', [$LoginController__class, 'authenticate'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/callback', [$LoginController__class, 'callback'])->name('google.callback');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', function () { return view('home'); })->name('home');
    Route::get('/dashboard', function () { return view('dashboard', ['user' => Auth::user()]); })->name('dashboard');
});

