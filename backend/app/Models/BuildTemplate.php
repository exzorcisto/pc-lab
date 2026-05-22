<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildTemplate extends Model
{
    // Укажи разрешенные поля (зависит от твоей таблицы)
    protected $fillable = ['name', 'category', 'description', 'image_url', 'is_active'];

    // Связь с компонентами шаблона
    public function items()
    {
        return $this->hasMany(BuildTemplateItem::class, 'template_id');
    }
}