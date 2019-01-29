<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    //
    protected $fillable = [
        'name', 'image',
    ];

//    public function spaces()
//    {
//        return $this->belongsToMany('App\Models\Site\Spaces','space_amenity','amenity_id','space_id')->withTimestamps();
//    }

    public function venues()
    {
        return $this->belongsToMany('App\Models\Site\Venue','venue_amenity','amenity_id','venue_id')->withTimestamps();

    }
}
