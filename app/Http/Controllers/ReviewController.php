<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->where('status', 'active')->firstOrFail();

        if (!$restaurant->bookings()->where('user_id', auth()->id())->where('status', 'confirmed')->exists()) {
            return back()->with('error', 'You can only review restaurants you have booked.');
        }

        if ($restaurant->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already reviewed this restaurant.');
        }

        $data = $request->validate([
            'rating' => 'required|numeric|min:1|max:10',
            'title'  => 'nullable|string|max:255',
            'body'   => 'required|string|min:20',
        ]);

        $restaurant->reviews()->create([
            ...$data,
            'user_id' => auth()->id(),
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted for moderation.');
    }

    public function update(Request $request, string $slug, Review $review)
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'rating' => 'required|numeric|min:1|max:10',
            'title'  => 'nullable|string|max:255',
            'body'   => 'required|string|min:20',
        ]);

        $review->update($data);

        return back()->with('success', 'Your review has been updated.');
    }

    public function destroy(string $slug, Review $review)
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $review->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
}
