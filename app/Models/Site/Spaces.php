<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Spaces extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id','user_id','slug','description','price','title','image' ,'reviews_count','reviews_total','top_rate','verified'
    ];

    public function spaceTypes()
    {
        return $this->belongsToMany('App\Models\Admin\SpacesType','spaces_spaces_types', 'space_id', 'space_type_id')->withTimestamps();
    }

    public function venue()
    {
        return $this->belongsTo('App\Models\Site\Venue');
    }

    public function sittingPlans()
    {
        return $this->belongsToMany('App\Models\Site\SittingPlan','space_sitting_plan','space_id','sitting_plan_id')->withTimestamps();
    }

    public function spaceCapacityPlan()
    {
        return $this->hasMany('App\Models\Site\SpaceCapacityPlan', 'space_id');
    }

//    public function amenities()
//    {
//        return $this->belongsToMany('App\Models\Site\Amenities','space_amenity','space_id','amenity_id')->withTimestamps();
//    }
    
    public function accessibilities()
    {
        return $this->belongsToMany('App\Models\Site\Accessibility','space_accessibility','space_id','accessibility_id')->withTimestamps();
    }

    public function bookingInfo()
    {
        return $this->hasMany('App\Models\Site\BookingInfo', 'space_id');
    }

    public function reviews(){
        return $this->hasMany('App\Models\Site\Review' , 'space_id');
    }
}
