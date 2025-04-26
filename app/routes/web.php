<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', [homeController::class, 'home'])->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [loginController::class, 'loginPage'])->name('auth.login');
    Route::post('/login', [loginController::class, 'login'])->name('auth.login.post');
    Route::post('/register', [loginController::class, 'register'])->name('auth.register');
    Route::post('/logout', [loginController::class, 'logout'])->name('auth.logout');

    // Rotas relacionadas ao Google
    Route::get('/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/admin', [dashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/cliente', [dashboardController::class, 'clienteDashboard'])->name('dashboard.cliente');
    Route::get('/settings', [dashboardController::class, 'settings'])->name('dashboard.settings');
    Route::get('/inicio', [dashboardController::class, 'inicio'])->name('dashboard.inicio');
});
