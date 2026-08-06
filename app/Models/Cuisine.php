<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cuisine extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Cuisine $cuisine) {
            if (empty($cuisine->slug)) {
                $cuisine->slug = Str::slug($cuisine->name);
            }
        });
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_cuisine');
    }
}
