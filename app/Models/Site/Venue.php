<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','category_id','title','slug','description','cover_image','images','location','latitude','longitude',
        'cancellation_policy','status','food_array','reviews','top_rate','verified'
    ];


    public function company()
    {
        return $this->belongsTo('App\Models\Site\Company');
    }

//    public function venueCategories()
//    {
//        return $this->belongsToMany('App\Models\Admin\Venue_category','venue_venue_category', 'venue_id', 'category_id')->withTimestamps();
//    }
    public function spaces()
    {
        return $this->hasMany('App\Models\Site\Spaces');
    }

    public function spaceCapacities()
    {
        return $this->hasManyThrough('App\Models\Site\SpaceCapacityPlan', 'App\Models\Site\Spaces', 'venue_id','space_id','id','id');
    }

    public function foodDuration()
    {
        return $this->hasMany('App\Models\Site\FoodDuration');
    }

    public function foodCategory()
    {
        return $this->hasMany('App\Models\Site\FoodCategory');
    }

    public function amenities()
    {
        return $this->belongsToMany('App\Models\Site\Amenities','venue_amenity','venue_id','amenity_id')->withTimestamps();
    }

    public function venueAddOns()
    {
        return $this->hasMany('App\Models\Site\VenueAddOns','venue_id');
    }

}

