<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Discount;
use App\Models\Site\BookingInfo;
use App\Models\Site\Individual;
use App\Models\Site\Review;
use App\Models\Site\Spaces;
use App\Models\Site\User;
use App\Models\Site\Venue;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        Carbon::useMonthsOverflow(false);
        $booking_count = BookingInfo::where('status', 1)->count();
        $last_month_booking_count = BookingInfo::where('status', 1)->where('created_at', '<=', Carbon::now()->subMonth())->count();
        $booking_monthly_growth = calculate_growth($booking_count, $last_month_booking_count);

        $booking_revenue = BookingInfo::where('status', 1)->sum('grand_total');
        $last_month_booking_revenue = BookingInfo::where('status', 1)->where('created_at', '<=', Carbon::now()->subMonth())->sum('grand_total');
        $booking_revenue_monthly_growth = calculate_growth($booking_revenue, $last_month_booking_revenue);

        $venues_count = Venue::where('status', 1)->count();
        $last_month_venues_count = Venue::where('status', 1)->where('created_at', '<=', Carbon::now()->subMonth())->count();
        $venue_monthly_growth = calculate_growth($venues_count, $last_month_venues_count);

        $spaces_count = Spaces::where('status', 1)->count();
        $last_month_spaces_count = Spaces::where('status', 1)->where('created_at', '<=', Carbon::now()->subMonth())->count();
        $spaces_monthly_growth = calculate_growth($spaces_count, $last_month_spaces_count);

        $latest_bookings = BookingInfo::latest()->limit(6)->get();

        $totel_user_count = User::where('type', 'individual')->where('activated', 1)->count();

        $discount_silver = Discount::where('type', 'silver')->first();
        $discount_gold = Discount::where('type', 'gold')->first();
        $discount_platinum = Discount::where('type', 'platinum')->first();

        $user_bookings_counts = BookingInfo::select('user_id', DB::raw('count(*) as total'))
            ->where('status', 1)
            ->whereDate('end_date' , '<' , Carbon::today())
            ->groupBy( 'user_id' )
            ->get();

        $platinum = 0;
        $gold = 0;
        $silver = 0;
        $classic = 0;

        foreach ($user_bookings_counts as $user_bookings_count){
            if($user_bookings_count['total'] >= $discount_platinum->no_of_booking) {
                $platinum++;
            } elseif ($user_bookings_count['total'] >= $discount_gold->no_of_booking){
                $gold++;
            } elseif ($user_bookings_count['total'] >= $discount_silver->no_of_booking) {
                $silver++;
            } else {
                $classic++;
            }
        }

        $platinum_p = calculate_percentage($platinum, $totel_user_count);
        $gold_p = calculate_percentage($gold, $totel_user_count);
        $sliver_p = calculate_percentage($silver, $totel_user_count);
        $classic_p = calculate_percentage($classic, $totel_user_count);

        $latest_venues = Venue::latest()->limit(6)->get();
        $latest_spaces = Spaces::latest()->limit(6)->get();

//        dd($latest_venues, $latest_spaces);

