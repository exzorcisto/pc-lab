<?php

use App\Models\Order;
use Illuminate\Http\Request;

Route::get('/pay/sbp/{id}', function (Request $request, $id) {
    $order = Order::findOrFail($id);
    return view('payment.sbp', [
        'order' => $order,
        'amount' => $request->query('amount')
    ]);
}); 