<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

Route::post('authorize', [HomeController::class, 'authorize']);
Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('logout', [HomeController::class, 'logout']);
