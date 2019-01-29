<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use App\Models\Admin\SpacesType;
use App\Models\Site\BookingFood;
use App\Models\Site\BookingPayment;
use App\Models\Site\BookingTiming;
use App\Models\Site\SpaceCapacityPlan;
use App\Models\Site\BookingInfo;
use App\Notifications\ApproveBooking;
use App\Notifications\CancelBooking;
use App\Notifications\NewBooking;
use App\Notifications\NewHotelOwnerBooking;
use App\Notifications\ReminderBooking;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Site\Spaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait BookingTrait
{
    protected function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;
        return response()->json($response);
    }


    public function  create_booking(Request $request)
    {
//        dd($request);

//        $already_booked = 0;
//        // Search for a venue based on booking date.
//        if($request->input('startdate') != null) {
//            $start_date = Carbon::parse($request->input('startdate'));
//            $end_date = Carbon::parse($request->input('startdate'));
//            if($request->input('enddate') != null){
//
//                $end_date = Carbon::parse($request->input('enddate'));
//            }
//            $range = [$start_date, $end_date];
//
//            $bookings = BookingInfo::orwhereRaw('? between start_date and end_date', [$start_date])
//                ->orWhereRaw('? between start_date and end_date', [$end_date])
//                ->orWhereBetween('end_date', [$range])
//                ->orWhereBetween('start_date', [$range])
//                ->orwhere('start_date', $start_date)
//                ->orwhere('end_date', $end_date)
//                ->get();
//
//            if(count($bookings) > 0)
//            {
//                foreach ($bookings as $booking)
//                {
//                    if($booking->status == 1)
//                    {
//                        $search_days_arr = [];
//                        $search_days = ($start_date->diffInDays($end_date))+1;
//                        for ($i=0; $i<$search_days; $i++)
//                        {
//                            $search_days_arr[] = date('Y-m-d', strtotime($start_date. '+'.$i.'day'));
//                        }
//
//                        $booking_start_day = Carbon::parse($booking->start_date);
//                        $booking_end_day = Carbon::parse($booking->end_date);
//
//                        $booking_days_arr = [];
//                        $booking_days = $booking_start_day->diffInDays($booking_end_day)+1;
//                        for ($i=0; $i<$booking_days; $i++)
//                        {
//                            $booking_days_arr[] = date('Y-m-d', strtotime($booking_start_day. '+'.$i.'day'));
//                        }
//
//                        if (count(array_intersect($search_days_arr, $booking_days_arr)) === 0) {
//                            // No values from $search_days_arr are in $booking_days_arr
//                            continue;
//                        } else {
//                            // There is at least one value from $search_days_arr present in $booking_days_arr
//                            $bookingTimings = $booking->bookingTimings;
//
//                            foreach ($booking_days_arr as $key=>$booking_day)
//                            {
//                                $check_start_time = date("H:i:s", strtotime($request->input('stime'.($key+1)).':'.'00'));
//                                $check_end_time = date("H:i:s", strtotime($request->input('etime'.($key+1)).':'.'00'));
//                                $start_timestamp = date("H:i:s", strtotime($bookingTimings[$key]->start_time));
//                                $end_timestamp = date("H:i:s", strtotime($bookingTimings[$key]->end_time));
//
//                                if(check_date_is_within_range($start_timestamp, $end_timestamp, $check_start_time) && check_date_is_within_range($start_timestamp, $end_timestamp, $check_end_time))
//                                {
//                                    $already_booked++;
////                                    dd('in');
//                                } else {
//                                    continue;
////                                    dd('out');
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }


        $space = Spaces::find($request->input('space_id'));
        $hotel_owner = $space->venue->company->user;

        $booking = new BookingInfo();
        $booking->booking_number = generate_booking_number();
        $booking->user_id = $request->input('user_id');
        $booking->venue_id = $request->input('venue_id');
        $booking->space_id = $request->input('space_id');
        $booking->hotel_owner_id = $hotel_owner->id;
        $booking->booking_firstname = $request->input('firstname');
        $booking->booking_lastname = $request->input('lastname');
        $booking->booking_email = $request->input('email');
        $booking->booking_phone = $request->input('phone');
        $booking->booking_address = $request->input('address');
        $booking->start_date = $request->input('startdate');
        $booking->end_date = $request->input('enddate');
        $booking->no_of_days = $request->input('total_days');
        $booking->purpose = $request->input('purpose');
        $booking->status = $request->input('status');
        $booking->discount = $request->input('discount');
        $booking->total = $request->input('before_discount_total');
        $booking->grand_total = $request->input('grand_total');
        $booking->review_status = 0;
        $booking->save();

       // dd($spaces->id);
      //  $booking_capacity = new BookingTiming();
        $count = $request->input('total_days');

        /*********************************Booking Timing************************************************/
        for ($i = 1; $i <= $count; $i++) {
            if (empty($request->input('addons'.$i))){
                $addonn = '[]';
            }else{
                $addonn = json_encode($request->input('addons'.$i));
            }
            $booking_capacity = new BookingTiming();
            $booking_capacity->booking_id = $booking->id;
            $booking_capacity->day = $i;
            $booking_capacity->sitting_plan_id = $request->input('layout'.$i);
            $booking_capacity->capacity = $request->input('capacity'.$i);
            $booking_capacity->addons =  $addonn;
            $booking_capacity->start_time = date("H:i:s", strtotime($request->input('stime'.$i).':'.'00'));
            $booking_capacity->end_time = date("H:i:s", strtotime($request->input('etime'.$i).':'.'00'));
            $booking_capacity->special_instruction = $request->input('sinstructionname'.$i);
            //dd($booking_capacity);
            $booking_capacity->save();

        }

        /*********************************Booking Food*********************************/
        for ($i = 0; $i <= $count; $i++)
        {
            $cusine_count = $i+1;
            $totel_cusine_selected = $request->input('total_cosine_selection'.$cusine_count);

            for($j=1; $j<=$totel_cusine_selected; $j++)
            {
                $cusin = $j-1;
                $cusine_id = $request->input('cusine_selection_'.$i.'_'.$cusin);

                if(isset($cusine_id)) {
                    $booking_food = new BookingFood();
                    $booking_food->booking_id = $booking->id;
                    $booking_food->day = $i+1;
                    $booking_food->food_categories_id = $request->input('cusine_selection_'.$i.'_'.$cusin);
                    $booking_food->save();
                }
            }
        }


        /*********************************Booking Payment*********************************/
        for ($i = 1; $i <= $count; $i++)
        {
            $total_day_payment = $request->input('singaldaytotal'.$i );

            $booking_payment = new BookingPayment();
            $booking_payment->booking_id = $booking->id;
            $booking_payment->day = $i;
            $booking_payment->total_day_payment = $total_day_payment;

            $booking_payment->save();
        }

        $booking['user'] == $booking->user;
        $booking['space'] == $booking->space;
        $booking['venue'] == $booking->space->venue;

        $booking_user = $booking->user;

        // new booking notification
        $booking_user->notify(new NewBooking($booking));
        $hotel_owner->notify(new NewHotelOwnerBooking($booking));

        return $this->outputJSON('Space Booked Successfully', 201,$booking);
    }

    public function  booking_status(Request $request)
    {
        if(Auth::check())
        {
            if (Auth::user()->type == 'individual' && $request->input('status') == '1')
            {
                return $this->outputJSON('Your not authorized to approve a booking', 401,null);
            }
        }


       $booking = BookingInfo::find($request->input('booking_id'));
       if ($booking){
           $booking->status = $request->input('status');
           $booking->save();

           $booking['user'] == $booking->user;
           $booking['space'] == $booking->space;
           $booking['venue'] == $booking->space->venue;

           $booking_user = $booking->user;

           if($booking->status == 1)
           {
               // approve notification
               $booking_user->notify(new ApproveBooking($booking));

               $booking_date = Carbon::parse($booking->start_date);

               $three_days = Carbon::parse($booking->start_date)->subDay(3);
               $one_day = Carbon::parse($booking->start_date)->subDay(1);

               if($booking_date != today())
               {
                   if($three_days->diffInDays($booking_date) > 3)
                   {
                       // 3 days before reminder notification
                       $booking_user->notify((new ReminderBooking($booking))->delay($three_days));
                   }
                   // 1 day before reminder notification
                   $booking_user->notify((new ReminderBooking($booking))->delay($one_day));
               }
           }

//           if($booking->status == 2)
//           {
//               if(Auth::check())
//               {
//                    if (Auth::user()->type == 'individual')
//                    {
//                        $hotel_owner = $booking->space->venue->company->user;
//                        $hotel_owner->notify(new CancelBooking($booking));
//                    } else {
//                        $booking_user->notify(new CancelBooking($booking));
//                    }
//               }
//           }


       } else {
           return $this->outputJSON('Booking not found', 404,$booking);
       }

       return $this->outputJSON('Booking Status Change Successfully', 201,$booking);
    }

    public function booking_index_hotel()
    {
        $user = Auth::user();
        $bookings = BookingInfo::where('hotel_owner_id', $user->id)->get();

        if(count($bookings) > 0)
        {
            return $this->outputJSON('Bookings found for this hotel', 200,$bookings);
        } else {
            return $this->outputJSON('NO Booking found for this hotel', 404,$bookings);
        }
    }

    public function booking_detail_hotel($booking_id)
    {
        $user = Auth::user();
        $booking = BookingInfo::where('id', $booking_id)->where('hotel_owner_id', $user->id)->with(['bookingPayment', 'bookingTimings', 'bookingFoods'])->first();

        if($booking)
        {
            return $this->outputJSON('Booking found Successfully', 200,$booking);
        } else {
            return $this->outputJSON('No Booking', 404,$booking);
        }
    }

    public function booking_index_user()
    {
        $user = Auth::user();
        $bookings = BookingInfo::where('user_id', $user->id)->get();

        if(count($bookings) > 0)
        {
            return $this->outputJSON('Bookings found for this user', 200,$bookings);
        } else {
            return $this->outputJSON('NO Booking found for this user', 404,$bookings);
        }
    }

    public function booking_detail_user($booking_id)
    {
        $user = Auth::user();
        $booking = BookingInfo::where('id', $booking_id)->where('user_id', $user->id)->with(['bookingPayment', 'bookingTimings', 'bookingFoods'])->first();

        if($booking)
        {
            return $this->outputJSON('Booking found Successfully', 200,$booking);
        } else {
            return $this->outputJSON('No Booking', 404,$booking);
        }
    }

    public function create_manual_booking(Request $request)
    {
        //dd($request);
        //exit();
        $space = Spaces::find($request->input('space_id'));

      //  $hotel_owner = $space->venue->company->user;
        $booking_id = $request->id;
        if(isset($booking_id)){
            $booking = BookingInfo::find($booking_id);
            $booking->bookingTimings()->delete();
            $booking->bookingFoods()->delete();
            $booking->bookingPayment()->delete();
            $message = "Booking has been updated successfully";
        }else{
            $booking = new BookingInfo();
            $message = "Booking has been created successfully";
            $booking->booking_number = generate_booking_number();
        }
        $booking->user_id = 0;
        $booking->venue_id = $request->input('venue_id');
        $booking->space_id = $request->input('space_id');
        $booking->hotel_owner_id = $request->input('hotel_owner_id');
        $booking->booking_firstname = $request->input('firstname');
        $booking->booking_lastname = $request->input('lastname');
        $booking->booking_email = $request->input('customer_email');
        $booking->booking_phone = $request->input('customer_contact');
        $booking->booking_address = "Manual Booking";
        $booking->start_date = $request->input('startdate');
        $booking->end_date = $request->input('enddate');
        $booking->no_of_days = $request->input('total_days');
        $booking->purpose = $request->input('purpose');
        $booking->status = 1;
        $booking->discount = 0;
        $booking->total = 0;
        $booking->grand_total = 0;
        $booking->review_status = 0;
        $booking->save();

        // dd($spaces->id);
        //  $booking_capacity = new BookingTiming();
        $count = $request->input('total_days');

        /*********************************Booking Timing************************************************/
        for ($i = 1; $i <= $count; $i++) {
            $addonn = '[]';
            $booking_capacity = new BookingTiming();
            $booking_capacity->booking_id = $booking->id;
            $booking_capacity->day = $i;
            $booking_capacity->sitting_plan_id = 1;
            $booking_capacity->capacity = 0;
            $booking_capacity->addons =  $addonn;
            $booking_capacity->start_time = date("H:i:s", strtotime($request->input('stime'.$i).':'.'00'));;
            $booking_capacity->end_time = date("H:i:s", strtotime($request->input('etime'.$i).':'.'00'));;
            $booking_capacity->save();

        }

        /*********************************Booking Food*********************************/
        for ($i = 0; $i <= $count; $i++)
        {
                    $booking_food = new BookingFood();
                    $booking_food->booking_id = $booking->id;
                    $booking_food->day = $i+1;
                    $booking_food->food_categories_id = 0;
                    $booking_food->save();
        }


        /*********************************Booking Payment*********************************/
        for ($i = 1; $i <= $count; $i++)
        {
            $total_day_payment = 0;

            $booking_payment = new BookingPayment();
            $booking_payment->booking_id = $booking->id;
            $booking_payment->day = $i;
            $booking_payment->total_day_payment = $total_day_payment;

            $booking_payment->save();
        }

        $booking['user'] == $booking->user;
        $booking['space'] == $booking->space;
        $booking['venue'] == $booking->space->venue;

        return $this->outputJSON($message, 201,$booking);
    }
}