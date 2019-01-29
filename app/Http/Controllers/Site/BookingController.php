<?php

namespace App\Http\Controllers\Site;

use App\Models\Admin\Discount;
use App\Models\Site\Accessibility;
use Illuminate\Support\Facades\Response;
use PDF;
use App\Models\Site\Amenities;
use App\Models\Site\BookingInfo;
use App\Models\Site\Credit_card;
use App\Models\Site\FoodDuration;
use App\Models\Site\Individual;
use App\Models\Site\SittingPlan;
use App\Models\Site\User;
use App\Notifications\ReminderBooking;
use App\Traits\BookingTrait;
use App\Traits\SpacesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\SpacesType;
use App\Models\Site\Company;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use App\Models\Site\BookingTiming;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    use BookingTrait;
    //
    public function index($slug)
    {
        // dd($slug);
        // $slug = $this->input->post('slug');
        $space_record = Spaces::where('slug', $slug)->first();
        //  $space_record = Spaces::where('id' , 13)->first();
        $space_sitting_plans = $space_record->spaceCapacityPlan;
        $sitting_plan = [];
        foreach ($space_sitting_plans as $space_sitting_plan){
            $sitting_plan[] = SittingPlan::find($space_sitting_plan->sitting_plan_id);
        }

        $space_venue_record = $space_record->venue;
        $space_food_duration = $space_venue_record->foodDuration;
        $space_food_categories = $space_record->venue->foodCategory;

        $morning_food_categories = [];
        $afternoon_food_categories = [];
        $evening_food_categories = [];
        $night_food_categories = [];
        foreach ($space_food_categories as $space_food_category)
        {
            $food_duration = FoodDuration::where('id', $space_food_category->food_duration_id)->first();
            if($food_duration['food_duration'] == 'Morning'){
                $morning_food_categories[] = $space_food_category;
            } elseif($food_duration['food_duration'] == 'Afternoon'){
                $afternoon_food_categories[] = $space_food_category;
            } elseif($food_duration['food_duration'] == 'Evening') {
                $evening_food_categories[] = $space_food_category;
            } elseif($food_duration['food_duration'] == 'Night') {
                $night_food_categories[] = $space_food_category;
            }
        }

        $user = User::where('id', Auth::user()->id)->first();
        if($user->type === 'individual')
        {

            $user_profile = Individual::where('user_id', Auth::user()->id)->first();

        } elseif($user->type === 'company')
        {
            $user_profile = Company::where('user_id', Auth::user()->id)->first();
        }

        $Amenities  =  Amenities::all();
        $venue_id = $space_venue_record->id;
        $space_types = SpacesType::whereHas('spaces', function($q) use ($venue_id ) {
            $q->where('venue_id', $venue_id);
        })->get();


        $space_add_ons = [];

        $venue_add_ons = $space_venue_record->venueAddOns;

        foreach ($venue_add_ons as $venue_add_on)
        {
            $add_on = [];
            $add_on['id'] = $venue_add_on->id;
            $add_on['name'] = get_amenity_name($venue_add_on->amenity_id);
            $add_on['image_address'] = url('storage/images/amenities/'.get_amenity_image($venue_add_on->amenity_id));
            $add_on['price'] = $venue_add_on->price;

            $space_add_ons[] = $add_on;
        }

        $hotel_owner = $space_record->venue->company->user;
        $get_user_bookings = BookingInfo::where('user_id', Auth::user()->id)->count();
        $discount_silver = Discount::where('type', 'silver')->first();
        $discount_gold = Discount::where('type', 'gold')->first();
        $discount_platinum = Discount::where('type', 'platinum')->first();
        // dd($get_user_bookings);
        if($get_user_bookings > $discount_silver->no_of_booking && $get_user_bookings < $discount_gold->no_of_booking){
            $discount = $discount_silver->discount;
        }elseif ($get_user_bookings > $discount_gold->no_of_booking && $get_user_bookings < $discount_platinum->no_of_booking){
            $discount = $discount_gold->discount;
        }elseif ($get_user_bookings >= $discount_platinum->no_of_booking){
            $discount = $discount_platinum->discount;
        }else{
            $discount = '0';
        }
        //  $discount = '10';

        return view('site/booking/booking_form', compact('space_record','space_venue_record','space_sitting_plan','space_food_duration',
            'morning_food_categories','afternoon_food_categories','evening_food_categories','night_food_categories','sitting_plan','Amenities', 'space_types','user_profile','user','space_add_ons','discount'));
    }

    public function check_space_status_for_booking(Request $request)
    {
        //dd($request);
        $already_booked = 0;
        $booking_id = $request->input('id');
        // Search for a space based on booking date.
        if($request->input('startdate') != null) {
            $start_date = Carbon::parse($request->input('startdate'));
            $end_date = Carbon::parse($request->input('startdate'));
            if($request->input('enddate') != null){

                $end_date = Carbon::parse($request->input('enddate'));
            }
            $range = [$start_date, $end_date];

            $bookings = BookingInfo::orwhereRaw('? between start_date and end_date', [$start_date])
                ->orWhereRaw('? between start_date and end_date', [$end_date])
                ->orWhereBetween('end_date', [$range])
                ->orWhereBetween('start_date', [$range])
                ->orwhere('start_date', $start_date)
                ->orwhere('end_date', $end_date)
                ->get();

            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking)
                {
                    if($booking->status != 2 && $booking->id != $booking_id)
                    {
                        $search_days_arr = [];
                        $search_days = ($start_date->diffInDays($end_date))+1;

                        $search_days_time_arr = [];
                        for ($i=0; $i<$search_days; $i++)
                        {
                            $search_days_arr[] = date('Y-m-d', strtotime($start_date. '+'.$i.'day'));

                            $time_search_arr = [];
                            $time_search_arr['start_time'] = date("H:i:s", strtotime($request->input('stime' . ($i + 1)) . ':' . '00'));
                            $time_search_arr['end_time'] = date("H:i:s", strtotime($request->input('etime' . ($i + 1)) . ':' . '00'));
                            $search_days_time_arr[date('Y-m-d', strtotime($start_date. '+'.$i.'day'))] = $time_search_arr;
                        }

                        $booking_start_day = Carbon::parse($booking->start_date);
                        $booking_end_day = Carbon::parse($booking->end_date);

                        $booking_days_arr = [];
                        $booking_days = $booking_start_day->diffInDays($booking_end_day)+1;

                        $bookingTimings = $booking->bookingTimings;
                        $booking_days_time_arr = [];
                        for ($i=0; $i<$booking_days; $i++)
                        {
                            $booking_days_arr[] = date('Y-m-d', strtotime($booking_start_day. '+'.$i.'day'));

                            $time_arr = [];
                            $time_arr['start_time'] = date("H:i:s", strtotime($bookingTimings[$i]->start_time));
                            $time_arr['end_time'] = date("H:i:s", strtotime($bookingTimings[$i]->end_time));
                            $booking_days_time_arr[date('Y-m-d', strtotime($booking_start_day. '+'.$i.'day'))] = $time_arr;
                        }

//                        dd($booking_days_time_arr, $search_days_time_arr);
                        $same_days = array_intersect($search_days_arr, $booking_days_arr);
                        if (count($same_days) === 0) {
                            // No values from $search_days_arr are in $booking_days_arr
                            continue;
                        } else {

                            // There is at least one value from $search_days_arr present in $booking_days_arr
                            foreach ($same_days as $same) {

                                $search_start_time = $search_days_time_arr[$same]['start_time'];
                                $search_end_time = $search_days_time_arr[$same]['end_time'];
                                $booking_start_timestamp = $booking_days_time_arr[$same]['start_time'];
                                $booking_end_timestamp = $booking_days_time_arr[$same]['end_time'];

                               //dd($search_start_time, $search_end_time, $booking_start_timestamp, $booking_end_timestamp);

//                                dd(check_time_is_within_range($booking_start_timestamp, $booking_end_timestamp, $search_start_time) ||
//                                    check_time_is_within_range($booking_start_timestamp, $booking_end_timestamp, $search_end_time));
                                if (check_time_is_within_range($booking_start_timestamp, $booking_end_timestamp, $search_start_time)
                                    || check_time_is_within_range($booking_start_timestamp, $booking_end_timestamp, $search_end_time))
                                {
                                   //dd('in');
                                   // echo $same;
                                    $already_booked++;
                                } else {
                                   //dd('out');
                                    continue;
                                }

                            }
                            //echo $already_booked;
                            //dd('');
                        }
                    }
                }
            }
        }
       //dd($already_booked);
        if($already_booked == 0)
        {
            return response()->json(['flag' => 1]);
        } else {
            return response()->json(['flag' => 0, 'message' => 'This space already booked according to given schedule']);
        }
    }

    public function save_manual_booking(Request $request){

        $response = $this->create_manual_booking($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Booking not saved manually');
        }

        return redirect(route('company.dashboard.bookings'));
    }

    public function save(Request $request)
    {
//dd($request);
        $response = $this->create_booking($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);

        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Booking not saved');
        }


        return redirect(route('thank-you'));

    }

    public function thankyou(){

        return view('site/booking/thankyou');

    }
    /**************************************************Company Owner*******************************************************/
    public function get_bookings(){

        // dd(today());
        $user = Auth::user();
        $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->paginate(6);
        $todays_booking = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date','=', today())->where('status','!=', 2)->paginate(6);
        $upcomings_booking = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date','>', today())->where('status','!=', 2)->paginate(6);
        $cancel_bookings = BookingInfo::where('hotel_owner_id', $user->id)->where('status' , 2)->paginate(6);
        $venue_location = Venue::all();
        // $user_booking  = User::where('id',$booking_infos->user_id)->first();
//        $current_booking = BookingInfo::where('hotel_owner_id', $user->id)->get();
//        foreach ($booking_infos as $booking_space){
//            $booked_spaces[] = Spaces::where('user_id',$booking_space->hotel_owner_id)->first();
//        }

        //  $spaces = Spaces::where('user_id',$booking_info->hotel_owner_id)->get();


        //  $spaces = $booking_info->space;
        // $spaces = $booking_infos->space->venue->company->user;
//        dd($cancel_bookings);


        return view('site/companies/dashboard_pages/bookings',compact('booking_infos','todays_booking','upcomings_booking','cancel_bookings','venue_location'));
    }

    public function get_bookings_detail(Request $request, $bookings_id)
    {
        $notification = $request->user()->notifications()->where('id', $request->read)->first();

        if($notification) {
            $notification->markAsRead();
        }

        //  $user = Auth::user();
        $booking_infos = BookingInfo::where('id', $bookings_id)->first();
        $user = User::where('id',$booking_infos->user_id)->first();
        $payment_per_day = $booking_infos->bookingPayment;
        $sitting_plan = $booking_infos->bookingTimings;
        $foods =  $booking_infos->bookingFoods;


        $booking_start_day = Carbon::parse($booking_infos->start_date);
        $booking_end_day = Carbon::parse($booking_infos->end_date);

        $booking_days_arr = [];
        $booking_days = $booking_start_day->diffInDays($booking_end_day)+1;

        for ($i=0; $i<$booking_days; $i++)
        {
            $booking_days_arr[] = date('Y-m-d', strtotime($booking_start_day. '+'.$i.'day'));
        }


//          dd($booking_days_arr,$sitting_plan );

//        $user = $booking_infos->user;
//dd(now());
//        $when = Carbon::parse($booking_infos->start_date)->addMinute(1);
//        $when = now()->addMinutes(5);

//        dd($when);

//        $user->notify((new ReminderBooking($booking_infos))->delay($when));


        return view('site/companies/dashboard_pages/bookings-detail',compact('booking_days_arr','booking_infos','user','payment_per_day','sitting_plan','foods'));
    }

    /*************************************************User Dashboard********************************************************/
    public function get_user_bookings(){

//        dd(today());
        $user = Auth::user();
        $booking_infos = BookingInfo::where('user_id', $user->id)->get();
        $previous_booking = BookingInfo::where('user_id', $user->id)->where('end_date','<', today())->get();
        $cancel_bookings = BookingInfo::where('user_id', $user->id)->where('status' , 2)->get();
        $venue_location = Venue::all();
        //  dd($previous_booking);


        return view('site/individuals/dashboard_pages/bookings',compact('booking_infos','previous_booking','cancel_bookings','venue_location'));
    }
    public function get_user_bookings_detail(Request $request, $bookings_id)
    {
        $notification = $request->user()->notifications()->where('id', $request->read)->first();

        if($notification) {
            $notification->markAsRead();
        }
        // dd($bookings_id);
        $user = Auth::user();
        $booking_infos = BookingInfo::where('id', $bookings_id)->first();
        $payment_per_day = $booking_infos->bookingPayment;
        $sitting_plan = $booking_infos->bookingTimings;
        $foods =  $booking_infos->bookingFoods;

        $booking_start_day = Carbon::parse($booking_infos->start_date);
        $booking_end_day = Carbon::parse($booking_infos->end_date);

        $booking_days_arr = [];
        $booking_days = $booking_start_day->diffInDays($booking_end_day)+1;

        for ($i=0; $i<$booking_days; $i++)
        {
            $booking_days_arr[] = date('Y-m-d', strtotime($booking_start_day. '+'.$i.'day'));
        }

        //   dd($foods);


        return view('site/individuals/dashboard_pages/bookings-detail',compact('booking_days_arr','booking_infos','user','payment_per_day','sitting_plan','foods'));
    }

    public function update_status(Request $request)
    {

        //exit();
        $user = Auth::user();
        $response = $this->booking_status($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
        } elseif ($response->getData()->code == 404)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Booking Status not updated');
        }



        if($user->type == 'company'){
            return redirect(route('company.dashboard.bookings'));
        }else{
            return redirect(route('user.dashboard.bookings'));
        }

    }

    /**********************************************************Report By Hotel Owner User********************************************************/
    public function report(Request $request)
    {
        //   dd($request);
        $booking_status = $request->input('status');
        $location = $request->input('location');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $user = Auth::user();
        $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->get();

        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('hotel_owner_id', $user->id);


        if($request->filled('location')) {
            $venues = Venue::where('city', $location)->get();

            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }

            $bookings->whereIn('venue_id', $venues_arr);

        }
        if($request->filled('status')) {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($request->filled('start_date')) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($request->filled('end_date')) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();
        //dd($bookings->get());
        //   $user = User::where('id',$bookingreports->user_id)->first();

        return view('site/companies/dashboard_pages/report',compact('bookingreports','booking_status','location','start_date','end_date','user'));
        // return redirect(route('site/companies/dashboard_pages/report'));
    }

    public function downloadPDF($status,$locations,$start_dates,$end_dates){
        //  dd($status);
        $booking_status = $status;
        $location = $locations;
        $start_date = $start_dates;
        $end_date = $end_dates;

        $user = Auth::user();
        $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->get();

        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('hotel_owner_id', $user->id);


        if($location != 'All') {
            $venues = Venue::where('city', $location)->get();

            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }
            $bookings->whereIn('venue_id', $venues_arr);
        }
        if($booking_status != 'All') {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($start_date) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($end_date) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();

        $pdf = PDF::loadView('site/companies/dashboard_pages/pdf', compact('bookingreports','user','booking_status','location','start_date','end_date'));
        return $pdf->download('report.pdf');

    }

    public function exportCSV($status,$locations,$start_dates,$end_dates)
    {
        $booking_status = $status;
        $location = $locations;
        $start_date = $start_dates;
        $end_date = $end_dates;

        $user = Auth::user();
        $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->get();

        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('hotel_owner_id', $user->id);


        if($location != 'All') {
            $venues = Venue::where('city', $location)->get();



            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }

            $bookings->whereIn('venue_id', $venues_arr);

        }
        if($booking_status != 'All') {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($start_date) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($end_date) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Sr#', 'Name of Meeting', 'Venue Name', 'Space Name', 'Start Date','End Date', 'Amount', 'Status');

        $callback = function() use ($bookingreports, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($bookingreports as $key=>$bookingreport) {
                if($bookingreport->status == 0){
                    $status = "Pending";
                }elseif ($bookingreport->status == 1){
                    $status = "Approved";
                }elseif ($bookingreport->status == 2){
                    $status = "Cancelled";
                }
                fputcsv($file, array($key+1, $bookingreport->purpose, $bookingreport->space->venue->title, $bookingreport->space->title, date('d M Y', strtotime($bookingreport->start_date)), date('d M Y', strtotime($bookingreport->end_date)), 'AED '.$bookingreport->grand_total, $status));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    /**********************************************************Report Report By Individual User********************************************************/
    public function UserReport(Request $request)
    {

        $booking_status = $request->input('status');
        $location = $request->input('location');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $user = Auth::user();
        $booking_infos = BookingInfo::where('user_id', $user->id)->get();
        // dd($booking_infos);
        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('user_id', $user->id);


        if($request->filled('location')) {
            $venues = Venue::where('city', $location)->get();



            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }

            $bookings->whereIn('venue_id', $venues_arr);

        }
        if($request->filled('status')) {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($request->filled('start_date')) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($request->filled('end_date')) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();
        //dd($bookings->get());
        //   $user = User::where('id',$bookingreports->user_id)->first();

        return view('site/individuals/dashboard_pages/report',compact('bookingreports','booking_status','location','start_date','end_date','user'));
        // return redirect(route('site/companies/dashboard_pages/report'));
    }
    public function downloadUserPDF($status,$locations,$start_dates,$end_dates){
        //  dd($status);
        $booking_status = $status;
        $location = $locations;
        $start_date = $start_dates;
        $end_date = $end_dates;

        $user = Auth::user();
        $booking_infos = BookingInfo::where('user_id', $user->id)->get();

        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('user_id', $user->id);


        if($location != 'All') {
            $venues = Venue::where('city', $location)->get();



            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }

            $bookings->whereIn('venue_id', $venues_arr);

        }
        if($booking_status != 'All') {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($start_date) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($end_date) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();

        $pdf = PDF::loadView('site/individuals/dashboard_pages/pdf', compact('bookingreports','user','booking_status','location','start_date','end_date'));
        return $pdf->download('report.pdf');

    }
    public function exportUserCSV($status,$locations,$start_dates,$end_dates)
    {
        $booking_status = $status;
        $location = $locations;
        $start_date = $start_dates;
        $end_date = $end_dates;

        $user = Auth::user();
        $booking_infos = BookingInfo::where('user_id', $user->id)->get();

        $bookings = (new BookingInfo())->newQuery();

        $bookings->where('user_id', $user->id);


        if($location != 'All') {
            $venues = Venue::where('city', $location)->get();



            $venues_arr = [];
            if(count($venues) > 0)
            {
                foreach ($venues as $venue)
                {
                    $venues_arr[] = $venue->id;
                }
            }

            $bookings->whereIn('venue_id', $venues_arr);

        }
        if($booking_status != 'All') {
            // dd($booking_status);
            $bookings->where('status', $booking_status);
        }
        if($start_date) {
            $bookings->where('start_date', '>=', $start_date);
        }
        if($end_date) {
            $bookings->where('end_date', '<=', $end_date);
        }

        $bookingreports = $bookings->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Sr#', 'Name of Meeting', 'Venue Name', 'Space Name', 'Start Date','End Date', 'Amount', 'Status');

        $callback = function() use ($bookingreports, $columns)
        {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($bookingreports as $key=>$bookingreport) {
                if($bookingreport->status == 0){
                    $status = "Pending";
                }elseif ($bookingreport->status == 1){
                    $status = "Approved";
                }elseif ($bookingreport->status == 2){
                    $status = "Cancelled";
                }
                fputcsv($file, array($key+1, $bookingreport->purpose, $bookingreport->space->venue->title, $bookingreport->space->title, date('d M Y', strtotime($bookingreport->start_date)), date('d M Y', strtotime($bookingreport->end_date)), 'AED '.$bookingreport->grand_total, $status));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    /***********************************************Search Ajax******************************************************/
    public function search(Request $request)
    {
        $output="";
        $page="";
        $user = Auth::user();
        $search_order = $request->search_order;
        if(empty($search_order)){
            $search_order = "desc";
        }

        if ($request->activetab == 1) {
            $final_result = BookingInfo::where('hotel_owner_id', $user->id)->orderBy('start_date', $search_order)->get();
        }elseif ($request->activetab == 2) {
            $final_result = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date','=', today())->where('status','!=', 2)->orderBy('start_date', $search_order)->get();
        }elseif ($request->activetab == 3) {
            $final_result = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date','>', today())->where('status','!=', 2)->orderBy('start_date', $search_order)->get();
        }elseif ($request->activetab == 4) {
            $final_result = BookingInfo::where('hotel_owner_id', $user->id)->where('status' , 2)->orderBy('start_date', $search_order)->get()->paginate(5);
        }
        if($request->search != '') {
            $final_result = array();
            $venues = Venue::orwhere('title', 'LIKE', '%' . $request->search . "%")->orwhere('city', 'LIKE', '%' . $request->search . "%")->get();
            $venues_arr = [];
            if (count($venues) > 0) {
                foreach ($venues as $venue) {
                    $venues_arr[] = $venue->id;
                }
            }
            if ($request->activetab == 1) {
                $result_booking['venue'] = BookingInfo::whereIn('venue_id', $venues_arr)->where('hotel_owner_id', $user->id)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 2) {
                $result_booking['venue'] = BookingInfo::whereIn('venue_id', $venues_arr)->where('hotel_owner_id', $user->id)->where('start_date', '=', today())->where('status', '!=', 2)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 3) {
                $result_booking['venue'] = BookingInfo::whereIn('venue_id', $venues_arr)->where('hotel_owner_id', $user->id)->where('start_date', '>', today())->where('status', '!=', 2)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 4) {
                $result_booking['venue'] = BookingInfo::whereIn('venue_id', $venues_arr)->where('hotel_owner_id', $user->id)->where('status', 2)->orderBy('start_date', $search_order)->get();
            }
            $spaces = Spaces::where('title', 'LIKE', '%' . $request->search . "%")->get();
            $spaces_arr = [];
            if (count($spaces) > 0) {
                foreach ($spaces as $space) {
                    $spaces_arr[] = $space->id;
                }
            }
            if ($request->activetab == 1) {
                $result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('hotel_owner_id', $user->id)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 2) {
                $result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('hotel_owner_id', $user->id)->where('start_date', '=', today())->where('status', '!=', 2)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 3) {
                $result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('hotel_owner_id', $user->id)->where('start_date', '>', today())->where('status', '!=', 2)->orderBy('start_date', $search_order)->get();
            } elseif ($request->activetab == 4) {
                $result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('hotel_owner_id', $user->id)->where('status', 2)->orderBy('start_date', $search_order)->get();
            }
            foreach ($result_booking['venue'] as $s_venue) {
                array_push($final_result, $s_venue);
            }
            foreach ($result_booking['space'] as $s_space) {
                array_push($final_result, $s_space);
            }
        }

        $final_resulting = paginate($final_result,5);


        if(count($final_resulting) > 0) {
            foreach ($final_resulting as $booking) {
                if ($booking->status == 0) {
                    $status = 'Pending';
                } elseif ($booking->status == 1) {
                    $status = 'Approved';
                } else {
                    $status = 'Cancelled';
                }
                $startdate = date('d M', strtotime($booking->start_date));
                $enddate = date('d M', strtotime($booking->end_date));
                $to = " to ";

                $output .= '<div class="book-list hotal-book-list">' .
                    '<div class="b-list-info col-sm-3">' .
                    '<h4>' . $booking->space->venue->title . '</h4>' .
                    '<h3>' . $booking->space->title . '</h3>' .
                    '<h5><a href="#">' . $booking->space->venue->city . '</a></h5>' .
                    '</div>' .
                    '<div class="b-list-status col-sm-1">' .
                    '<p>' . $status . '<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="' . url('images/info.png') . '" alt=""></a></p>' .
                    '</div>' .
                    '<div class="b-list-com b-list-date col-sm-3">';
                if($booking->user_id == 0){
                    $output .= '<p>'.$booking->booking_firstname.' '.$booking->booking_lastname.'<span>' . $booking->booking_phone .'</span><p>';
                }else{
                    $output .= '<p>' . $booking->user->name . '<span>' . $booking->user->phone_number . '</span></p>';
                }
                $output .= '</div>'.
                    '<div class="b-list-date col-sm-3">' .
                    '<p>' . $startdate . $to . $enddate . '<span>' . $booking->purpose . '</span></p>' .
                    '</div>' .
                    '<div class="b-list-price col-sm-1">' .
                    'AED' . $booking->grand_total .
                    '</div>' .
                    '<div class="b-list-btn col-sm-1">' .
                    '<a href="' . url('company/dashboard/bookings-detail/' . $booking->id) . '" class="btn get-btn">' .
                    '<span>View Detail </span><span></span><span></span><span></span><span></span>' .
                    '</a>' .
                    '</div>' .
                    '</div>';
            }

            $page .= $final_resulting->withPath('');
        }

        return Response()->json(['output'=>$output,'page'=>$page]);
    }


//    public function sort(Request $request)
//    {
//        if ($request->ajax()) {
//            $output = "";
//            $user = Auth::user();
//            if($request->activetab == 'all-booked'){
//                $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->orderBy('start_date', $request->sort)->get();
//            }elseif($request->activetab == 'today-booking') {
//                $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date', '=', today())->where('status', '!=', 2)->orderBy('start_date', $request->sort)->get();
//            }elseif($request->activetab == 'upcoming') {
//                $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->where('start_date', '>', today())->where('status', '!=', 2)->orderBy('start_date', $request->sort)->get();
//            }elseif($request->activetab == 'canbooked') {
//                $booking_infos = BookingInfo::where('hotel_owner_id', $user->id)->where('status', 2)->orderBy('start_date', $request->sort)->get();
//            }
//
//            foreach ($booking_infos as $booking) {
//                if($booking->status == 0){
//                    $status = 'Pending';
//                }elseif($booking->status == 1){
//                    $status = 'Approved';
//                }else{
//                    $status = 'Cancelled';
//                }
//                $startdate = date('d M', strtotime($booking->start_date));
//                $enddate = date('d M', strtotime($booking->end_date));
//                $to = " to ";
//
//                $output.='<div class="book-list hotal-book-list">'.
//                    '<div class="b-list-info col-sm-3">'.
//                    '<h4>'.$booking->space->venue->title.'</h4>'.
//                    '<h3>'.$booking->space->title.'</h3>'.
//                    '<h5><a href="#">'.$booking->space->venue->city.'</a></h5>'.
//                    '</div>'.
//                    '<div class="b-list-status col-sm-1">'.
//                    '<p>'.$status.'</p>'.
//                    '</div>'.
//                    '<div class="b-list-com b-list-date col-sm-3">'.
//                    '<p>'.$booking->user->name.'<span>'.$booking->user->phone_number.'</span></p>'.
//                    '</div>'.
//                    '<div class="b-list-date col-sm-3">'.
//                    '<p>'.$startdate.$to.$enddate.'<span>'.$booking->purpose.'</span></p>'.
//                    '</div>'.
//                    '<div class="b-list-price col-sm-1">'.
//                    'AED'.$booking->grand_total.
//                    '</div>'.
//                    '<div class="b-list-btn col-sm-1">'.
//                    '<a href="'.url('company/dashboard/bookings-detail/'.$booking->id).'" class="btn get-btn">'.
//                    '<span>View Detail </span><span></span><span></span><span></span><span></span>'.
//                    '</a>'.
//                    '</div>'.
//
//
//
//                    '</div>';
//            }
//            return Response($output);
//
//        }
//    }
    /***********************************************User Search Ajax******************************************************/
    public function UserSearch(Request $request)
    {
        /*
        * activetab = 0 => All Bookings
        * activetab 1 => Previous Bookings
        * activetab = 2 => Cancelled Bookings
        */
//        if($request->ajax()){
        $output="";
        $user = Auth::user();
        $search_order = $request->search_order;
        if(empty($search_order)){
            $search_order = "desc";
        }
        $query = (new BookingInfo)->newQuery();
        $query->where('user_id', $user->id);
        $query->orderBy('created_at', $search_order);
        if($request->activetab == 1){
            $query->where('end_date','<', today());
        }else if($request->activetab == 2){
            $query->where('status', $request->activetab);
        }
        $final_result = $query->get();
        //$final_result = BookingInfo::where('user_id', $user->id)->orderBy('created_at', $search_order)->get();
        if($request->search != '') {
            $final_result = array();
            $venues = Venue::where('title', 'LIKE', '%' . $request->search . "%")->orWhere('city', 'LIKE', '%' . $request->search . "%")
                ->orderBy('created_at', $search_order)->get();
            $venues_arr = [];
            if (count($venues) > 0) {
                foreach ($venues as $venue) {
                    $venues_arr[] = $venue->id;
                }
            }
            $query = (new BookingInfo)->newQuery();
            $query->whereIn('venue_id', $venues_arr);
            $query->where('user_id', $user->id);
            $query->orderBy('created_at', $search_order);
            if($request->activetab == 1){
                $query->where('end_date','<', today());
            }else if($request->activetab == 2){
                $query->where('status', $request->activetab);
            }
            $result_booking['venue'] = $query->get();

            $booking_venue_ids = array();
            if(count($result_booking['venue']) > 0){
                foreach ($result_booking['venue'] as $booking) {
                    array_push($booking_venue_ids, $booking->id);
                }
            }
            $spaces = Spaces::where('title', 'LIKE', '%' . $request->search . "%")->orderBy('created_at', $search_order)->get();
            $spaces_arr = [];
            if (count($spaces) > 0) {
                foreach ($spaces as $space) {
                    $spaces_arr[] = $space->id;
                }
            }
            $query = (new BookingInfo)->newQuery();
            $query->whereIn('space_id', $spaces_arr);
            if(count($booking_venue_ids) > 0){
                $query->whereNotIn('id', $booking_venue_ids);
            }
            if($request->activetab == 1){
                $query->where('end_date','<', today());
            }else if($request->activetab == 2){
                $query->where('status', $request->activetab);
            }
            $query->where('user_id', $user->id);
            $query->orderBy('created_at', $request->search_order);
            $result_booking['space'] = $query->get();

            //dd(count($result_booking['space']));
            /*$result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('user_id', $user->id)
                ->orderBy('created_at', $request->search_order)->get();*/
            foreach ($result_booking['venue'] as $s_venue) {
                array_push($final_result, $s_venue);
            }
            foreach ($result_booking['space'] as $s_space) {
                array_push($final_result, $s_space);
            }
        }
        if(count($final_result) > 0){
            foreach ($final_result as $booking){
                if ($booking->status == 0) {
                    $status = 'Pending';
                } elseif ($booking->status == 1){
                    $status = 'Approved';
                } else {
                    $status = 'Cancelled';
                }
                $startdate = date('d M', strtotime($booking->start_date));
                $enddate = date('d M', strtotime($booking->end_date));
                $to = " to ";

                $output .= '<div class="book-list">' .
                    '<div class="b-list-img col-sm-2">' .
                    '<img src="' . url('storage/images/spaces/' . $booking->space->image) . '" alt="" />' .
                    '</div>' .
                    '<div class="b-list-info col-sm-3">' .
                    '<h4>' . $booking->space->venue->title . '</h4>' .
                    '<h3>' . $booking->space->title . '</h3>' .
                    '<h5><a href="#">' . $booking->space->venue->city . '</a></h5>' .
                    '</div>' .
                    '<div class="b-list-status col-sm-1">' .
                    '<p>' . $status. '<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info">
                        <img src="'. url('images/info.png') .'" alt=""></a></p>'.
                    '</div>' .
                    '<div class="b-list-date col-sm-2">' .
                    '<p>' . $startdate . $to . $enddate . '</p>' .
                    '</div>' .
                    '<div class="b-list-rate col-sm-1">';
                $json = json_decode($booking->space->reviews_count);
                $total_average_percentage = ($json[4] / 5) * 100;
                $output .= $json[4];
                $output .= get_stars_view($json[4]);
                $output .= '</div>' .
                    '<div class="b-list-price col-sm-1">' .
                    'AED ' . $booking->grand_total .
                    '</div>' .
                    '<div class="b-list-btn col-sm-2">' .
                    '<a href="' . url('user/dashboard/bookings-detail/' . $booking->id) . '" class="btn get-btn">' .
                    '<span>View Detail </span><span></span><span></span><span></span><span></span>' .
                    '</a>' .
                    '</div>' .
                    '</div>';
            }
        }else{
            $output .= '<div class="pay-inner-card"><div class="dash-pay-gray">No record found.</div></div>';
        }
        return response()->json(['html' => $output, 'counter' => count($final_result)]);
//        }
    }

    public function UserSort(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $user = Auth::user();
            if($request->activetab == 'booked'){
                $booking_infos = BookingInfo::where('user_id', $user->id)->orderBy('start_date', $request->sort)->get();
            }elseif($request->activetab == 'prebooked') {
                $booking_infos = BookingInfo::where('user_id', $user->id)->where('end_date','<', today())->orderBy('start_date', $request->sort)->get();
            }elseif($request->activetab == 'canbooked') {
                $booking_infos = BookingInfo::where('user_id', $user->id)->where('status' , 2)->orderBy('start_date', $request->sort)->get();
            }

            foreach ($booking_infos as $booking) {
                if($booking->status == 0){
                    $status = 'Pending';
                }elseif($booking->status == 1){
                    $status = 'Approved';
                }else{
                    $status = 'Cancelled';
                }
                $startdate = date('d M', strtotime($booking->start_date));
                $enddate = date('d M', strtotime($booking->end_date));
                $to = " to ";

                $output.='<div class="book-list">'.
                    '<div class="b-list-img col-sm-2">'.
                    '<img src="'.url('storage/images/spaces/'.$booking->space->image).'" alt="" />'.
                    '</div>'.
                    '<div class="b-list-info col-sm-3">'.
                    '<h4>'.$booking->space->venue->title.'</h4>'.
                    '<h3>'.$booking->space->title.'</h3>'.
                    '<h5><a href="#">'.$booking->space->venue->city.'</a></h5>'.
                    '</div>'.
                    '<div class="b-list-status col-sm-1">'.
                    '<p>'.$status.'</p>'.
                    '</div>'.
                    '<div class="b-list-date col-sm-3">'.
                    '<p>'.$startdate.$to.$enddate.'</p>'.
                    '</div>'.
                    '<div class="b-list-price col-sm-1">'.
                    'AED'.$booking->grand_total.
                    '</div>'.
                    '<div class="b-list-btn col-sm-2">'.
                    '<a href="'.url('user/dashboard/bookings-detail/'.$booking->id).'" class="btn get-btn">'.
                    '<span>View Detail </span><span></span><span></span><span></span><span></span>'.
                    '</a>'.
                    '</div>'.
                    '</div>';
            }
            return Response($output);

        }
    }

    public function manualbooking(){
        $user_id = Auth::user()->id;
        $company = Company::where('user_id', Auth::user()->id)->first();
        $venues = Venue::select('id', 'city')->where('company_id', $company->id)->where('status', 1)->get();
        //dd($venues);
        return view('site/companies/dashboard_pages/manual_booking', compact('venues'));
    }

    public function manual_booking_detail($booking_id){
        $booking = BookingInfo::find($booking_id);
        $booking_times = BookingTiming::select('start_time', 'end_time')->where('booking_id', $booking->id)->get()->toArray();
        //dd($booking_times);
        $user_id = Auth::user()->id;
        $company = Company::where('user_id', Auth::user()->id)->first();
        $venues = Venue::select('id', 'city','location')->where('company_id', $company->id)->get();
        $spaces = Spaces::select('id', 'title')->where('venue_id', $booking->venue_id)->get();
        // dd($venues);
        return view('site/companies/dashboard_pages/edit_manual_booking', compact('venues','booking','spaces','booking_times'));
    }


}
