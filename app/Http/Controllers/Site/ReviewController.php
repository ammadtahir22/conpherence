<?php

namespace App\Http\Controllers\Site;

use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\BookingInfo;
use App\Models\Site\Credit_card;
use App\Models\Site\FoodDuration;
use App\Models\Site\Individual;
use App\Models\Site\Review;
use App\Models\Site\SittingPlan;
use App\Models\Site\User;
use App\Traits\BookingTrait;
use App\Traits\ReviewTrait;
use App\Traits\SpacesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\SpacesType;
use App\Models\Site\Company;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use ReviewTrait;
    //
    public function index($booking_id)
    {
        $bookinginfo = BookingInfo::where('id', $booking_id)->first();
        $booking_space = $bookinginfo->space;
        $booking_space_venue = $booking_space->venue;
        $review = Review::where('booking_id' , $booking_id)->first();
        $form_status = '';
        if($review){
            $review_status = $review->r_status;
            if($review_status == '1') $form_status = 'disabled';
            else $form_status = '';
        }
        return view('site/individuals/dashboard_pages/add_reviews' , compact('review', 'bookinginfo' , 'booking_space' , 'booking_space_venue' , 'form_status'));

    }



    /*********************************************************************************************************/

    public function save_reviews(Request $request){



        $response = $this->create_review($request);


        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);

        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Space not saved');
        }

        return redirect()->route('user.dashboard.reviews');
    }

    public function get_reviews(){
        $all_reviews = $this->get_all_reviews();
        return view('site/companies/dashboard_pages/bookings',compact('all_reviews'));
    }


    public function ReviewSearch(Request $request)
    {
        $output="";
        $user = Auth::user();
        $search_order = $request->search_order;
        if(empty($search_order)){
            $search_order = "desc";
        }
        $final_result = BookingInfo::where('user_id', $user->id)->where('status' , '1')->where('review_status' , $request->activetab)
            ->whereDate('end_date' , '<' , Carbon::today())->orderBy('created_at',$search_order)->get();
        if($request->search != '') {
            $final_result = array();
            $spaces_arr = [];
            $venue_arr = [];
            $s_booking_id = [];

            $spaces = Spaces::where('title', 'LIKE', '%' . $request->search . "%")->get();
            $venues = Venue::where('title', 'LIKE', '%' . $request->search . "%")->get();
            if (count($spaces) > 0) {
                foreach ($spaces as $space) {
                    $spaces_arr[] = $space->id;
                }
            }
            if (count($venues) > 0) {
                foreach ($venues as $venue) {
                    $venue_arr[] = $venue->id;
                }
            }
            //dd($venue_arr);
            $result_booking['space'] = BookingInfo::whereIn('space_id', $spaces_arr)->where('user_id', $user->id)->where('status', '1')
                ->where('review_status' , $request->activetab)->whereDate('end_date', '<', Carbon::today())->orderBy('created_at',$search_order)->get();

            if(count($result_booking['space']) > 0){
                foreach ($result_booking['space'] as $s_booking){
                    $s_booking_id[] = $s_booking->id;
                }
            }
            $result_booking['venue'] = BookingInfo::whereNotIn('id', $s_booking_id)->whereIn('venue_id', $venue_arr)->where('user_id', $user->id)->where('status', '1')
                ->where('review_status' , $request->activetab)->whereDate('end_date', '<', Carbon::today())->orderBy('created_at',$search_order)->get();

            foreach ($result_booking['venue'] as $s_venue) {
                array_push($final_result, $s_venue);
            }

            foreach ($result_booking['space'] as $s_space) {
                array_push($final_result, $s_space);
            }
        }
        $total_p_booking = 0;
        $total_a_booking = 0;
        if(count($final_result) > 0) {
            foreach ($final_result as $book) {

                $booking_id = $book->id;
                $booking_space = $book->space;
                $booking_space_venue = $booking_space->venue;
                $total_a_booking++;
                if ($book->review) {
                    $review_date = date('Y-M-d', strtotime($book->review->created_at));
                } else {
                    $review_date = '';
                }
                $created_at = date('d-M', strtotime($book->created_at));
                if($request->activetab == 1) {
                    $review = $book->review->total_stars;
                    $review = number_format((float)$review / 4, 1, '.', '');
                }
                $json = json_decode($booking_space->reviews_count);

                $output .= '<div class="book-list review-list search-result std_pnd_search_res">' .
                    '<div class="b-list-info col-sm-5">' .
                    '<h4>' . $booking_space_venue->title . '</h4>' .
                    '<h3>' . $booking_space->title . '</h3>' .
                    '<h5><a href="#">' . $booking_space_venue->city . '</a>';
                    if($request->activetab == 1){
                        $output .= '<span>Reviewed on ' . $review_date . '</span>';
                    }
                    $output .= '</h5>' .
                    '</div>' .
                    '<div class="b-list-date col-sm-3">' .
                    '<p>' . $created_at . '<span>' . $book->purpose . '</span></p>' .
                    '</div><div class="b-list-rate col-sm-3">';
                if($request->activetab == 1) {
                    $output .= '<p>' . $review . get_stars_view($review) . '</p>';
                }
                $output .= '</div><div class="b-list-btn col-sm-1">' .
                    '<a href="' . url('user/add_review/' . $booking_id) . '" class="btn get-btn">' .
                    '<span>View Review </span><span></span><span></span><span></span><span></span>' .
                    '</a>' .
                    '</div>' .
                '</div>';
            }
        }else{
            $output .= '<div id="r_pending" class="pay-inner-card"><div class="dash-pay-gray"> Record Not Found.</div></div>';
        }
//        return Response($output);
        return response()->json(['html' => $output, 'counter' => count($final_result)]);
    }


    public function ReviewSort(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $user = Auth::user();
            $user = Auth::user();
            $booking = BookingInfo::where('user_id', $user->id)->where('status' , '1')->whereDate('end_date' , '<' , Carbon::today())->orderBy('created_at', $request->sort)->get();

            $total_p_booking = 0;
            $total_a_booking = 0;
            if(count($booking) > 0) {
                foreach ($booking as $book) {

                    $booking_id = $book->id;
                    $booking_space = $book->space;
                    $booking_space_venue = $booking_space->venue;
                    if ($book->review_status == '1') {
                        $total_a_booking++;
                        if ($book->review) {
                            $review_date = date('Y-M-d', strtotime($book->review->created_at));
                        } else {
                            $review_date = '';
                        }
                        $created_at = date('d-M', strtotime($book->created_at));
                        $review = $book->review->total_stars;
                        $review = number_format((float)$review / 4, 1, '.', '');
                        $json = json_decode($booking_space->reviews_count);

                        $output .= '<div class="book-list review-list">' .
                            '<div class="b-list-info col-sm-5">' .
                            '<h4>' . $booking_space_venue->title . '</h4>' .
                            '<h3>' . $booking_space->title . '</h3>' .
                            '<h5><a href="#">' . $booking_space_venue->city . '</a><span>Reviewed on ' . $review_date . '</span></h5>' .
                            '</div>' .
                            '<div class="b-list-date col-sm-3">' .
                            '<p>' . $created_at . '<span>' . $book->purpose . '</span></p>' .
                            '</div>' .
                            '<div class="b-list-rate col-sm-3">' .
                            '<p>' . $review . get_stars_view($review) . '</p>' .
                            '</div>' .
                            '<div class="b-list-btn col-sm-1">' .
                            '<a href="' . url('user/add_review/' . $booking_id) . '" class="btn get-btn">' .
                            '<span>View Review </span><span></span><span></span><span></span><span></span>' .
                            '</a>' .
                            '</div>' .


                            '</div>';

                    }


                }

            }
            return Response($output);

        }
    }

}
