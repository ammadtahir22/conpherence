<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Site\BookingInfo;
use App\Models\Site\BookingTiming;
use App\Models\Site\Company;
use App\Models\Site\Spaces;
use App\Models\Site\User;
use App\Models\Site\Venue;
use App\Traits\BookingTrait;
use Illuminate\Http\Request;



class BookingController extends Controller
{
    use BookingTrait;
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function booking_index()
    {

        $booking_infos = BookingInfo::all();


        return view('admin-panel.bookings.bookings', compact('booking_infos'));
    }

    public function bookings_detail($bookings_id){

        //  $user = Auth::user();
        $booking_infos = BookingInfo::where('id', $bookings_id)->first();
        $user = User::where('id',$booking_infos->user_id)->first();
        $payment_per_day = $booking_infos->bookingPayment;
        $payment_per_day = $booking_infos->bookingPayment;
        $sitting_plan = $booking_infos->bookingTimings;
        $foods =  $booking_infos->bookingFoods;
       //   dd($payment_per_day);


        return view('admin-panel.bookings.booking-detail',compact('booking_infos','payment_per_day','sitting_plan','foods','user'));
    }

    public function manual_booking_detail($booking_id){
        $booking = BookingInfo::find($booking_id);
        $booking_times = BookingTiming::select('start_time', 'end_time')->where('booking_id', $booking->id)->get()->toArray();
      //  dd($booking);
        $user_id = $booking->hotel_owner_id;
        $company = Company::where('user_id', $booking->hotel_owner_id)->first();
     //   dd($company);
        $venues = Venue::select('id', 'city','location')->where('company_id', $company->id)->get();
        $spaces = Spaces::select('id', 'title')->where('venue_id', $booking->venue_id)->get();
        // dd($venues);
        return view('admin-panel.bookings.manual_booking_detail', compact('venues','booking','spaces','booking_times'));
    }

    public function update_status(Request $request)
    {
       // dd($request);
        $response = $this->booking_status($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Booking Status Changed Successfully');
        }

        return redirect(route('all.booking'));


    }


}
