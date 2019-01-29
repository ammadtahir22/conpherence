<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 10/17/2018
 * Time: 5:09 PM
 */

namespace App\Traits;

use App\Models\Admin\SpacesType;
use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\BookingInfo;
use App\Models\Site\FoodDuration;
use App\Models\Site\SittingPlan;
use App\Models\Site\Spaces;
use App\Models\Site\User;
use App\Models\Site\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


trait SearchTrait
{
    public function search_venue(Request $request)
    {

        $venues = (new Venue)->newQuery();

        $venues->orderBy('created_at', 'desc');
        // Search for a venue based on their location.
        if ($request->has('location')) {
            $venues->where('city', $request->input('location'));
        }


        // Search for a venue based on people.
        if ($request->has('people')) {
            $venues->whereHas('spaceCapacities', function ($query) use ($request) {
                $query->where('capacity', '>=' , $request->input('people'));
            });
        }

        // Search for a venue based on people.
//        if(($request->has('duration')) && ($request->input('duration') != 'More than one day'))
//        {
//            $venues->whereHas('foodDuration', function ($query) use ($request) {
//                $query->where('food_duration', $request->input('duration'));
//            });
//        }

        $venues = $venues->get();

        // Search for a venue based on booking date.
        if($request->input('start_date') != null) {
            $start_date = Carbon::parse($request->input('start_date'));
            $end_date = Carbon::parse($request->input('start_date'));
            if($request->input('end_date') != null){

                $end_date = Carbon::parse($request->input('end_date'));
            }
            $range = [$start_date, $end_date];

            $bookings = BookingInfo::orwhereRaw('? between start_date and end_date', [$start_date])
                ->orWhereRaw('? between start_date and end_date', [$end_date])
                ->orWhereBetween('end_date', [$range])
                ->orWhereBetween('start_date', [$range])
                ->orwhere('start_date', $start_date)
                ->orwhere('end_date', $end_date)
                ->get();

//            dd($bookings);

            $space_arr = [];

            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking)
                {
                    $space_arr[] = $booking->space_id;
                }

                foreach ($bookings as $booking)
                {
                    $venue_space_ids_arr = $booking->space->venue->spaces->pluck('id')->toArray();

                    $booked_space_arr = [];

                    if(($request->input('duration') != null) && ($request->input('duration') != 'Full Day')) {
                        $duration_arr = [];

                        foreach ($booking->bookingFoods as $bookingFood) {
                            $duration_arr[] = $bookingFood->foodCategory->foodDuration->food_duration;
                        }


                        if (in_array($request->input('duration'), $duration_arr)) {
                            foreach ($bookings as $inner_booking)
                            {
                                $booked_space_arr[] = $inner_booking->space_id;
                            }

                        }

                    } else {
                        foreach ($bookings as $inner_booking)
                        {
                            $booked_space_arr[] = $inner_booking->space_id;
                        }
                    }

                    if(count(array_intersect($venue_space_ids_arr, $booked_space_arr)) == count($venue_space_ids_arr))
                    {
                        $venue_id = $booking->venue_id;
                        $venues = $venues->filter(function($venue) use ($venue_id)
                        {
                            return $venue->id != $venue_id;
                        });
                    }

//
//
//                    $venues = $venues->filter(function($venue) use ($venue_id)
//                    {
//                        return $venue->id != $venue_id;
//                    });
                }
            }
        }

        // Search for a venue based on Space type.
        if($request->has('space_type'))
        {
            $space_type = SpacesType::where('slug', $request->input('space_type'))->whereHas('spaces')->first();
            $venues = (new Venue)->newQuery();
            $venues->orderBy('created_at', 'desc');

            $space_type_arr = [];

            if(isset($space_type))
            {
                foreach ($space_type->spaces as $key=>$space)
                {
                    $space_type_arr[] = $space->id;
                }
            }



            $venues->whereHas('spaces', function ($query) use ($space_type_arr) {
                $query->whereIn('id', $space_type_arr);
            });

            $venues = $venues->get();
//            array_unique($venues, SORT_REGULAR);
        }

        return outputJSON('Venues found', 200, $venues);
    }

    public function search_venue_ajax(Request $request)
    {

        $venues = (new Venue)->newQuery();

        $venues->where('status', 1)->whereHas('spaces')->orderBy('created_at', $request->input('orderby'));

        // Search for a venue based on their location.
        if ($request->input('location') != null) {
            $venues->where('city', $request->input('location'));
        }

        // Search for a venue based on people.
        if ($request->input('people') != null) {
            $venues->whereHas('spaceCapacities', function ($spaceCapacity_query) use ($request) {
                $spaceCapacity_query->where('capacity', '>=' , $request->input('people'));
            });
        }

        // Search for a venue based on food duration.
//        if(($request->input('duration') != null) && ($request->input('duration') != 'More than one day')) {
//            $venues->whereHas('foodDuration', function ($duration_query) use ($request) {
//                $duration_query->where('food_duration', $request->input('duration'));
//            });
//        }

        // Search a venue based on food .
        if($request->input('food_checkboxes_arr') != null) {
            $food_checkboxes_arr = explode(',',$request->input('food_checkboxes_arr'));
            $venues->whereHas('foodCategory', function ($foodCategory_query) use ($food_checkboxes_arr) {
                $foodCategory_query->whereIn('title', $food_checkboxes_arr);
            });
        }

        // Search a venue based on Space Type.
        if($request->input('spacetype_checkboxes_arr') != null) {
            $spacetype_checkboxes_arr = explode(',',$request->input('spacetype_checkboxes_arr'));
            $space_types = SpacesType::whereIn('title', $spacetype_checkboxes_arr)->get();
            $space_type_arr = [];
            if(count($space_types) > 0)
            {
                foreach ($space_types as $space_type)
                {
                    foreach ($space_type->spaces as $key=>$space)
                    {
                        $space_type_arr[] = $space->id;
                    }
                }
            }

            $venues->whereHas('spaces', function ($query) use ($space_type_arr) {
                $query->whereIn('id', $space_type_arr);
            });
        }

//        Search a venue based on amenities.
        if($request->input('amenities_checkboxes_arr') != null) {
            $amenities_checkboxes_arr = explode(',', $request->input('amenities_checkboxes_arr'));
            $amenities = Amenities::whereIn('name', $amenities_checkboxes_arr)->get();

            $amenities_arr = [];
            if (count($amenities) > 0) {
                foreach ($amenities as $amenity) {
                    foreach ($amenity->venues as $key => $amenity_venue) {
                        $amenities_arr[] = $amenity_venue->id;
                    }
                }
            }

            $venues->whereIn('id', $amenities_arr);
        }

        // Search for a venue based on people.
        if($request->input('accessibility_checkboxes_arr') != null) {
            $accessibility_checkboxes_arr = explode(',',$request->input('accessibility_checkboxes_arr'));
            $accessabilities = Accessibility::whereIn('name', $accessibility_checkboxes_arr)->get();

            $accessabilities_arr = [];
            if(count($accessabilities) > 0)
            {
                foreach ($accessabilities as $accessibility)
                {
                    foreach ($accessibility->spaces as $key=>$space)
                    {
                        $accessabilities_arr[] = $space->id;
                    }
                }
            }

            $venues->whereHas('spaces', function ($accessibility_query) use ($accessabilities_arr) {
                $accessibility_query->whereIn('id', $accessabilities_arr);
            });
        }

        // Search for a venue based on reviews.
        if($request->input('star_checkboxes_arr') != null) {
            $star_checkboxes_arr = $request->input('star_checkboxes_arr');

            $venues->whereRaw('round(venues.reviews) IN ('.$star_checkboxes_arr.')');
        }

        // Search a venue based on space price.
        if($request->input('minimum_price') != null && $request->input('maximum_price') != null) {
            $spaces = Spaces::where('price', '>=',$request->input('minimum_price'))
                ->where('price', '<=',$request->input('maximum_price'))->get();
            $space_arr = [];
            if(count($spaces) > 0)
            {
                foreach ($spaces as $space)
                {
                    $space_arr[] = $space->id;
                }
            }
            $venues->whereHas('spaces', function ($query) use ($space_arr) {
                $query->whereIn('id', $space_arr);
            });
        }


        // Search a venue based on Space Type.
        if($request->input('seating_arrangement_checkboxes_arr') != null ) {
            $seating_arrangement_checkboxes_arr = explode(',',$request->input('seating_arrangement_checkboxes_arr'));
            $sitting_plans = SittingPlan::whereIn('title', $seating_arrangement_checkboxes_arr)->get();

            $sitting_plans_arr = [];
            if(count($sitting_plans) > 0)
            {
                foreach ($sitting_plans as $sitting_plan)
                {
                    foreach ($sitting_plan->sittingPlanCapacity as $key=>$sittingPlanCapacity)
                    {
                        $sitting_plans_arr[] = $sittingPlanCapacity->id;
                    }
                }
            }

            $venues->whereHas('spaces', function ($query) use ($sitting_plans_arr) {
                $query->whereIn('id', $sitting_plans_arr);
            });
        }


        $venues = $venues->get();
        // Search for a venue based on booking date.
        if($request->input('start_date') != null) {
            $start_date = Carbon::parse($request->input('start_date'));
            $end_date = Carbon::parse($request->input('start_date'));
            if($request->input('end_date') != null){

                $end_date = Carbon::parse($request->input('end_date'));
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
                    $venue_space_ids_arr = $booking->space->venue->spaces->pluck('id')->toArray();
                    $booked_space_arr = [];

                    if(($request->input('duration') != null) && ($request->input('duration') != 'Full Day')) {
                        $duration_arr = [];

                        foreach ($booking->bookingFoods as $bookingFood) {
                            $duration_arr[] = $bookingFood->foodCategory->foodDuration->food_duration;
                        }


                        if (in_array($request->input('duration'), $duration_arr)) {
                            foreach ($bookings as $inner_booking)
                            {
                                $booked_space_arr[] = $inner_booking->space_id;
                            }

                        }

                    } else {
                        foreach ($bookings as $inner_booking)
                        {
                            $booked_space_arr[] = $inner_booking->space_id;
                        }
                    }

                    if(count(array_intersect($venue_space_ids_arr, $booked_space_arr)) == count($venue_space_ids_arr))
                    {
                        $venue_id = $booking->venue_id;
                        $venues = $venues->filter(function($venue) use ($venue_id)
                        {
                            return $venue->id != $venue_id;
                        });
                    }
                }
            }
        }

