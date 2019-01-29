<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id','food_duration_id','title','currency',
    ];

    public function venue()
    {
        return $this->belongsTo('App\Models\Site\Venue');
    }

    public function bookingFood()
    {
        return $this->hasOne('App\Models\Site\BookingFood', 'food_categories_id');
    }

    public function foodDuration()
    {
        return $this->belongsTo('App\Models\Site\FoodDuration');
    }

    public function foods()
    {
        return $this->hasMany('App\Models\Site\Food', 'category_id');
    }
}
