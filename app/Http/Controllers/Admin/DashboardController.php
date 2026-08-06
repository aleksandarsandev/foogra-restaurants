<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'restaurants' => Restaurant::count(),
            'bookings'    => Booking::where('status', 'pending')->count(),
            'reviews'     => Review::where('status', 'pending')->count(),
            'active'      => Restaurant::where('status', 'active')->count(),
        ];

        $recentBookings = Booking::with('restaurant')->latest()->take(5)->get();
        $recentReviews  = Review::with(['restaurant', 'user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentReviews'));
    }
}
