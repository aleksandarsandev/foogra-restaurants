<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'address', 'city', 'state', 'zip',
        'phone', 'email', 'website', 'price_range', 'avg_price',
        'latitude', 'longitude', 'opening_hours', 'featured_image',
        'is_featured', 'status', 'avg_rating', 'review_count', 'user_id',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'is_featured' => 'boolean',
        'avg_rating' => 'float',
    ];

    protected static function booted(): void
    {
        static::creating(function (Restaurant $restaurant) {
            if (empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'restaurant_category');
    }

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'restaurant_cuisine');
    }

    public function images()
    {
        return $this->hasMany(RestaurantImage::class)->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPriceSymbolAttribute(): string
    {
        return str_repeat('$', $this->price_range);
    }

    public function getRatingLabelAttribute(): string
    {
        if ($this->avg_rating >= 9) return 'Superb';
        if ($this->avg_rating >= 8) return 'Very Good';
        if ($this->avg_rating >= 7) return 'Good';
        if ($this->avg_rating >= 6) return 'Pleasant';
        return 'Rated';
    }

    public function recalculateRating(): void
    {
        $avg = $this->approvedReviews()->avg('rating') ?? 0;
        $count = $this->approvedReviews()->count();
        $this->update(['avg_rating' => round($avg, 1), 'review_count' => $count]);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            // public img/ path (template images used in seeder)
            if (str_starts_with($this->featured_image, 'img/')) {
                return asset($this->featured_image);
            }
            // uploaded file stored in storage
            return asset('storage/' . $this->featured_image);
        }
        // fallback: cycle through template images
        $index = ($this->id % 12) ?: 12;
        return asset("img/location_{$index}.jpg");
    }
}
