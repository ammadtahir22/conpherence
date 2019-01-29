<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class FoodDuration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id','food_duration','start_time','start_time'
    ];

    public function venue()
    {
        return $this->belongsTo('App\Models\Site\Venue');
    }

    public function foodCategory()
    {
        return $this->hasMany('App\Models\Site\FoodCategory');
    }
}
