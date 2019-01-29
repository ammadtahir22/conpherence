<?php

use App\Models\Admin\Career;
use App\Models\Admin\Career_category;
use App\Models\Admin\Discount;
use App\Models\Site\BookingInfo;
use App\Models\Site\Company;
use App\Models\Site\Review;
use App\Models\Site\Spaces;
use App\Models\Site\User;
use App\Models\Site\Venue;

use App\Models\Site\Wishlist;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Plugins
use PragmaRX\Countries\Package\Countries;
use PragmaRX\Countries\Package\Services\Config;

function get_user($user_id)
{
    return User::find($user_id);
}

function get_user_image($user_id)
{
    $image_url = url('images/edit-profile.png');

    $user = User::find($user_id);

    if($user->type === 'individual')
    {
        if(isset($user->individual->image))
        {
            $image_url = url('storage/images/users/'.$user->id.'/profile/'.$user->Individual->image);
        }
    } elseif($user->type === 'company')
    {
        if(isset($user->company->image))
        {
            $image_url = url('storage/images/users/'.$user->id.'/profile/'.$user->company->image);
        }
    }

    return $image_url;
}


function get_user_profile($user_id)
{
    $image_url = url('images/edit-profile.png');

    $user = User::find($user_id);

    if($user->type === 'individual')
    {
        if(isset($user->individual->image))
        {
            $image_url = url('storage/images/users/'.$user->id.'/profile/'.$user->Individual->image);
        }
    } elseif($user->type === 'company')
    {
        if(isset($user->company->image))
        {
            $image_url = url('storage/images/users/'.$user->id.'/profile/'.$user->company->image);
        }
    }

    return $image_url;
}

function get_venue_cover($venue_id)
{
    $image_url = url('images/edit-profile-iconh.png');

    $venue = Venue::find($venue_id);

    if($venue->cover_image != ' ')
    {
        $image_url = url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image);
    }

    return $image_url;
}

function get_space_cover($space_id)
{
    $image_url = url('images/edit-profile-iconh.png');

    $space = Spaces::find($space_id);

    if($space->image != ' ')
    {
        $image_url = url('storage/images/spaces/'.$space->image);
    }

    return $image_url;
}

function get_user_name($user_id)
{
    $user = User::find($user_id);

    return $user->name;
}

function search_careers_by_category($category_id, $value)
{
    $careers = Career::where('category_id', $category_id)->where(function($innerQuery) use ($value){
        $innerQuery->orWhere('title','LIKE','%'.$value.'%')->orWhere('location','LIKE','%'.$value.'%');
    })->get();

    return $careers;
}

function get_all_companies()
{
    return Company::all();
}

function createSlug($str, $delimiter = '-'){

    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}

function get_company_name($company_id)
{
    $company = Company::find($company_id);

    return $company['name'];
}

function get_company_name_by_venue($venue_id)
{
    $venue = Venue::find($venue_id);

    if($venue)
    {
       return $venue->company->name;
    } else {
        return '';
    }
}

function to_array($objs)
{
    $array = [];
    foreach ($objs as $obj){
        $array[] = $obj;
    }
    return $array;
}

function paginate($items, $perPage)
{
    $pageStart           = request('page', 1);
    $offSet              = ($pageStart * $perPage) - $perPage;
    $itemsForCurrentPage = array_slice($items, $offSet, $perPage, TRUE);

    return new LengthAwarePaginator(
        $itemsForCurrentPage, count($items), $perPage,
        Paginator::resolveCurrentPage(),
        ['path' => Paginator::resolveCurrentPath()]
    );
}

