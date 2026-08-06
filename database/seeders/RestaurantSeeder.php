<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Da Alfredo',
                'slug' => 'da-alfredo',
                'description' => 'Authentic Italian cuisine in the heart of the city. Family recipes passed down for generations.',
                'address' => '27 Old Gloucester St',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'WC1N 3AX',
                'phone' => '+44 20 1234 5678',
                'email' => 'info@daalfredo.com',
                'price_range' => 2,
                'avg_price' => 35,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['pizza-italian'],
                'cuisines' => ['Italian'],
                'opening_hours' => ['monday' => '11am–10pm', 'tuesday' => '11am–10pm', 'wednesday' => '11am–10pm', 'thursday' => '11am–10pm', 'friday' => '11am–11pm', 'saturday' => '12pm–11pm', 'sunday' => 'Closed'],
            ],
            [
                'name' => 'Best Burgers',
                'slug' => 'best-burgers',
                'description' => 'The city\'s finest craft burgers, made with locally sourced beef and fresh buns.',
                'address' => '42 Baker Street',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'NW1 6XE',
                'phone' => '+44 20 9876 5432',
                'email' => 'hello@bestburgers.com',
                'price_range' => 2,
                'avg_price' => 20,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['burgers'],
                'cuisines' => ['American'],
                'opening_hours' => ['monday' => '12pm–10pm', 'tuesday' => '12pm–10pm', 'wednesday' => '12pm–10pm', 'thursday' => '12pm–10pm', 'friday' => '12pm–11pm', 'saturday' => '11am–11pm', 'sunday' => '11am–10pm'],
            ],
            [
                'name' => 'Vego Life',
                'slug' => 'vego-life',
                'description' => 'Creative vegetarian and vegan cuisine that proves plants can be exciting.',
                'address' => '15 Green Lane',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'E1 6RF',
                'phone' => '+44 20 5555 1234',
                'price_range' => 2,
                'avg_price' => 25,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['vegetarian'],
                'cuisines' => ['Mediterranean'],
                'opening_hours' => ['monday' => '11am–9pm', 'tuesday' => '11am–9pm', 'wednesday' => '11am–9pm', 'thursday' => '11am–9pm', 'friday' => '11am–10pm', 'saturday' => '10am–10pm', 'sunday' => '10am–9pm'],
            ],
            [
                'name' => 'Sushi Temple',
                'slug' => 'sushi-temple',
                'description' => 'Authentic Japanese sushi prepared by master chefs with the finest ingredients.',
                'address' => '88 Marble Arch',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'W1H 7EJ',
                'phone' => '+44 20 7777 8888',
                'price_range' => 3,
                'avg_price' => 55,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['japanese-sushi'],
                'cuisines' => ['Japanese'],
                'opening_hours' => ['monday' => '12pm–10pm', 'tuesday' => '12pm–10pm', 'wednesday' => '12pm–10pm', 'thursday' => '12pm–10pm', 'friday' => '12pm–11pm', 'saturday' => '12pm–11pm', 'sunday' => 'Closed'],
            ],
            [
                'name' => 'Dragon Tower',
                'slug' => 'dragon-tower',
                'description' => 'Authentic Chinese dim sum and traditional dishes from all regions of China.',
                'address' => '22 Hertsmere Rd',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'E14 4ED',
                'phone' => '+44 20 6666 3333',
                'price_range' => 2,
                'avg_price' => 30,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['chinese'],
                'cuisines' => ['Chinese'],
                'opening_hours' => ['monday' => '11am–10pm', 'tuesday' => '11am–10pm', 'wednesday' => '11am–10pm', 'thursday' => '11am–10pm', 'friday' => '11am–11pm', 'saturday' => '10am–11pm', 'sunday' => '10am–10pm'],
            ],
            [
                'name' => 'El Paso Tacos',
                'slug' => 'el-paso-tacos',
                'description' => 'Vibrant Mexican street food and cocktails in a lively atmosphere.',
                'address' => '5 Carnaby Street',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'W1F 9PY',
                'phone' => '+44 20 4444 5555',
                'price_range' => 1,
                'avg_price' => 18,
                'is_featured' => false,
                'status' => 'active',
                'categories' => ['mexican'],
                'cuisines' => ['Mexican'],
                'opening_hours' => ['monday' => '12pm–10pm', 'tuesday' => '12pm–10pm', 'wednesday' => '12pm–10pm', 'thursday' => '12pm–11pm', 'friday' => '12pm–12am', 'saturday' => '11am–12am', 'sunday' => '11am–10pm'],
            ],
            [
                'name' => 'La Monnalisa',
                'slug' => 'la-monnalisa',
                'description' => 'A romantic Italian trattoria offering the finest Tuscan dishes and wines.',
                'address' => '8 Patriot Square',
                'city' => 'London',
                'state' => 'England',
                'zip' => 'E2 9NF',
                'phone' => '+44 20 2222 1111',
                'price_range' => 3,
                'avg_price' => 45,
                'is_featured' => true,
                'status' => 'active',
                'categories' => ['pizza-italian'],
                'cuisines' => ['Italian'],
                'opening_hours' => ['monday' => 'Closed', 'tuesday' => '6pm–11pm', 'wednesday' => '6pm–11pm', 'thursday' => '6pm–11pm', 'friday' => '12pm–11pm', 'saturday' => '12pm–11pm', 'sunday' => '12pm–10pm'],
            ],
            [
                'name' => 'Bella Napoli',
                'slug' => 'bella-napoli',
                'description' => 'Neapolitan pizza at its best — wood-fired oven, fresh mozzarella, San Marzano tomatoes.',
                'address' => '135 Newtownards Road',
                'city' => 'Belfast',
                'state' => 'Northern Ireland',
                'zip' => 'BT4 1AB',
                'phone' => '+44 28 9012 3456',
                'price_range' => 2,
                'avg_price' => 28,
                'is_featured' => false,
                'status' => 'active',
                'categories' => ['pizza-italian'],
                'cuisines' => ['Italian'],
                'opening_hours' => ['monday' => '12pm–10pm', 'tuesday' => '12pm–10pm', 'wednesday' => '12pm–10pm', 'thursday' => '12pm–10pm', 'friday' => '12pm–11pm', 'saturday' => '12pm–11pm', 'sunday' => '1pm–9pm'],
            ],
        ];

        $makeReviewer = fn() => User::create([
            'name'     => fake()->name(),
            'email'    => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $imageMap = [
            'da-alfredo'    => 'img/location_1.jpg',
            'best-burgers'  => 'img/location_2.jpg',
            'vego-life'     => 'img/location_3.jpg',
            'sushi-temple'  => 'img/location_4.jpg',
            'dragon-tower'  => 'img/location_7.jpg',
            'el-paso-tacos' => 'img/location_9.jpg',
            'la-monnalisa'  => 'img/location_5.jpg',
            'bella-napoli'  => 'img/location_6.jpg',
        ];


        foreach ($restaurants as $data) {
            $categories = $data['categories'] ?? [];
            $cuisines   = $data['cuisines'] ?? [];
            unset($data['categories'], $data['cuisines']);

            $restaurant = Restaurant::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['featured_image' => $imageMap[$data['slug']] ?? null])
            );

            // Sync categories
            $catIds = Category::whereIn('slug', $categories)->pluck('id');
            $restaurant->categories()->sync($catIds);

            // Sync cuisines
            $cuiIds = Cuisine::whereIn('name', $cuisines)->pluck('id');
            $restaurant->cuisines()->sync($cuiIds);

            // Add a sample review
            if ($restaurant->reviews()->count() === 0) {
                Review::create([
                    'restaurant_id' => $restaurant->id,
                    'user_id'       => $makeReviewer()->id,
                    'rating'        => rand(70, 95) / 10,
                    'title'         => 'Great experience!',
                    'body'          => 'We had an amazing time at this restaurant. The food was excellent and the service was top notch. Highly recommend!',
                    'status'        => 'approved',
                ]);

                Review::create([
                    'restaurant_id' => $restaurant->id,
                    'user_id'       => $makeReviewer()->id,
                    'rating'        => rand(65, 90) / 10,
                    'title'         => 'Very good food',
                    'body'          => 'The menu offers a great variety of dishes. Everything was fresh and well prepared. Will definitely come back.',
                    'status'        => 'approved',
                ]);

                $restaurant->recalculateRating();
            }
        }
    }
}