//        dd($platinum_p, $gold_p, $sliver_p, $classic_p);

        return view('admin-panel.index', compact('booking_count','booking_revenue','venues_count',
            'spaces_count','booking_monthly_growth','booking_revenue_monthly_growth','venue_monthly_growth','spaces_monthly_growth','latest_bookings',
            'platinum_p','gold_p','sliver_p','classic_p','latest_venues','latest_spaces'));
    }

    public function get_dashboard_line_chart_data()
    {
        $bookings = BookingInfo::select('created_at','grand_total')
            ->where('status', 1)
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });



        $bookingscount = [];
        $bookingsArr = [];

        foreach ($bookings as $key => $value) {
            $bookingscount[(int)$key] = $value->sum('grand_total');
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($bookingscount[$i])){
                $bookingsArr[$i] = $bookingscount[$i];
            }else{
                $bookingsArr[$i] = 0;
            }
        }

        $arr = [];
        foreach ($bookingsArr as $key=>$booking)
        {
            $dateObj   = DateTime::createFromFormat('!m', $key);
            $monthName = $dateObj->format('M'); // March
            $inner = [];
            $inner['date'] = $monthName;
            $inner['count'] = $booking;

            $arr[] = $inner;
        }
        return response()->json($arr);
    }

    public function get_dashboard_pie_chart_data()
    {
        Carbon::useMonthsOverflow(false);

        // for this week
        $all_this_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])->count();
        $pending_this_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])->where('status', 0)->count();
        $approved_this_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])->where('status', 1)->count();
        $canceled_this_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])->where('status', 2)->count();

        // for last week
        $all_last_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->subWeek()->startOfWeek(), Carbon::today()->subWeek()->endOfWeek()])->count();
        $pending_last_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->subWeek()->startOfWeek(), Carbon::today()->subWeek()->endOfWeek()])->where('status', 0)->count();
        $approved_last_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->subWeek()->startOfWeek(), Carbon::today()->subWeek()->endOfWeek()])->where('status', 1)->count();
        $canceled_last_week_booking_count = BookingInfo::whereBetween('created_at', [Carbon::today()->subWeek()->startOfWeek(), Carbon::today()->subWeek()->endOfWeek()])->where('status', 2)->count();

        // for all time
        $all_booking_count = BookingInfo::all()->count();
        $pending_booking_count = BookingInfo::where('status', 0)->count();
        $approved_booking_count = BookingInfo::where('status', 1)->count();
        $canceled_booking_count = BookingInfo::where('status', 2)->count();

        $all_arr = [];
        $this_arr = [];
        $last_arr = [];
        for ($i = 0; $i < 3; $i++)
        {
            $all_inner = [];
            $this_inner = [];
            $last_inner = [];
            if($i == 2)
            {
                $label   = 'Cancelled Booking';
                $all_value = calculate_percentage($canceled_booking_count, $all_booking_count); // all percentage
                $this_value = calculate_percentage($canceled_this_week_booking_count, $all_this_week_booking_count); // this percentage
                $last_value = calculate_percentage($canceled_last_week_booking_count, $all_last_week_booking_count); // this percentage
            } elseif($i == 1)
            {
                $label   = 'Approved Booking';
                $all_value = calculate_percentage($approved_booking_count, $all_booking_count); // percentage
                $this_value = calculate_percentage($pending_this_week_booking_count, $all_this_week_booking_count); // this percentage
                $last_value = calculate_percentage($pending_last_week_booking_count, $all_last_week_booking_count); // this percentage

            } else {
                $label   = 'Pending Booking';
                $all_value = calculate_percentage($pending_booking_count, $all_booking_count); // percentage
                $this_value = calculate_percentage($approved_this_week_booking_count, $all_this_week_booking_count); // this percentage
                $last_value = calculate_percentage($approved_last_week_booking_count, $all_last_week_booking_count); // this percentage
            }

            $all_inner['label'] = $label;
            $all_inner['value'] = $all_value;

            $this_inner['label'] = $label;
            $this_inner['value'] = $this_value;

            $last_inner['label'] = $label;
            $last_inner['value'] = $last_value;

            $all_arr[] = $all_inner;
            $this_arr[] = $this_inner;
            $last_arr[] = $last_inner;
        }


        return response()->json(['all' => $all_arr, 'thisweek' => $this_arr, 'lastweek' => $last_arr]);
    }

    public function users()
    {
        $users= User::all();
        return view('admin-panel.users', compact('users'));
    }

    public function add_user()
    {
        return view('admin-panel.user_managment.add_user');
    }

    public function change_user_status(Request $request)
    {
        $user_id = $request->input('id');
        $user = User::find($user_id);

        if($user)
        {
            if($user->activated == 1)
            {
                $user->activated = 0;
            } else {
                $user->activated = 1;
            }
            $user->save();
        }

        return redirect()->route('admin.users');
    }

    public function reviews()
    {
        $reviews = Review::all();
        return view('admin-panel.reviews', compact('reviews'));
    }


    public function change_review_status(Request $request){
        $review_id = $request->input('review_id');
        $booking_id = $request->input('booking_id');
        $review_status = Review::find($review_id);

        if($review_status)
        {
            if($review_status->r_status == 1)
            {
                $review_status->r_status = 0;
                $update_booking = BookingInfo::find($booking_id);
                $update_booking->review_status = 0;
                $update_booking->save();
            } else {
                $review_status->r_status = 1;
                $update_booking = BookingInfo::find($booking_id);
                $update_booking->review_status = 1;
                $update_booking->save();
            }
            $review_status->save();
        }

        $review = Review::where('id' , $review_id)->first();
        $space_id = $review->space_id;  // get space ID
        // Get all reviews against space
        //Our array, which contains a set of starts.
        $reviews = Review::where('space_id' , $space_id)->where('r_status' , '1')->get()->toArray();
        if(count($reviews)){
            $total_review_count = count($reviews);
            $review_sum = 0;
            $csr = 0;
            $amr = 0;
            $mfr = 0;
            $fr = 0;
            foreach ($reviews as $key=>$review){
                $csr += (int)$review['customer_service_rate'];
                $amr += (int)$review['amenities_rate'];
                $mfr += (int)$review['meeting_facility_rate'];
                $fr += (int)$review['food_rate'];
                $review_sum += (int)$review['total_stars'];
            }
            //Calculate the average and round it up.

            //csr
            $average_csr =  number_format((float)$csr / $total_review_count , 1, '.', '');
            $total_average_percentage_csr = ($average_csr/5) * 100;
            $total_space_csr =  ($total_average_percentage_csr/100) * 5;
            //amr
            $average_amr =  number_format((float)$amr / $total_review_count , 1, '.', '');
            $total_average_percentage_amr = ($average_amr/5) * 100;
            $total_space_amr =  ($total_average_percentage_amr/100) * 5;
            //mfr
            $average_mfr =  number_format((float)$mfr / $total_review_count , 1, '.', '');
            $total_average_percentage_mfr = ($average_mfr/5) * 100;
            $total_space_mfr =  ($total_average_percentage_mfr/100) * 5;
            //fr
            $average_fr =  number_format((float)$fr / $total_review_count , 1, '.', '');
            $total_average_percentage_fr = ($average_fr/5) * 100;
            $total_space_fr =  ($total_average_percentage_fr/100) * 5;

            //total
            $average =  number_format((float)$review_sum / $total_review_count , 1, '.', '');
            $total_average_percentage = ($average/20) * 100;
            $total_space_avg =  ($total_average_percentage/100) * 5;

            $review_data = array(
                number_format((float)$total_space_csr , 1, '.', ''),
                number_format((float)$total_space_amr , 1, '.', ''),
                number_format((float)$total_space_mfr , 1, '.', ''),
                number_format((float)$total_space_fr , 1, '.', ''),
                number_format((float)$total_space_avg , 1, '.', '')
            );

            $review_data = json_encode($review_data);
            // Spaces Table Update
            $space = Spaces::find($space_id);
            $space->reviews_count = $review_data;
            $space->reviews_total = number_format((float)$total_space_avg , 1, '.', '');
            $space->save();
            $venue_id = $space->venue_id;
            // Venue Table Update
            $all_spaces = Spaces::where('venue_id' , $venue_id)->get();
            $total_spaces_sum = 0;
            $total_record = 1;
            foreach($all_spaces as $key=>$s_data){
                $space_review = $s_data->reviews_total;
                $total_spaces_sum += (float)$space_review;
                if($s_data->reviews_total != '0')
                    $total_record +=$key;
            }
            $venu_rating = number_format((float)$total_spaces_sum / $total_record, 1, '.', '');

            $venue = Venue::find($venue_id);
            $venue->reviews = $venu_rating;
            $venue->save();

        }else{
            $space = Spaces::find($space_id);
            $space->reviews_count = 0;
            $space->reviews_total = 0;
            $space->save();

            $venue_id = $space->venue_id;
            $venue = Venue::find($venue_id);
            $venue->reviews = 0;
            $venue->save();
        }
        $reviews = Review::all();
        return view('admin-panel.reviews', compact('reviews'));
    }

    public function grades()
    {
        $venues = Venue::where('status', '1')->get();
        return view('admin-panel.grades', compact('venues'));
    }

    public function get_earn_points()
    {
        $discount_silver = Discount::where('type', 'silver')->first();
        $discount_gold = Discount::where('type', 'gold')->first();
        $discount_platinum = Discount::where('type', 'platinum')->first();
        return view('admin-panel.earn-points', compact('discount_silver','discount_gold','discount_platinum'));
    }

    public function save_earn_points(Request $request)
    {
      //  dd($request);
        $count = $request->count;
      //  dd($count);
        for ($i = 1; $i <= $count; $i++)
        {
            $discount = Discount::updateOrCreate(
                [
                    'type' => $request->input('type'.$i)
                ],
                [
                    'discount' => $request->input('discount'.$i),
                    'no_of_booking' => $request->input('booking-number-'.$i)
                ]);
        }
        session()->flash('msg-success', 'Discount % updated');

        return redirect()->route('admin.earn.points');
    }
}
