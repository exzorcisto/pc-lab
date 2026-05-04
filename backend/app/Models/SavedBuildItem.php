<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedBuildItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['saved_build_id', 'component_id', 'quantity'];

    public function build()
    {
        return $this->belongsTo(SavedBuild::class, 'saved_build_id');
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}