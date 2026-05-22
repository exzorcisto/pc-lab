<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\BuildController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Каталог компонентов (открыт для всех)
Route::get('/components', [ComponentController::class, 'index']);
Route::get('/components/{id}', [ComponentController::class, 'show']);

// Посмотреть сборку по хэшу (публично)
Route::get('/builds/{hash}', [BuildController::class, 'show']);

// Маршрут для "оплаты" (симуляция)
Route::post('/orders/{id}/pay', [OrderController::class, 'pay']); 

// Защищенные маршруты (только с токеном)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Сборки (Builds)
    Route::get('/builds', [BuildController::class, 'index']);      // Мои сборки
    Route::post('/builds', [BuildController::class, 'store']);     // Создать кастомную сборку
    Route::put('/builds/{id}', [BuildController::class, 'update']);
    
    // НОВЫЙ МАРШРУТ: Копирование шаблона (TITAN/CORE) в личные сборки
    Route::post('/builds/template/{templateId}', [BuildController::class, 'storeFromTemplate']);

    // Заказы (Orders) - пользователь
    Route::get('/orders', [OrderController::class, 'index']);      // Моя история заказов
    Route::post('/orders', [OrderController::class, 'store']);     // Оформить заказ
    
    // Админка (PC Labs Management)
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);          // Все заказы
    Route::put('/admin/orders/{id}', [OrderController::class, 'adminUpdate']);   // Редактировать заказ
});