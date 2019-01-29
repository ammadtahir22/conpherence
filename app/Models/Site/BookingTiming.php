<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class BookingTiming extends Model
{
    protected $fillable = [
        'booking_id','day','sitting_plan_id','capacity','addons','start_time', 'end_time', 'special_instruction'
    ];

    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\Site\BookingInfo','booking_id');
    }

}
