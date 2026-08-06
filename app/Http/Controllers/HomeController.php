<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::has('restaurants')->orderBy('sort_order')->get();
        $featured = Restaurant::where('status', 'active')
            ->where('is_featured', true)
            ->with(['categories'])
            ->orderByDesc('avg_rating')
            ->take(7)
            ->get();
        $popular = Restaurant::where('status', 'active')
            ->with(['categories'])
            ->orderByDesc('avg_rating')
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featured', 'popular'));
    }
}
