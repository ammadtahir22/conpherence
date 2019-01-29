<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\SpacesType;
use App\Models\Admin\Venue_category;
use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\Company;
use App\Models\Site\FoodType;
use App\Models\Site\SittingPlan;
use App\Models\Site\SpaceCapacityPlan;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use App\Traits\SearchTrait;
use App\Traits\VenueTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use PragmaRX\Countries\Package\Countries;
use PragmaRX\Countries\Package\Services\Config;


class VenueController extends Controller
{
    use VenueTrait;
    use SearchTrait;
    /**
     * NewsController constructor.
     */
    public function __construct()
    {

    }

    public function get_venue($slug, Request $request)
    {
//        dd($request);
        $people = $request->input('people');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $duration = $request->input('duration');

        if ($request->isMethod('post')) {
            $venue = Venue::where('id', $request->input('venue_id'))->first();
            $spaces = paginate(to_array($this->search_space($request)),10);
        } else {
            $venue = Venue::where('slug', $slug)->first();
            $spaces = $venue->spaces()->where('status', 1)->paginate(10);
        }


        $slider_images= [];

        if ($venue)
        {
            if(isset($venue->images))
            {
                $slider_images = json_decode($venue->images);
            }

//            dd($spaces);

            return view('site.venue.venue-detail', compact('venue','spaces', 'people', 'duration', 'start_date', 'end_date', 'slider_images'));
        } else {
            session()->flash('msg-error', 'Venue Not Found');
            return redirect()->back();
        }

    }

    public function venue_search_for_all(Request $request)
    {
        $location = $request->input('location');
        $people = $request->input('people');
        $duration = $request->input('duration');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $response = $this->search_venue($request);

        $food_types = FoodType::orderBy('created_at', 'desc')->limit(6)->get();
        $space_types = SpacesType::orderBy('created_at', 'desc')->limit(6)->get();
        $amenities = Amenities::orderBy('created_at', 'desc')->limit(6)->get();
        $accessibilities = Accessibility::orderBy('created_at', 'desc')->limit(3)->get();
//        $stars = Accessibility::limit(3)->get();
        $seating_plans = SittingPlan::orderBy('created_at', 'desc')->limit(6)->get();

        $venues = paginate(to_array($response->getData()->data),12);

        return view('site/venue/venue-index', compact('food_types','seating_plans','accessibilities','amenities','space_types','venues', 'people', 'location', 'duration', 'start_date', 'end_date'));
    }

    public function venue_filter_ajax(Request $request)
    {
        $people = $request->has('people') ? $request->input('people') : "";
        $duration = $request->has('duration') ? $request->input('duration') : "";
        $start_date = $request->has('start_date') ? $request->input('start_date') : "";
        $end_date = $request->has('end_date') ? $request->input('end_date') : "";

        $response = $this->search_venue_ajax($request);

        $venues = paginate(to_array($response->getData()->data),12);

        $data = '';
        $pagination = $venues->links();
        $count = count($venues);

        if($count > 0)
        {
            foreach ($venues as $venue)
            {
                $venue_url = url("venue/".$venue->slug);
                $form_id = "filter_space_form_".$venue->id;
                $average = ($venue->reviews/5)*100;

                $data .= ' <form action="'.$venue_url.'" method="post" id="'.$form_id.'">';
                $data .= '<input type="hidden" name="venue_id" value="'.$venue->id.'">';
                $data .= '<input type="hidden" name="people" value="'.$people.'">';
                $data .= '<input type="hidden" name="duration" value="'.$duration.'">';
                $data .= '<input type="hidden" name="start_date" value="'.$start_date.'">';
                $data .= '<input type="hidden" name="end_date" value="'.$end_date.'">';

                $data .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
//                $data .= '<a href="'.$venue_url.'" target="_blank">';
                $data .= '<div class="rated-box col-xs-3 col-card col-4 active" id="'.$form_id.'" onclick="submitSpaceForm(this.id)">';
                $data .= '<figure>';
                $data .= '<img src="'.url("storage/images/venues/".$venue->id."/cover/".$venue->cover_image).'" alt="" />';
                if($venue->top_rate == 1)
                {
                    $data .= '<div class="top-rate">
                                  <img src="'.url("images/ribben.png").'" alt=""/>
                              </div>';
                }

                $data .= '</figure>';
                $data .= '<div class="rated-box-info">';
                if($venue->verified == 1)
                {
                    $data .= '<h3>Verified by Conpherence</h3>';
                }

                $data .= '<h2>'.$venue->title.'</h2>';
                $data .= '<h4>'.$venue->city.'</h4>';
                //$data .= '<ul><li>Free Cancellation</li></ul>';
                $data .= '
                <div class="star-bar">
                                            <h3>
                                                <div class="star-ratings-css">
                                                    <div class="star-ratings-css-top" style="width:'.$average.'%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                                    <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                                </div>
                                            </h3>
                                        </div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</form><!-- rated-box -->';
            }
        } else {
            $data .= '<div class="dash-box-inner dash-pay-inner" id="credit_cards">';
            $data .= '<div class="pay-inner-card">';
            $data .= '<div class="dash-pay-gray">';
            $data .= 'No Venue added yet.';
            $data .= '</div>';
            $data .= '</div>';
            $data .= '</div>';
        }

        return response()->json(['data'=>$data,'pagination'=>$pagination,'count'=>$count]);
    }