function generate_pagination($objs, $page_num)
{
    $pagination = '';
    if ($objs->lastPage() > 1){
        $pagination .= '<ul class="pagination">';
        $pagination .= '<li class="';
        if ($objs->currentPage() == 1) {
            $pagination .= 'disabled';
        } else {
            $pagination .= '';
        }
        $pagination .= '">';
        $pagination .= '<a href='.$objs->url(1).'&paginate='. $page_num .'>«</a>';
        $pagination .= '</li>';

        for ($i = 1; $i <= $objs->lastPage(); $i++){
            $pagination .= '<li class="';
            if ($objs->currentPage() == $i) {
                $pagination .= 'active';
            } else {
                $pagination .= '';
            }
            $pagination .= '">';

            $pagination .= '<a href='.$objs->url($i).'&paginate='. $page_num .'>'. $i .'</a>';
            $pagination .= '</li>';
        }

        $pagination .= '<li class="';
        if ($objs->currentPage() == $objs->lastPage()) {
            $pagination .= 'disabled';
            $pagination .= '">';
            $pagination .= '<a>»</a>';

        } else {
            $pagination .= '';
            $pagination .= '">';
            $pagination .= '<a href='.$objs->url($objs->currentPage()+1).'&paginate='. $page_num .'>»</a>';
        }
        $pagination .= '</li>';
//        $pagination .= '<img src='. url('/images/lodding.gif').' width="40" id="pagination_lodding" style="display:none">';

        return $pagination;
    }
}

function init_countries_plugins()
{
    return new Countries(new Config([
        'hydrate' => [
            'elements' => [
//                'currencies' => true,
//                    'flag' => true,
//                    'timezones' => true,
                'cities' => true,
            ],
        ],
    ]));
}

function get_cities_for_country($country_name)
{
    $countries_plugin = init_countries_plugins();
    $cities_array = $countries_plugin->where('name.common', $country_name)->pluck('cities')->first();

    return $cities_array->all()->pluck('name');
}

function get_all_cities()
{
    $countries_plugin = init_countries_plugins();
    $cities_array = $countries_plugin->all();

    $array = [];

    foreach ($cities_array->all()->pluck('cities') as $cities_arr)
    {
        foreach ($cities_arr as $cities)
        {
            if(isset($cities['name']))
            {
                $array[] = $cities['name'];
            }
        }
    }

    return $array;
}

function outputJSON($message = '', $responseCode = 200, $result = null) {
    $response["message"] = $message;
    $response["code"] = $responseCode;
    $response["data"] = $result;

    return response()->json($response);
}

function get_sitting_plan_imagename($sitting_id)
{
    $plan = \App\Models\Site\SittingPlan::find($sitting_id);

    return $plan->image;
}
function get_sitting_plan_name($sitting_id)
{
    $plan = \App\Models\Site\SittingPlan::find($sitting_id);

    return $plan->title;
}
function get_addons($addon_id)
{
    $plan = \App\Models\Site\SittingPlan::find($addon_id);

    return $plan->title;
}
function get_amenity_image($amenities_id)
{
    $data = \App\Models\Site\Amenities::find($amenities_id);
    return $data->image;
}

function get_amenity_name($amenities_id)
{
    $data = \App\Models\Site\Amenities::find($amenities_id);
    return $data->name;
}


function getAmenitiesByVenueId($venue_id)
{
    $data = \App\Models\Site\Venues::find($venue_id);
    return $data->name;
}

function get_city_by_venue($venue_id)
{
    $data = Venue::find($venue_id);
    return $data->city;
}

function get_space($space_id)
{
    return Spaces::find($space_id);
}

function numberTowords($num)
{
    $ones = array(
        1 => "One",
        2 => "Two",
        3 => "Three",
        4 => "Four",
        5 => "Five",
        6 => "Six",
        7 => "Deven",
        8 => "Eight",
        9 => "Nine",
        10 => "Ten",
        11 => "Eleven",
        12 => "Twelve",
        13 => "Thirteen",
        14 => "Fourteen",
        15 => "Fifteen",
        16 => "Sixteen",
        17 => "Seventeen",
        18 => "Eighteen",
        19 => "Nineteen"
    );
    $tens = array(
        1 => "ten",
        2 => "twenty",
        3 => "thirty",
        4 => "forty",
        5 => "fifty",
        6 => "sixty",
        7 => "seventy",
        8 => "eighty",
        9 => "ninety"
    );
    $hundreds = array(
        "hundred",
        "thousand",
        "million",
        "billion",
        "trillion",
        "quadrillion"
    ); //limit t quadrillion
    $num = number_format($num,2,".",",");
    $num_arr = explode(".",$num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",",$wholenum));
    krsort($whole_arr);
    $rettxt = "";
    foreach($whole_arr as $key => $i){
        if($i < 20){
            $rettxt .= $ones[$i];
        }elseif($i < 100){
            $rettxt .= $tens[substr($i,0,1)];
            $rettxt .= " ".$ones[substr($i,1,1)];
        }else{
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
            $rettxt .= " ".$tens[substr($i,1,1)];
            $rettxt .= " ".$ones[substr($i,2,1)];
        }
        if($key > 0){
            $rettxt .= " ".$hundreds[$key]." ";
        }
    }
    if($decnum > 0){
        $rettxt .= " and ";
        if($decnum < 20){
            $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
    }
    return $rettxt;
}

