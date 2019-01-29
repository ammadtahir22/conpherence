<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'space_id', 'booking_id' ,'feedback' , 'customer_service_rate' , 'amenities_rate' , 'meeting_facility_rate' , 'food_rate' ,'total_stars', 'r_status'
    ];

    public function space()
    {
        return $this->belongsTo('App\Models\Site\Spaces');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }

    public function bookinginfo()
    {
        return $this->belongsTo('App\Models\Site\BookingInfo' ,'booking_id');
    }

}
