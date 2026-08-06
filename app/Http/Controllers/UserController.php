<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function bookings()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with('restaurant')
            ->latest()
            ->paginate(10);

        return view('user.bookings', compact('bookings'));
    }

    public function reviews()
    {
        $reviews = auth()->user()
            ->reviews()
            ->with('restaurant')
            ->latest()
            ->paginate(10);

        return view('user.reviews', compact('reviews'));
    }
}
