<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register/create', [AuthController::class, 'register']);
Route::post('/login/create', [AuthController::class, 'login']);

Route::get('/panel', [PanelController::class, 'index'])->middleware('auth');
