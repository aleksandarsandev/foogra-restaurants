<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pizza - Italian',  'slug' => 'pizza-italian',  'icon' => 'icon-food_icon_pizza',      'avg_price' => '$40', 'sort_order' => 1],
            ['name' => 'Japanese - Sushi', 'slug' => 'japanese-sushi', 'icon' => 'icon-food_icon_sushi',      'avg_price' => '$50', 'sort_order' => 2],
            ['name' => 'Burgers',          'slug' => 'burgers',        'icon' => 'icon-food_icon_burgher',    'avg_price' => '$25', 'sort_order' => 3],
            ['name' => 'Vegetarian',       'slug' => 'vegetarian',     'icon' => 'icon-food_icon_vegetarian', 'avg_price' => '$30', 'sort_order' => 4],
            ['name' => 'Bakery',           'slug' => 'bakery',         'icon' => 'icon-food_icon_cake_2',     'avg_price' => '$20', 'sort_order' => 5],
            ['name' => 'Chinese',          'slug' => 'chinese',        'icon' => 'icon-food_icon_chinese',    'avg_price' => '$35', 'sort_order' => 6],
            ['name' => 'Mexican',          'slug' => 'mexican',        'icon' => 'icon-food_icon_burrito',    'avg_price' => '$30', 'sort_order' => 7],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
