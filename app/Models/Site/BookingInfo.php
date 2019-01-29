<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class BookingInfo extends Model
{
    protected $fillable = [
        'user_id','booking_number','venue_id','space_id','hotel_owner_id','booking_firstname',
        'booking_lastname','booking_address','start_date','end_date','no_of_days',
        'purpose','booking_address','start_date','end_date','no_of_days','purpose','grand_total','status','review_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }


    public function space()
    {
        return $this->belongsTo('App\Models\Site\Spaces');
    }

    public function bookingTimings()
    {
        return $this->hasMany('App\Models\Site\BookingTiming','booking_id');
    }

    public function bookingFoods()
    {
        return $this->hasMany('App\Models\Site\BookingFood','booking_id');
    }

    public function bookingPayment()
    {
        return $this->hasMany('App\Models\Site\BookingPayment','booking_id');
    }

    public function review()
    {
        return $this->hasOne('App\Models\Site\Review' , 'booking_id');
    }
}
