<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['restaurant_id', 'user_id', 'rating', 'title', 'body', 'status'];

    protected $casts = [
        'rating' => 'float',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Review $review) {
            $review->restaurant->recalculateRating();
        });

        static::deleted(function (Review $review) {
            $review->restaurant->recalculateRating();
        });
    }
}
