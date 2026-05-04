<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\BuildController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Эти маршруты открыты для всех (даже без токена), чтобы пользователи видели каталог
Route::get('/components', [ComponentController::class, 'index']);
Route::get('/components/{id}', [ComponentController::class, 'show']);

// Сохранить сборку (может быть как авторизованный, так и гость)
Route::post('/builds', [BuildController::class, 'store'])->middleware('auth:sanctum');
// Посмотреть сборку по хэшу (публично)
Route::get('/builds/{hash}', [BuildController::class, 'show']);

// Защищенные маршруты (только с токеном)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Сюда позже добавим оформление заказов и админку компонентов
});