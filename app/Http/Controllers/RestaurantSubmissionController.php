<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantSubmissionController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $cuisines   = Cuisine::orderBy('name')->get();

        return view('restaurants.submit', compact('categories', 'cuisines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'zip'           => 'required|string|max:20',
            'phone'         => 'required|string|max:30',
            'email'         => 'nullable|email',
            'website'       => 'nullable|url',
            'price_range'   => 'required|integer|between:1,4',
            'avg_price'     => 'nullable|integer',
            'featured_image'=> 'required|image|max:2048',
            'categories'    => 'required|array|min:1',
            'categories.*'  => 'exists:categories,id',
            'cuisines'      => 'required|array|min:1',
            'cuisines.*'    => 'exists:cuisines,id',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create([
            ...$data,
            'slug'    => Str::slug($data['name']),
            'email'   => auth()->user()->email,
            'status'  => 'pending',
            'user_id' => auth()->id(),
        ]);

        $restaurant->categories()->sync($request->input('categories', []));
        $restaurant->cuisines()->sync($request->input('cuisines', []));

        return redirect()->route('user.restaurants')
            ->with('success', 'Your restaurant has been submitted and is pending approval.');
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
