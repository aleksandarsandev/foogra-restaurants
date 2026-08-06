<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'nullable|string|max:30',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'guests'       => 'required|integer|min:1|max:20',
            'notes'        => 'nullable|string|max:500',
        ]);

        $booking = $restaurant->bookings()->create([
            ...$data,
            'user_id' => auth()->id(),
            'status'  => 'pending',
        ]);

        return redirect()->route('restaurants.show', $slug)
            ->with('success', "Booking confirmed! We'll contact you at {$data['email']}.");
    }
}
