<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'total_price', 
        'delivery_type', 
        'address', 
        'user_comment', 
        'admin_comment', 
        'status',
        'payment_status' // Добавь это
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}