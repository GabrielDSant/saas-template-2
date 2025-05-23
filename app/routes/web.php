<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\geracaoController;
use App\Http\Controllers\creditosController;
use App\Http\Middleware\CheckIfAuthenticated;



Route::get('/', [homeController::class, 'home'])->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [loginController::class, 'loginPage'])->name('auth.login');
    Route::post('/login', [loginController::class, 'login'])->name('auth.login.post');
    Route::get('/register', [loginController::class, 'registerPage'])->name('auth.register');
    Route::post('/register', [loginController::class, 'register'])->name('auth.register.post');
    Route::post('/logout', [loginController::class, 'logout'])->name('auth.logout');

    // Rotas relacionadas ao Google
    Route::get('/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::prefix('dashboard')->middleware(CheckIfAuthenticated::class)->group(function () {
    Route::get('/admin', [dashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/admin/usuarios', [dashboardController::class, 'adminUsuarios'])->name('dashboard.usuarios');
    Route::get('/admin/estatisticas', [dashboardController::class, 'adminEstatisticas'])->name('dashboard.estatisticas');
    Route::get('/cliente', [dashboardController::class, 'clienteDashboard'])->name('dashboard.cliente');
    Route::get('/inicio', [dashboardController::class, 'inicio'])->name('dashboard.inicio');
    Route::get('/creditos', [dashboardController::class, 'creditos'])->name('dashboard.creditos');
    Route::get('/geracoes', [dashboardController::class, 'geracoes'])->name('dashboard.geracoes');
    Route::post('/geracoes', [geracaoController::class, 'gerarImagem'])->name('gerar.imagem');
});

Route::prefix('api')->group(function () {
    Route::get('/creditos', [creditosController::class, 'getCreditos'])->name('api.creditos');
    Route::post('/stripe/callback', [creditosController::class, 'stripeCallback'])->name('api.stripe.callback');
    Route::get('/stripe/checkout', [creditosController::class, 'createCheckoutSession'])->name('api.stripe.checkout');
});