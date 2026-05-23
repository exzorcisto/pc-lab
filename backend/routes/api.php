<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\BuildController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RequestController;
use Illuminate\Support\Facades\Route;

// --- Публичные маршруты ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/components', [ComponentController::class, 'index']);
Route::get('/components/{id}', [ComponentController::class, 'show']);
Route::get('/builds/{hash}', [BuildController::class, 'show']);
Route::post('/orders/{id}/pay', [OrderController::class, 'pay']); 

Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/requests/callback', [RequestController::class, 'storeCallback']);

// --- Защищенные маршруты ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/my-reviews', [ReviewController::class, 'myReviews']);

    Route::get('/builds', [BuildController::class, 'index']);
    Route::post('/builds', [BuildController::class, 'store']);
    Route::put('/builds/{id}', [BuildController::class, 'update']);
    Route::post('/builds/template/{templateId}', [BuildController::class, 'storeFromTemplate']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    
    Route::post('/requests/service', [RequestController::class, 'storeService']);
    
    // Админка
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);
    Route::put('/admin/orders/{id}', [OrderController::class, 'adminUpdate']);
    
    Route::put('/admin/reviews/{id}/status', [ReviewController::class, 'updateStatus']);

    // Админка заявок
    Route::get('/admin/requests/service', [RequestController::class, 'indexService']);
    Route::put('/admin/requests/service/{id}', [RequestController::class, 'updateService']);
    
    Route::get('/admin/requests/callback', [RequestController::class, 'indexCallback']);
    Route::put('/admin/requests/callback/{id}', [RequestController::class, 'updateCallbackStatus']);
});