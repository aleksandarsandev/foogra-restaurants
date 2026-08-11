<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\SavesMenu;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantSubmissionController extends Controller
{
    use SavesMenu;
    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $cuisines   = Cuisine::orderBy('name')->get();

        return view('restaurants.submit', compact('categories', 'cuisines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_name'=> 'required|string|max:255',
            'description'    => 'required|string',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'zip'            => 'required|string|max:20',
            'phone'          => 'required|string|max:30',
            'website'        => 'nullable|url',
            'price_range'    => 'required|integer|between:1,4',
            'avg_price'      => 'nullable|integer',
            'featured_image' => 'required|image|max:2048',
            'categories'     => 'required|array|min:1',
            'categories.*'   => 'exists:categories,id',
            'cuisines'       => 'required|array|min:1',
            'cuisines.*'     => 'exists:cuisines,id',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('restaurants', 's3');
        }

        $restaurant = Restaurant::create([
            ...$data,
            'name'    => $data['restaurant_name'],
            'slug'    => Str::slug($data['restaurant_name']),
            'email'   => auth()->user()->email,
            'status'  => 'pending',
            'user_id' => auth()->id(),
        ]);

        $restaurant->categories()->sync($request->input('categories', []));
        $restaurant->cuisines()->sync($request->input('cuisines', []));
        $this->saveMenu($restaurant, $request->input('menu', []));

        return redirect()->route('user.restaurants')
            ->with('success', 'Your restaurant has been submitted and is pending approval.');
    }

    public function edit(Restaurant $restaurant)
    {
        abort_if($restaurant->user_id !== auth()->id(), 403);

        $restaurant->load('menuSections.items');
        $categories = Category::orderBy('sort_order')->get();
        $cuisines   = Cuisine::orderBy('name')->get();

        return view('user.restaurant-edit', compact('restaurant', 'categories', 'cuisines'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        abort_if($restaurant->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'zip'           => 'required|string|max:20',
            'phone'         => 'required|string|max:30',
            'website'       => 'nullable|url',
            'price_range'   => 'required|integer|between:1,4',
            'avg_price'     => 'nullable|integer',
            'featured_image'=> 'nullable|image|max:2048',
            'categories'    => 'required|array|min:1',
            'categories.*'  => 'exists:categories,id',
            'cuisines'      => 'required|array|min:1',
            'cuisines.*'    => 'exists:cuisines,id',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($restaurant->featured_image && !str_starts_with($restaurant->featured_image, 'img/')) {
                Storage::disk('s3')->delete($restaurant->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('restaurants', 's3');
        }

        $restaurant->update($data);
        $restaurant->categories()->sync($request->input('categories', []));
        $restaurant->cuisines()->sync($request->input('cuisines', []));
        $this->saveMenu($restaurant, $request->input('menu', []));

        return redirect()->route('user.restaurants')
            ->with('success', 'Restaurant updated successfully.');
    }

    public function index()
    {
        $restaurants = auth()->user()
            ->restaurants()
            ->with(['categories'])
            ->latest()
            ->paginate(10);

        return view('user.restaurants', compact('restaurants'));
    }
}
