<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('home');
});

Route::post('authorize', [HomeController::class, 'authorize']);
Route::get('dashboard', [HomeController::class, 'dashboard']);
Route::get('logout', [HomeController::class, 'logout']);
