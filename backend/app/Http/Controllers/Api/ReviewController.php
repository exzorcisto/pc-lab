<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Публичный список: только опубликованные отзывы.
     */
    public function index()
    {
        return Review::published()
            ->with('user:id,name')
            ->latest()
            ->get();
    }

    /**
     * Отзывы текущего пользователя (все статусы).
     */
    public function myReviews()
    {
        return Review::where('user_id', auth()->id())
            ->with('order:id')
            ->latest()
            ->get();
    }

    /**
     * Создание отзыва пользователем.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|max:1000',
        ]);

        // Проверка: можно ли оставить отзыв на этот заказ
        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Проверка: был ли уже отзыв
        if (Review::where('order_id', $order->id)->exists()) {
            return response()->json(['message' => 'Отзыв на этот заказ уже оставлен'], 422);
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'text' => $request->text,
            'status' => Review::STATUS_PENDING,
        ]);

        return response()->json(['message' => 'Отзыв отправлен на модерацию', 'review' => $review], 201);
    }

    /**
     * Админ: одобрение или отклонение отзыва.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:published,rejected',
            'admin_comment' => 'nullable|string|max:500',
        ]);

        $review = Review::findOrFail($id);
        
        $review->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
        ]);

        return response()->json(['message' => "Отзыв теперь {$review->status}"]);
    }
}