<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::with(['categories', 'cuisines'])
            ->where('status', 'active');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $categories = (array) $request->category;
            $query->whereHas('categories', fn($b) => $b->whereIn('slug', $categories));
        }

        if ($request->filled('cuisine')) {
            $cuisines = (array) $request->cuisine;
            $query->whereHas('cuisines', fn($b) => $b->whereIn('slug', $cuisines));
        }

        if ($request->filled('price')) {
            $query->whereIn('price_range', (array) $request->price);
        }

        if ($request->filled('rating')) {
            $query->where('avg_rating', '>=', min((array) $request->rating));
        }

        $sort = $request->get('sort', 'rating');
        match ($sort) {
            'rating'    => $query->orderByDesc('avg_rating'),
            'price_asc' => $query->orderBy('avg_price'),
            'price_desc'=> $query->orderByDesc('avg_price'),
            'newest'    => $query->orderByDesc('created_at'),
            default     => $query->orderByDesc('review_count'),
        };

        $restaurants = $query->paginate(12)->withQueryString();
        $categories  = Category::has('restaurants')->orderBy('sort_order')->get();
        $cuisines    = Cuisine::orderBy('name')->get();

        return view('restaurants.index', compact('restaurants', 'categories', 'cuisines'));
    }

    public function show(string $slug)
    {
        $query = Restaurant::where('slug', $slug)
            ->with(['categories', 'cuisines', 'images', 'approvedReviews.user']);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('status', 'active');
        }

        $restaurant = $query->firstOrFail();

        $userReview = auth()->check()
            ? $restaurant->reviews()->where('user_id', auth()->id())->first()
            : null;

        $hasBooking = auth()->check()
            ? $restaurant->bookings()->where('user_id', auth()->id())->where('status', 'confirmed')->exists()
            : false;

        return view('restaurants.show', compact('restaurant', 'userReview', 'hasBooking'));
    }
}
