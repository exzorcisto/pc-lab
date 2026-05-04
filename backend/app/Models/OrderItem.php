<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false; // В этой таблице они обычно не нужны
    protected $fillable = ['order_id', 'component_id', 'component_name', 'quantity', 'price_at_purchase'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}