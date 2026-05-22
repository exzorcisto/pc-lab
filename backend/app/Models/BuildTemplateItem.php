<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildTemplateItem extends Model
{
    // Отключаем timestamps, если в миграции их нет
    public $timestamps = false;
    
    protected $fillable = ['template_id', 'component_id', 'quantity'];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function template()
    {
        return $this->belongsTo(BuildTemplate::class, 'template_id');
    }
}