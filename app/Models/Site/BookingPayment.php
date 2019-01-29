<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected $fillable = [
        'booking_id','day','total_day_payment',
    ];

    public function bookingInfo()
    {
        return $this->belongsTo('App\Models\Site\BookingInfo');
    }
}
