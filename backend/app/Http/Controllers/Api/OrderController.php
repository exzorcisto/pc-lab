<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SavedBuild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Список заказов текущего пользователя.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.build.items.component'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    /**
     * Оформление заказа (Корзина).
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:saved_builds,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_type' => 'required|in:pickup,delivery',
            'user_comment' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => 0, 
                'delivery_type' => $request->delivery_type,
                'user_comment' => $request->user_comment,
                'status' => 'new',
                'payment_status' => 'pending',
                'address' => null, 
            ]);

            $totalPrice = 0;

            foreach ($request->items as $itemData) {
                $build = SavedBuild::findOrFail($itemData['id']);

                if ($build->user_id !== Auth::id()) {
                    throw new \Exception("Сборка ID {$build->id} вам не принадлежит.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'saved_build_id' => $build->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $build->total_price,
                ]);

                $totalPrice += $build->total_price * $itemData['quantity'];
            }

            $order->update(['total_price' => $totalPrice]);

            // Генерация фейковой ссылки на СБП для фронтенда
            $paymentUrl = url("/pay/sbp/{$order->id}?amount={$totalPrice}");

            return response()->json([
                'status' => 'success',
                'message' => 'Заказ успешно сформирован',
                'order_id' => $order->id,
                'total_sum' => $totalPrice,
                'payment_url' => $paymentUrl
            ], 201);
        });
    }

    /**
     * Симуляция подтверждения оплаты.
     */
    public function pay($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Заказ уже оплачен'], 400);
        }

        $order->update(['payment_status' => 'paid']);

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Оплата подтверждена']);
        }

        // Редирект на фронтенд (React) после "оплаты"
        return redirect('http://localhost:3000/profile?payment=success');
    }

    /**
     * [ADMIN] Обновление данных заказа менеджером.
     */
    public function adminUpdate(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled',
            'payment_status' => 'in:pending,paid,failed,refunded',
            'address' => 'nullable|string|max:500',
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Данные заказа обновлены',
            'order' => $order
        ]);
    }

    public function allOrders()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }
}