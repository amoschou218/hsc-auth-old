<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', function () { return view('vendor.laravel-remote-auth.login'); })->name('login');
    Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/callback', [LoginController::class, 'callback'])->name('google.callback');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', function () { return view('home'); })->name('home');
    Route::get('/dashboard', function () { return view('dashboard', ['user' => Auth::user()]); })->name('dashboard');
});

