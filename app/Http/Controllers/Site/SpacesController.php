<?php

namespace App\Http\Controllers\Site;

use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\SittingPlan;
use App\Traits\SpacesTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\SpacesType;
use App\Models\Site\Company;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SpacesController extends Controller
{
    use SpacesTrait;


    public function create($venue_id)
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

        $venue = Venue::find($venue_id);
        $v_amenities = json_decode($venue->amenities);
        $s_addons = $venue->venueAddOns;
       // dd($s_addons);
        $spacetypes = SpacesType::all();
        $sittingplans = SittingPlan::all();
        $amenities = Amenities::all();
        $accessibilities = Accessibility::all();

        return view('site/companies/dashboard_pages/add_space', compact('spacetypes','sittingplans','amenities','accessibilities','company','venue','v_amenities','s_addons'));
    }

    public function index($venue_id)
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

        $venue = Venue::find($venue_id);

        $space_types = SpacesType::whereHas('spaces', function($q) use($venue_id) {
            $q->where('venue_id', $venue_id);
        })->get();

        return view('site/companies/dashboard_pages/space', compact('company','venue', 'space_types','venue_id'));
    }


    public function edit($space_id)
    {
       // dd($venue_id);

        $spaces = Spaces::find($space_id);
        $company = Company::where('user_id', Auth::user()->id)->first();
        $venue = $spaces->venue;

        $venues = Venue::find($venue->id);
        $v_amenities = json_decode($venues->amenities);
        $s_addons = $venues->venueAddOns;
 //dd($s_addons);
        $spacetypes = SpacesType::all();
        $amenities = Amenities::all();
        $sittingplans = SittingPlan::all();
        $accessibilities = Accessibility::all();

        $s_spacetypes = $spaces->spaceTypes;
        $s_amenities = json_decode($spaces->amenities);
    //    dd($s_amenities);
        $s_sittingplans = $spaces->spaceCapacityPlan;

        $s_accessibilities = $spaces->accessibilities;

        return view('site/companies/dashboard_pages/add_space', compact('s_addons','spaces','spacetypes' , 's_spacetypes' ,'venue','amenities' , 's_amenities','sittingplans' , 's_sittingplans','accessibilities' , 's_accessibilities','company','v_amenities'));
    }

    public function save(Request $request)
    {
       // dd($request);
        $response = $this->create_space($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
        } else {
            session()->flash('msg-error', 'Space not saved');
        }


        return redirect()->route('company.dashboard.venue.index');

    }

    public function delete_image(Request $request)
    {
        return $this->space_image_delete($request);
    }

    public function delete_space(Request $request)
    {

        $space_id = $request->input('id');

        $response = $this->space_delete($space_id);
        $success_output= '';
        $error_output= '';

        if($response->getData()->code == 200)
        {
            $success_output .= '<div class="alert alert-success">Space Delete successfully</div>';
        } else {
            $error_output = '<div class="alert alert-danger">Space Not found</div>';;
        }

        return response()->json(['success' =>  $success_output, 'error'=>  $error_output, $request]);
    }
    public function getAmenitiesByVenueAjax(Request $request){
        $venues = Venue::find($request->venue_id);
        $s_amenities = $venues->amenities;
       // dd($s_amenities);
        return $s_amenities;
    }
    public function getAddonsByVenueAjax(Request $request){
        $venues = Venue::find($request->venue_id);
        $s_addons = $venues->venueAddOns;
        foreach ($s_addons as $addon){
            $amenities[] = Amenities::find($addon->amenity_id	);
        }
        return $amenities;
    }
    public function getSpace($slug){
       // dd($slug);
        $spacesall = Spaces::where('status', 1)->inRandomOrder()->limit(4)->get();
       // dd($spacesall);
        $spaces = Spaces::where('slug', $slug)->first();
        $sittingplans = SittingPlan::all();
        $accessibilities = Accessibility::all();
        $amenities = Amenities::all();

        $venue = $spaces->venue;

        $s_sittingplans = $spaces->spaceCapacityPlan;
        $s_accessibilities = $spaces->accessibilities;
        $s_amenities = $spaces->amenities;

       // dd($s_amenities);
        $slider_images= [];

        if ($spaces)
        {
            if(isset($spaces->gallery))
            {
                $slider_images = json_decode($spaces->gallery);
            }
            array_splice($slider_images, 0, 0, []);

            return view('site.space.space-detail', compact('venue','spaces', 'slider_images', 'sittingplans', 's_sittingplans', 'accessibilities', 's_accessibilities','amenities','s_amenities','spacesall'));
        } else {
            session()->flash('msg-error', 'Space Not Found');
            return redirect()->back();
        }

    }
    public function CompaniesSpaceSearch(Request $request)
    {
        //dd(Auth::user()->id);
        $search_order = $request->search_orderby != null ? $request->search_orderby : 'asc';
        $output="";
        $spaces = array();
        $company = Company::where('user_id', Auth::user()->id)->first();
        $space_types = SpacesType::where('id', $request->space_type_id)->first();
        $spaces_ids = [];
        if (isset($space_types) && $space_types != '') {
            $spaces_ids = $space_types->spaces->pluck('id')->toArray();
        }
        if($request->search != '') {
            $spaces = Spaces::where('venue_id', $request->venue_id)->where('title', 'LIKE', '%' . $request->search . "%")
            ->whereIn('id', $spaces_ids)->orderBy('created_at', $search_order)->get();
        }else{
            $spaces = Spaces::where('venue_id', $request->venue_id)->whereIn('id', $spaces_ids)->orderBy('created_at', $search_order)->get();
        }
        //dd($spaces);
        if(count($spaces) > 0) {
            foreach ($spaces as $space) {

                $json = json_decode($space->reviews_count);
                $total_average_percentage = ($json[4] / 5) * 100;

                $output .= '<div class="book-list">' .
                    '<div class="b-list-img col-sm-2">' .
                    '<img src="' . url('storage/images/spaces/' . $space->image) . '" alt="" />' .
                    '</div>' .
                    '<div class="b-list-info col-sm-4">' .
                    '<h3>' . $space->title . '</h3>' .
                    '</div>' .
                    '<div class="b-list-rate col-sm-2">' .
                    $json[4] . get_stars_view($json[4]) .
                    '</div>' .
                    '<div class="vanu-edit col-sm-2">' .
                    '<a class="del-btn" onclick="show_delete(' . $space->id . ')"><img src="' . url('images/delete.png') . '" alt="edit"/></a>' .
                    '<a href="' . url('company/dashboard/space/edit/' . $space->id) . '" class="edit-btn"><img src="' . url('images/edit.png') . '" alt="edit"/></a>' .
                    '</div>' .
                    '<div class="b-list-btn col-sm-2">' .
                    '<a href="' . url('venue/space/' . $space->slug) . '" class="btn get-btn">' .
                    '<span>View Space </span><span></span><span></span><span></span><span></span>' .
                    '</a>' .
                    '</div>' .
                '</div>';
            }
        }
        else{
            $output .=  '<div class="dash-pay-gray"> No result found.</div>';
        }
        return Response($output);


    }

    public function CompaniesSpaceSorting(Request $request)
    {
        $venue_id = $request->venue_id;
        if ($request->ajax()) {
            $output = "";

            $user = Auth::user();
            $company = Company::where('user_id', Auth::user()->id)->first();

            $venue = Venue::find($venue_id);

            $space_types = SpacesType::whereHas('spaces', function($q) use($venue_id) {
                $q->where('venue_id', $venue_id);
            })->get();

            $output.='<div class="booking-wrap">'.
                '<div class="tabs">'.
                '<div class="tab-button-outer">'.
                '<div class="full-col book-result">'.
                '<ul id="tab-button" class="booking-tab col-sm-7">';
                    foreach($space_types as $key=>$space_type){
                        if($key==0){
                           $active = 'is-active';
                        }else{
                            $active = '';
                        }
                        $output.='<li class="'.$active.'"><a href="#inner_tab_'.$key.'">'.$space_type->title.'</a></li>';

                    }
            $output.='</ul>'.
                '<div class="col-sm-5 book-result-form">'.
                '<form action="#" method="post">'.
                '<div class="col-xs-4 book-cata-feild form-group">'.
                '<select id="orderby" class="selectpicker">'.
                '<option>Sort by</option>'.
                '<option value="asc">Accending Order</option>'.
                '<option value="desc">Deccending Order</option>'.
                '</select>'.
                '</div>'.

                '<div class="col-xs-8 form-group">'.
                '<form id="searching" method="get">'.
                '@csrf'.
                '<input id="search" type="text"  name="date" placeholder="Search" class="form-control">'.
                '</form>'.
                '</div>'.



                '</form>'.
                '</div>'.

                '</div>';
                foreach($space_types as $key=>$space_type){

                    $spaces = $space_type->spaces->where('venue_id', $venue->id)->orderBy('created_at', $request->sort);
                    $output.='<div id="inner_tab_'.$key.'" class="tab-contents search-result vaneu-booking '.$active.'">';
                    if(count($spaces) > 0){
                        foreach($spaces as $space){
                            $json = json_decode($space->reviews_count);
                            $total_average_percentage = ($json[4]/5) * 100;
                            $output.='<div class="book-list">'.
                                '<div class="b-list-img col-sm-2">'.
                                '<img src="'.url('storage/images/spaces/'.$space->image).'" alt="" />'.
                                '</div>'.
                                '<div class="b-list-info col-sm-4">'.
                                '<h3>'.$space->title.'</h3>'.
                                '</div>'.
                                '<div class="b-list-rate col-sm-2">'.
                                $json[4].get_stars_view($json[4]).
                                '</div>'.
                                '<div class="vanu-edit col-sm-2">'.
                                '<a class="del-btn" onclick="show_delete('.$space->id.')"><img src="'.url('images/delete.png').'" alt="edit"/></a>'.
                                '<a href="'.url('company/dashboard/space/edit/'.$space->id).'" class="edit-btn"><img src="'.url('images/edit.png').'" alt="edit"/></a>'.
                                '</div>'.
                                '<div class="b-list-btn col-sm-2">'.
                                '<a href="'.url('venue/space/'.$space->slug).'" class="btn get-btn">'.
                                '<span>View Space </span><span></span><span></span><span></span><span></span>'.
                                '</a>'.
                                '</div>'.



                                '</div>';
                        }

                    }
                    $output.='</div>';
                }

                $output.='</div> //tabs end'.
                '</div>'.
                '</div>';

            return Response($output);

        }
    }
}
