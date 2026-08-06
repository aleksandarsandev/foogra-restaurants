<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use Illuminate\Database\Seeder;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $cuisines = [
            'Italian', 'Japanese', 'American', 'Mexican', 'Chinese',
            'French', 'Indian', 'Thai', 'Mediterranean', 'Greek',
        ];

        foreach ($cuisines as $name) {
            Cuisine::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($name)], ['name' => $name]);
        }
    }
}
