<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedBuild extends Model
{
    protected $fillable = ['user_id', 'share_hash', 'total_price'];

    public function items()
    {
        return $this->hasMany(SavedBuildItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}