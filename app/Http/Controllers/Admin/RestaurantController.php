<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\SavesMenu;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    use SavesMenu;
    public function index(Request $request)
    {
        $query = Restaurant::with(['categories', 'cuisines'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $restaurants = $query->paginate(15)->withQueryString();

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $cuisines   = Cuisine::orderBy('name')->get();

        return view('admin.restaurants.create', compact('categories', 'cuisines'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRestaurant($request);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create([
            ...$data,
            'slug'        => Str::slug($data['name']),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        $restaurant->categories()->sync($request->input('categories', []));
        $restaurant->cuisines()->sync($request->input('cuisines', []));
        $this->saveMenu($restaurant, $request->input('menu', []));

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant created successfully.');
    }

    public function edit(Restaurant $restaurant)
    {
        $restaurant->load('menuSections.items');
        $categories = Category::orderBy('sort_order')->get();
        $cuisines   = Cuisine::orderBy('name')->get();

        return view('admin.restaurants.edit', compact('restaurant', 'categories', 'cuisines'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $this->validateRestaurant($request, $restaurant->id);

        if ($request->hasFile('featured_image')) {
            if ($restaurant->featured_image) {
                Storage::disk('public')->delete($restaurant->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('restaurants', 'public');
        }

        $restaurant->update(array_merge($data, ['is_featured' => $request->boolean('is_featured')]));
        $restaurant->categories()->sync($request->input('categories', []));
        $restaurant->cuisines()->sync($request->input('cuisines', []));
        $this->saveMenu($restaurant, $request->input('menu', []));

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant updated successfully.');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->featured_image) {
            Storage::disk('public')->delete($restaurant->featured_image);
        }
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant deleted.');
    }

    private function validateRestaurant(Request $request, ?int $exceptId = null): array
    {
        return $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'zip'           => 'nullable|string|max:20',
            'phone'         => 'nullable|string|max:30',
            'email'         => 'nullable|email',
            'website'       => 'nullable|url',
            'price_range'   => 'required|integer|between:1,4',
            'avg_price'     => 'nullable|integer',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'featured_image'=> 'nullable|image|max:2048',
            'is_featured'   => 'boolean',
            'status'        => 'required|in:active,pending,inactive',
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
            'cuisines'      => 'nullable|array',
            'cuisines.*'    => 'exists:cuisines,id',
        ]);
    }
}
