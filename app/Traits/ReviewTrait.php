<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Site\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait ReviewTrait
{
    protected function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;
        return response()->json($response);
    }


    public function  create_review(Request $request)
    {
        $total_stars = ((int)$request->input('customer_service_rate') +
            (int)$request->input('amenities_rate') +
            (int)$request->input('meeting_facility_rate') +
            (int)$request->input('food_rate'));

        $review_status = get_booking_review_status($request->input('booking_id'));

        if($review_status == 0)
        {
            $review = Review::updateOrCreate(
                [
//                'id' => $request->input('review_id'),
                    'user_id' => Auth::user()->id,
                    'space_id' => $request->input('space_id'),
                    'booking_id' => $request->input('booking_id'),
                ],
                [
//                'user_id' => Auth::user()->id,
//                'space_id' => $request->input('space_id'),
//                'booking_id' => $request->input('booking_id'),
                    'feedback' => $request->input('feedback'),
                    'customer_service_rate' => $request->input('customer_service_rate'),
                    'amenities_rate' => $request->input('amenities_rate'),
                    'meeting_facility_rate' => $request->input('meeting_facility_rate'),
                    'food_rate' => $request->input('food_rate'),
                    'total_stars' => $total_stars,
                    'r_status' => 0
                ]);
            return $this->outputJSON('Review Successfully Submitted', 201, $review);
        } else {
            return $this->outputJSON("You're not allow to update review", 401, null);
        }
    }

    public function  get_all_reviews()
    {
        $reviews = Review::all();
        return $this->outputJSON('All Reviews', 201 , $reviews);
    }

    public function  get_user_reviews()
    {
        $reviews = Review::where('user_id' , Auth::user()->id)->get();
        if(count($reviews) > 0)
        {
            return $this->outputJSON('User Review', 201 , $reviews);
        } else {
            return $this->outputJSON('No Reviews found', 404 , $reviews);
        }
    }




}