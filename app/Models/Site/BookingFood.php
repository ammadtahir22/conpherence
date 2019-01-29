<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class BookingFood extends Model
{
    protected $fillable = [
        'booking_id', 'day', 'food_categories_id',
    ];

    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\Site\BookingInfo');
    }

    public function foodCategory()
    {
        return $this->belongsTo('App\Models\Site\FoodCategory', 'food_categories_id');
    }
}
