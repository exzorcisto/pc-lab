<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\CallbackRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Сводная статистика для дэшборда администратора
     */
    public function getStats()
    {
        return response()->json([
            'orders' => [
                'active'    => Order::whereIn('status', ['new', 'processing'])->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
                'this_month' => Order::whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)->count(),
                'total'     => Order::count(),
            ],
            'services' => [
                'new'         => ServiceRequest::where('status', 'new')->count(),
                'in_progress' => ServiceRequest::where('status', 'in_progress')->count(),
                'resolved'    => ServiceRequest::where('status', 'resolved')->count(),
                'total'       => ServiceRequest::count(),
            ],
            'misc' => [
                'reviews_count'    => Review::count(),
                'callbacks_total'  => CallbackRequest::count(),
                'callbacks_new'    => CallbackRequest::where('status', 'new')->count(),
            ]
        ]);
    }
}