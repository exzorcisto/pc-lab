<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /**
     * Поля, доступные для массового заполнения.
     */
    protected $fillable = [
        'user_id', 
        'order_id', 
        'rating', 
        'text', 
        'status', 
        'admin_comment'
    ];

    /**
     * Доступные статусы отзыва (для удобства в коде).
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    const STATUS_REJECTED = 'rejected';

    /**
     * Scope для получения только опубликованных отзывов.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Связь с пользователем.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с заказом.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}