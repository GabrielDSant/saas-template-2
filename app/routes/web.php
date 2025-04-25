<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;

Route::get('/', [homeController::class, 'home']);
Route::get('/', [loginController::class, 'home']);
