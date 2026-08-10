<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSection extends Model
{
    protected $fillable = ['restaurant_id', 'name', 'sort_order'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }
}