function get_venue($venue_id)
{
    return Venue::find($venue_id);
}

function get_venue_title($venue_id)
{
    $veune = Venue::find($venue_id);
    return $veune['title'];
}

function get_space_title($space_id)
{
    $space = Spaces::find($space_id);
    return $space['title'];
}

function check_wish_list($id, $item)
{
    if(Auth::check()){
        $user_id = Auth::user()->id;
    } else {
        $user_id = 0;
    }
    $wishlist = Wishlist::where('user_id', $user_id)
        ->where('list_name', $item)
        ->where('item_id', $id)
        ->first();

    if ($wishlist){
        return true;
    } else {
        return false;
    }
}

function get_space_reviews_avg($space_id)
{
    $space = Spaces::find($space_id);

    if($space['reviews_total'])
    {
        return $space['reviews_total'];
    } else {
        return 0;
    }
}

function get_space_reviews_count($space_id)
{
    return Review::where('space_id', $space_id)->where('r_status', 1)->count();
}

function get_stars_view($value){
    $total_average_percentage = ($value/5) * 100;
    $html = '   <div class="star-ratings-css">
    <div class="star-ratings-css-top" style="width:'. $total_average_percentage. '%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
    <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
    </div>';
    return  $html;

}

function get_booking_review_status($booking_id)
{
    $booking = \App\Models\Site\BookingInfo::find($booking_id);
    return $booking['review_status'];
}

function get_user_email($user_id){
    $user = \App\Models\Site\User::find($user_id);
    return $user['email'];
}

function generate_booking_number()
{
    $booking = BookingInfo::latest()->first();

    if($booking)
    {
        $booking_arr = explode('-', $booking['booking_number']);

        if(isset($booking_arr['2']))
        {
            $number = "CO-" . date('Ymd') . "-". ($booking_arr['2'] + 1);
        } else{
            $number = "CO-" . date('Ymd') . "-". "100";
        }

    } else {
        $number = "CO-" . date('Ymd') . "-". "100";
    }

    return $number;
}

function calculate_growth($current_growth, $last_growth)
{
    if($last_growth == 0 || $current_growth == 0)
    {
        return '0';
    } else {
        return number_format((($current_growth - $last_growth)/$last_growth)*100);
    }
}

function calculate_percentage($current_value, $totel_value)
{
    if($totel_value == 0 || $current_value == 0)
    {
        return '0';
    } else {
        return number_format(($current_value/$totel_value)*100); // this percentage
    }
}

function get_spacetype_by_space($space_id)
{
    $space = Spaces::find($space_id);
    $space_types = $space->spaceTypes;

    if(isset($space_types[0]['title']))
    {
        return $space_types[0]['title'];
    } else {
        return '';
    }
}

function user_batch_category($user_id){
    $bookings = BookingInfo::where('user_id', $user_id)->where('status', 1)->whereDate('end_date', '<=', Carbon::today())->count();
    $silver = Discount::where('type', 'silver')->first();
    $gold = Discount::where('type', 'gold')->first();
    $platinum = Discount::where('type', 'platinum')->first();

    if($bookings > 0) {
        if ($bookings >= $platinum->no_of_booking) {
            return 'Platinum';
        } elseif ($bookings >= $gold->no_of_booking && $bookings > $silver->no_of_booking && $bookings < $platinum->no_of_booking) {
            return 'Gold';
        } elseif ($bookings >= $silver->no_of_booking && $bookings < $gold->no_of_booking && $bookings < $platinum->no_of_booking) {
            return 'Silver';
        } else {
            return 'Classic';
        }
    }else{
        return false;
    }
}

function check_time_is_within_range($start_date, $end_date, $todays_date)
{

    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    $today_timestamp = strtotime($todays_date);

    return (($today_timestamp >= $start_timestamp) && ($today_timestamp <= $end_timestamp));

}