//        $venues = $venues->get()->toArray();


        if(count($venues) > 0)
        {
            return outputJSON('Venues found', 200, $venues);
        } else {
            return outputJSON('Venues not found', 404, $venues);
        }

    }

    public function search_space(Request $request)
    {
        $spaces = (new Spaces)->newQuery();

        $spaces->orderBy('created_at', 'desc')->where('venue_id', $request->input('venue_id'));

        // Search for a venue based on people.
        if ($request->has('people') & $request->input('people') != null) {
//            dd('adad');
            $spaces->whereHas('spaceCapacityPlan', function ($query) use ($request) {
                $query->where('capacity', '>=' , $request->input('people'));
            });
        }

        // Search for a venue based on food duration.
//        if(($request->input('duration') != null) && ($request->input('duration') != 'More than one day')) {
//            $spaces->whereHas('foodDuration', function ($duration_query) use ($request) {
//                $duration_query->where('food_duration', $request->input('duration'));
//            });
//        }

        $spaces = $spaces->get();

        // Search for a venue based on booking date.
        if($request->input('start_date') != null) {
            $start_date = Carbon::parse($request->input('start_date'));
            $end_date = Carbon::parse($request->input('start_date'));
            if($request->input('end_date') != null){

                $end_date = Carbon::parse($request->input('end_date'));
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
                    $space_id = $booking->space_id;

                    // Search for a space based on duration.
                    if(($request->input('duration') != null) && ($request->input('duration') != 'Full Day')) {
                        $duration_arr = [];
                        foreach ($booking->bookingFoods as $bookingFood)
                        {
                            $duration_arr[] = $bookingFood->foodCategory->foodDuration->food_duration;
                        }

                        if(in_array($request->input('duration'), $duration_arr))
                        {
                            $spaces = $spaces->filter(function($space) use ($space_id)
                            {
                                return $space->id != $space_id;
                            });
                        }
                    } else {
                        $spaces = $spaces->filter(function($space) use ($space_id)
                        {
                            return $space->id != $space_id;
                        });
                    }


//                    dd($spaces) ;

                }
            }
        }

        return $spaces;
    }
}