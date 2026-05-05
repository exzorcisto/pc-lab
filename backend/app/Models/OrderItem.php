<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'saved_build_id',
        'quantity',
        'price'
    ];

    /**
     * Связь с заказом.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Связь со сборкой.
     */
    public function build()
    {
        return $this->belongsTo(SavedBuild::class, 'saved_build_id');
    }
}