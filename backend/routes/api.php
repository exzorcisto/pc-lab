<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\BuildController;
use App\Http\Controllers\Api\OrderController;
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

// временно
Route::post('/orders/{id}/pay', [OrderController::class, 'pay']); // Маршрут для оплаты

// Защищенные маршруты (только с токеном)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/builds', [BuildController::class, 'index']); // Посмотреть мои сборки
    Route::post('/builds', [BuildController::class, 'store']);
    
    // Маршруты для обычного пользователя
    Route::get('/orders', [OrderController::class, 'index']);      // История заказов
    Route::post('/orders', [OrderController::class, 'store']);     // Создать заказ
    Route::get('/orders/{id}', [OrderController::class, 'show']);  // Детали заказа
    // Route::post('/orders/{id}/pay', [OrderController::class, 'pay']); // Маршрут для оплаты

    // Маршруты для Админа (PC Labs Management)
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);          // Все заказы в системе
    Route::put('/admin/orders/{id}', [OrderController::class, 'adminUpdate']);   // Редактировать заказ (статус, адрес)

    // Сюда позже добавим оформление заказов и админку компонентов
});