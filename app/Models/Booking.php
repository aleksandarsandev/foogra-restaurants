<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'restaurant_id', 'user_id', 'name', 'email', 'phone',
        'booking_date', 'booking_time', 'guests', 'status', 'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