    public function venue_index()
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

//        $active_venues = $company->venues->where('status', 1);
//        $inactive_venues = $company->venues->where('status', 0);

        $active_venues = paginate(to_array($company->venues->where('status', 1)),6);
        $inactive_venues = paginate(to_array($company->venues->where('status', 0)),6);

        return view('site/companies/dashboard_pages/venue', compact('company','active_venues','inactive_venues'));
    }

    public function create_venue()
    {
        $countries_plugin = init_countries_plugins();

        $countries = $countries_plugin->all()->pluck('name.common');

        $company = Company::where('user_id', Auth::user()->id)->first();

        $venues = $company->venues;

        $amenities = Amenities::all();
        $food_types = FoodType::all();

        return view('site/companies/dashboard_pages/add_venue', compact('company','venues','countries', 'amenities','food_types'));
    }

    public function save_venue(Request $request)
    {
        $response = $this->venue_save($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Venue not saved');
        }

        return redirect()->route('company.dashboard.venue.index');

    }

    public function upload_image(Request $request)
    {
        $venue = Venue::find($request->input('id'));
        $images = [];

        if($venue)
        {
            $images = json_decode($venue['images']);

            if($request->hasFile('images'))
            {
                foreach($request->file('images') as $image)
                {
                    $path = 'images/venues/' . $venue->id . '/';
                    $fileName = $image->getClientOriginalName();
                    $image->storeAs($path, $fileName);
                    array_push($images, $fileName);

                    $venue['images'] = json_encode($images);
                    $venue->save();
                }
            }
        }

        return response()->json($images);
    }

    public function delete_image(Request $request)
    {
        return $this->venue_image_delete($request);
    }

    public function edit_venue($venue_id)
    {
        $countries_plugin = init_countries_plugins();

        $countries = $countries_plugin->all()->pluck('name.common');
        $venue = Venue::find($venue_id);

        $company = Company::where('user_id', Auth::user()->id)->first();

        $amenities = Amenities::all();
        $venue_durations = $venue->foodDuration;
        $v_amenities = $venue->amenities;
        $food_types = FoodType::all();
        //  dd($food_types);

        return view('site/companies/dashboard_pages/add_venue', compact('company','venue','countries','amenities','venue_durations','v_amenities', 'food_types'));
    }

    public function delete_venue(Request $request)
    {
        $venue_id = $request->input('id');
        $response = $this->venue_delete($venue_id);
        $success_output= '';
        $error_output= '';

        if($response->getData()->code == 200)
        {
            $success_output .= '<div class="alert alert-success">Venue Delete successfully</div>';
        } else {
            $error_output = '<div class="alert alert-danger">Venue Not found</div>';;
        }

        return response()->json(['success' =>  $success_output, 'error'=>  $error_output]);
    }

    public function CompaniesVenueSearch(Request $request)
    {
        $output="";
        $venues = array();
        $venue_orderby = $request->search_order != null ? $request->search_order : 'asc';
        $company = Company::where('user_id', Auth::user()->id)->first();

        if($request->search != '') {
            $query = (new Venue)->newQuery();
            $query->where('status', $request->activetab);
            $query->where('company_id', $company->id);
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . "%")
                    ->orWhere('city', 'LIKE', '%' . $request->search . "%");
            });
            //$query->orwhere('city', 'LIKE', '%' . $request->search . "%");
            $query->orderBy('created_at', $venue_orderby);
            $venues = $query->get();
        }else{
            $query = (new Venue)->newQuery();
            $query->where('company_id', $company->id);
            $query->where('status', $request->activetab);
            $query->orderBy('created_at', $venue_orderby);
            $venues = $query->get();
        }
        $venues = $query->get();
        if(count($venues) > 0) {
            foreach ($venues as $venue) {
                $json = json_decode($venue->reviews);
                $total_average_percentage = ($json[4] / 5) * 100;

                $output .= '<div class="book-list" id="venue_box_' . $venue->id . '">' .
                    '<div class="b-list-img col-sm-2">' .
                    '<img src="' . url('storage/images/venues/' . $venue->id . '/cover/' . $venue->cover_image) . '" alt="" />' .
                    '</div>' .
                    '<div class="b-list-info col-sm-4">' .
                    '<h3>' . $venue->title . '</h3>' .
                    '<h5><a href="#">' . $venue->city . '</a></h5>' .
                    '</div>' .
                    '<div class="b-list-rate col-sm-2">' .
                    $json[4] . get_stars_view($json[4]) .
                    '</div>' .
                    '<div class="vanu-edit col-sm-2">' .
                    '<a class="del-btn" onclick="show_delete(' . $venue->id . ')"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                    '<a href="' . url('company/dashboard/venue/edit/' . $venue->id) . '" class="edit-btn"><img src="' . url('images/edit.png') . '" alt="edit"/></a>' .
                    '</div>' .
                    '<div class="b-list-btn col-sm-2">' .
                    '<a href="' . url('/company/dashboard/space/index/' . $venue->id) . '" class="btn get-btn">' .
                    '<span>View Listing </span><span></span><span></span><span></span><span></span>' .
                    '</a>' .
                    '</div>' .
                    '</div>';
            }
        }else{
            $output .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No result found.</div></div>';
        }
        return response()->json(['html' => $output, 'counter' => count($venues)]);
    }

    public function CompaniesSorting(Request $request)
    {
//        if ($request->ajax()) {
        $output = "";
        $user = Auth::user();
        if($request->activetab == 'active-venues'){
            $company = Company::where('user_id', Auth::user()->id)->first();
            $venues = Venue::where('company_id',$company->id)->where('status',1)->orderBy('created_at', $request->sort)->get();
        }elseif($request->activetab == 'inactive-venues') {
            $company = Company::where('user_id', Auth::user()->id)->first();
            $venues = Venue::where('company_id',$company->id)->where('status',0)->orderBy('created_at', $request->sort)->get();
        }

        foreach ($venues as $venue) {
            $json = json_decode($venue->reviews);
            $total_average_percentage = ($json[4]/5) * 100;

            $output.='<div class="book-list" id="venue_box_'.$venue->id.'">'.
                '<div class="b-list-img col-sm-2">'.
                '<img src="'.url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image).'" alt="" />'.
                '</div>'.
                '<div class="b-list-info col-sm-4">'.
                '<h3>'.$venue->title.'</h3>'.
                '<h5><a href="#">'.$venue->city.'</a></h5>'.
                '</div>'.
                '<div class="b-list-rate col-sm-2">'.
                $json[4].get_stars_view($json[4]).
                '</div>'.
                '<div class="vanu-edit col-sm-2">'.
                '<a class="del-btn" onclick="show_delete('.$venue->id.')"><img src="'.url('images/delete.png').'" alt="edit"/></a>'.
                '<a href="'.url('company/dashboard/venue/edit/'.$venue->id).'" class="edit-btn"><img src="'.url('images/edit.png').'" alt="edit"/></a>'.
                '</div>'.
                '<div class="b-list-btn col-sm-2">'.
                '<a href="'.url('/company/dashboard/space/index/'.$venue->id).'" class="btn get-btn">'.
                '<span>View Listing </span><span></span><span></span><span></span><span></span>'.
                '</a>'.
                '</div>'.
                '</div>';
        }
        return Response($output);
        //}
    }

    public function venue_allspaces(Request $request){
        $option = '';
        $venue_id = $request->venue_id;
        $spaces = Spaces::select('id', 'title')->where('venue_id', $venue_id)->where('status', 1)->get();
        if(count($spaces) > 0){
            $option .= '<option value="">Select Space</option>';
            foreach ($spaces as $space){
                $option .= '<option value="'.$space->id.'">'.$space->title.'</option>';
            }
        }else{
            $option .= '<option value="">No space found</option>';
        }
        return response()->json(['option' => $option]);
    }
}
