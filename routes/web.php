<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register/create', [AuthController::class, 'register']);
Route::post('/login/create', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/panel', [PanelController::class, 'index'])->middleware('auth');

Route::get('/board/', [BoardController::class, 'find'])->middleware('auth');
Route::post('/board', [BoardController::class, 'create'])->middleware('auth');
Route::put('/board/move', [BoardController::class, 'move']);
Route::put('/board/{board}', [BoardController::class, 'update']);
Route::delete('/board/{board}', [BoardController::class, 'delete']);
Route::post('/boards/organize', [BoardController::class, 'organizeBoardTasks']);

Route::post('/task', [TaskController::class, 'create']);
Route::get('/task', [TaskController::class, 'get']);
Route::delete('/task/{task}', [TaskController::class, 'delete']);
