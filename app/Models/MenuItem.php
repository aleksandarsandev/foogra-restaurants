<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['menu_section_id', 'name', 'description', 'price', 'sort_order'];

    public function section()
    {
        return $this->belongsTo(MenuSection::class, 'menu_section_id');
    }
}
