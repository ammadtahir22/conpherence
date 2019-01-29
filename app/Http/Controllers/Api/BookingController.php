<?php

namespace App\Http\Controllers\Api;

use App\Traits\BookingTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    use BookingTrait;

    public function save(Request $request)
    {
        return $this->create_booking($request);
    }

    public function update_status(Request $request)
    {
        return $this->booking_status($request);
    }

    public function user_booking_index()
    {
        return $this->booking_index_user();
    }

    public function user_booking_detail($booking_id)
    {
        return $this->booking_detail_user($booking_id);
    }

    public function hotel_booking_index()
    {
        return $this->booking_index_hotel();
    }

    public function hotel_booking_detail($booking_id)
    {
        return $this->booking_detail_hotel($booking_id);
    }
}
