<?php

namespace App\Models;
use App\Models\BuildTemplate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SavedBuild extends Model
{
    // Добавили 'name' и 'template_id'
    protected $fillable = ['user_id', 'name', 'template_id', 'share_hash', 'total_price'];

    // Добавляем is_modified в массив, чтобы он автоматически появлялся в JSON-ответах
    protected $appends = ['is_modified'];

    public function items()
    {
        return $this->hasMany(SavedBuildItem::class, 'saved_build_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с шаблоном
    public function template()
    {
        return $this->belongsTo(BuildTemplate::class, 'template_id');
    }

    // Логика проверки: была ли сборка изменена относительно шаблона
    public function getIsModifiedAttribute()
    {
        // Если у сборки нет шаблона, значит это чистый кастом -> не изменена
        if (!$this->template_id) return false;

        // Получаем ID компонентов из шаблона (сортируем, чтобы сравнить наборы)
        $templateItems = DB::table('build_template_items')
            ->where('template_id', $this->template_id)
            ->pluck('component_id')
            ->sort()
            ->values();

        // Получаем ID компонентов из текущей сохраненной сборки
        $currentItems = $this->items()
            ->pluck('component_id')
            ->sort()
            ->values();

        // Если наборы ID отличаются — возвращаем true
        return $templateItems != $currentItems;
    }
}