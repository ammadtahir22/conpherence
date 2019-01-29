<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class VenueAddOns extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id','amenity_id','price',
    ];

    public function venue()
    {
        return $this->belongsTo('App\Models\Site\Venue', 'venue_id');
    }
}
