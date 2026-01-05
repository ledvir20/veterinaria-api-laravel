<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DuenoController;
use App\Http\Controllers\Api\HistorialVeterinarioController;
use App\Http\Controllers\Api\MascotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
});


Route::apiResource('duenos', DuenoController::class);
Route::apiResource('mascotas', MascotaController::class);
Route::apiResource('historiales', HistorialVeterinarioController::class);
