<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'category_id', 'name', 'price', 'image_url', 'socket', 
        'ram_type', 'tdp', 'form_factor', 'specifications', 
        'performance_index', 'is_available'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}