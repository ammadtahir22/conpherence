<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use App\Models\Site\Wishlist;
use App\Traits\WishListTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishListController extends Controller
{
   use WishListTrait;

   public function save(Request $request)
   {
       $response = $this->save_wishlist($request);

//       if ($response->getData()->code == 201)
//       {
//           session()->flash('msg-success', $response->getData()->message);
//       } elseif ($response->getData()->code == 400)
//       {
//           session()->flash('msg-error', $response->getData()->message);
//       } else {
//           session()->flash('msg-error', 'Wishlist not saved');
//       }

       return response()->json('Wishlist added',$response->getData()->code);
   }

    public function remove(Request $request)
    {

        $response = $this->remove_wishlist($request);

//        if ($response->getData()->code == 201)
//        {
//            session()->flash('msg-success', $response->getData()->message);
//        } elseif ($response->getData()->code == 400)
//        {
//            session()->flash('msg-error', $response->getData()->message);
//        } else {
//            session()->flash('msg-error', 'Wishlist not saved');
//        }

        return response()->json($response->getData()->message,$response->getData()->code);
    }

    public function UserWishlistSearch(Request $request)
    {

        $output = "";
        $user = Auth::user();
        $search_order = $request->search_order;
        if(empty($search_order)){
            $search_order = "desc";
        }

        if ($request->search != '') {
          //  dd($request->activetab);
            if ($request->activetab == 1) {

                $venues = Venue::orwhere('title', 'LIKE', '%' . $request->search . "%")->orwhere('city', 'LIKE', '%' . $request->search . "%")->get();
                //  dd($venues);
                $venues_arr = [];
                if (count($venues) > 0) {
                    foreach ($venues as $venue) {
                        $venues_arr[] = $venue->id;
                    }
                }


                $result_booking['venue'] = Wishlist::whereIn('item_id', $venues_arr)->where('list_name', 'venue')->where('user_id', $user->id)->orderBy('created_at',$search_order)->get();

                $final_result = array();
                foreach ($result_booking['venue'] as $s_venue) {
                    array_push($final_result, $s_venue);
                }

                if (count($final_result) > 0) {
                    foreach ($final_result as $wish_venue) {
                        $venue = get_venue($wish_venue->item_id);
                        // dd($venue);
                        //$json = json_decode($venue->reviews);
                       // $total_average_percentage = ($json[4] / 5) * 100;

                        $output .= '<div class="book-list" id="venue_box_' . $wish_venue->id . '">' .
                            '<div class="b-list-img col-sm-2">' .
                            '<img src="' . url('storage/images/venues/' . $venue->id . '/cover/' . $venue->cover_image) . '" alt="" />' .
                            '</div>' .
                            '<div class="b-list-info col-sm-5">' .
                            '<h3>' . $venue->title . '</h3>' .
                            '<h5><a href="#">' . $venue->city . '</a></h5>' .
                            '</div>' .
                            '<div class="b-list-rate col-sm-2">' .
                            $venue->reviews . get_stars_view($venue->reviews) .
                            '</div>' .
                            '<div class="widh-list-del col-sm-1">' .
                            '<a class="del-btn" onclick="remove_item_wishlist(' . $venue->id . ',venue,venue_box_' . $wish_venue->id . ',test)"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                            '</div>' .
                            '<div class="b-list-btn col-sm-2">' .
                            '<a href="' . url('venue/' . $venue->slug) . '" class="btn get-btn">' .
                            '<span>View Listing </span><span></span><span></span><span></span><span></span>' .
                            '</a>' .
                            '</div>' .


                            '</div>';

                    }

                }
            } else{

                $spaces = Spaces::where('title', 'LIKE', '%' . $request->search . "%")->get();
                $spaces_arr = [];
                if (count($spaces) > 0) {
                    foreach ($spaces as $space) {
                        $spaces_arr[] = $space->id;
                    }
                }

                $result_booking['space'] = Wishlist::whereIn('item_id', $spaces_arr)->where('list_name', 'space')->where('user_id', $user->id)->orderBy('created_at',$search_order)->get();
                $final_result = array();
                foreach ($result_booking['space'] as $s_space) {
                    array_push($final_result, $s_space);
                }


                if (count($final_result) > 0) {
                    foreach ($final_result as $wish_space) {
                        $space = get_space($wish_space->item_id);
                        // dd($venue);
                        $json = json_decode($space->reviews_count);
                        $total_average_percentage = ($json[4] / 5) * 100;

                        $output .= '<div class="book-list" id="space_box_' . $space->id . '">' .
                            '<div class="b-list-img col-sm-2">' .
                            '<img src="' . url('storage/images/spaces/' . $space->image) . '" alt="" />' .
                            '</div>' .
                            '<div class="b-list-info col-sm-5">' .
                            '<h4>' . $space->venue->title . '</h4>' .
                            '<h3>' . $space->title . '</h3>' .
                            '<h5><a href="#">' . $space->venue->city . '</a></h5>' .
                            '</div>' .
                            '<div class="b-list-rate col-sm-2">' .
                            $json[4] . get_stars_view($json[4]) .
                            '</div>' .
                            '<div class="widh-list-del col-sm-1">' .
                            '<a class="del-btn" onclick="remove_item_wishlist(' . $space->id . ',space,space_box_' . $wish_space->id . ',test)"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                            '</div>' .
                            '<div class="b-list-btn col-sm-2">' .
                            '<a href="' . url('venue/space/' . $space->slug) . '" class="btn get-btn">' .
                            '<span>View Listing </span><span></span><span></span><span></span><span></span>' .
                            '</a>' .
                            '</div>' .


                            '</div>';

                    }
                }

            }

            return Response($output);
        }else{
            $wish_venues = Wishlist::where('list_name', 'venue')->where('user_id', Auth::user()->id)->orderBy('created_at',$search_order)->get();
            $wish_spaces = Wishlist::where('list_name', 'space')->where('user_id', Auth::user()->id)->orderBy('created_at',$search_order)->get();

            if ($request->activetab == 1) {

                if (count($wish_venues) > 0) {
                    //dd($wish_venues);
                    foreach ($wish_venues as $wish_venue) {
                        $venue = get_venue($wish_venue->item_id);
                        // dd($venue);
                        $json = json_decode($venue->reviews);
                        $total_average_percentage = ($json[4] / 5) * 100;

                        $output .= '<div class="book-list" id="venue_box_' . $wish_venue->id . '">' .
                            '<div class="b-list-img col-sm-2">' .
                            '<img src="' . url('storage/images/venues/' . $venue->id . '/cover/' . $venue->cover_image) . '" alt="" />' .
                            '</div>' .
                            '<div class="b-list-info col-sm-5">' .
                            '<h3>' . $venue->title . '</h3>' .
                            '<h5><a href="#">' . $venue->city . '</a></h5>' .
                            '</div>' .
                            '<div class="b-list-rate col-sm-2">' .
                            $json[4] . get_stars_view($json[4]) .
                            '</div>' .
                            '<div class="widh-list-del col-sm-1">' .
                            '<a class="del-btn" onclick="remove_item_wishlist(' . $venue->id . ',venue,venue_box_' . $wish_venue->id . ',test)"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                            '</div>' .
                            '<div class="b-list-btn col-sm-2">' .
                            '<a href="' . url('venue/' . $venue->slug) . '" class="btn get-btn">' .
                            '<span>View Listing </span><span></span><span></span><span></span><span></span>' .
                            '</a>' .
                            '</div>' .


                            '</div>';

                    }

                } else {
                    $output .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No Records added yet. </div></div>';
                }
                return Response($output);
            }else{

                if (count($wish_spaces) > 0) {
                    foreach ($wish_spaces as $wish_space) {
                        $space = get_space($wish_space->item_id);
                        // dd($venue);
                        $json = json_decode($space->reviews_count);
                        $total_average_percentage = ($json[4] / 5) * 100;

                        $output .= '<div class="book-list" id="space_box_' . $space->id . '">' .
                            '<div class="b-list-img col-sm-2">' .
                            '<img src="' . url('storage/images/spaces/' . $space->image) . '" alt="" />' .
                            '</div>' .
                            '<div class="b-list-info col-sm-5">' .
                            '<h4>' . $space->venue->title . '</h4>' .
                            '<h3>' . $space->title . '</h3>' .
                            '<h5><a href="#">' . $space->venue->city . '</a></h5>' .
                            '</div>' .
                            '<div class="b-list-rate col-sm-2">' .
                            $json[4] . get_stars_view($json[4]) .
                            '</div>' .
                            '<div class="widh-list-del col-sm-1">' .
                            '<a class="del-btn" onclick="remove_item_wishlist(' . $space->id . ',space,space_box_' . $wish_space->id . ',test)"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                            '</div>' .
                            '<div class="b-list-btn col-sm-2">' .
                            '<a href="' . url('venue/space/' . $space->slug) . '" class="btn get-btn">' .
                            '<span>View Listing </span><span></span><span></span><span></span><span></span>' .
                            '</a>' .
                            '</div>' .


                            '</div>';

                    }

                } else {
                    $output .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No Records added yet. </div></div>';
                }
                return Response($output);

            }
        }
    }

}
