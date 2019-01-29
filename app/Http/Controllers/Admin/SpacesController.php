<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\SpacesType;
use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\SittingPlan;
use App\Models\Site\Venue;
use App\Traits\SpacesTrait;
use App\Models\Site\Spaces;
use App\Models\Site\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SpacesController extends Controller
{
    use SpacesTrait;
    //
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $spaces = Spaces::all();

        return view('admin-panel.spaces.index', compact('spaces'));
    }

    public function create()
    {
        $company = Company::where('user_id', Auth::user()->id)->first();
        $spacetypes = SpacesType::all();
        $venues = Venue::where('status',1)->get();
        $sittingplans = SittingPlan::all();
        $amenities = Amenities::all();
        $accessibilities = Accessibility::all();
       // $s_amenities = $venues->amenities;
     //   dd($s_amenities);
        return view('admin-panel.spaces.create' , compact('spacetypes','venues','sittingplans','amenities','accessibilities'));
    }

    public function save(Request $request)
    {

        $response = $this->create_space($request);
        if ($response->status() == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('index.spaces');
        } else {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('index.spaces');
        }
    }

    public function delete_image(Request $request)
    {
        return $this->space_image_delete($request);
    }

    public function edit($space_id)
    {
        $venues = Venue::all();
        $spacetypes = SpacesType::all();
        $amenities = Amenities::all();
        $sittingplans = SittingPlan::all();
        $accessibilities = Accessibility::all();
        $spaces = Spaces::find($space_id);
        $s_spacetypes = $spaces->spaceTypes;
        $s_amenities = $spaces->amenities;
        $s_sittingplans = $spaces->spaceCapacityPlan;
        //dd($s_amenities);
        $s_accessibilities = $spaces->accessibilities;
        return view('admin-panel.spaces.create', compact('spaces','spacetypes' , 's_spacetypes' ,'venues','amenities' , 's_amenities','sittingplans' , 's_sittingplans','accessibilities' , 's_accessibilities'));
    }

    public function delete($space_id)
    {
       // dd($space_id);
        $spaces = Spaces::find($space_id);
        $spaces->spaceCapacityPlan()->delete();
        $spaces->spaceTypes()->detach();
        $spaces->accessibilities()->detach();
       // $spaces->amenities()->detach();
        $spaces->delete();
        return redirect()->route('index.spaces');
   }

   public function getAmenitiesByVenueAjax(Request $request){
       $venues = Venue::find($request->venue_id);
       $s_amenities = $venues->amenities;
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
    /*****************************************************************************/
    public function spacetype_index()
    {
        $spacetypes = SpacesType::all();
        return view('admin-panel.spaces.all-spacetypes', compact('spacetypes'));
    }

    public function create_spacetype()
    {
        return view('admin-panel.spaces.add-spacetype');
    }

    public function save_spacetype(Request $request)
    {

        $response = $this->create_spaces_spacetype($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('index.space.spacetype');
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('index.space.spacetype');
        }
        else {
            session()->flash('msg-error', 'Space Type not saved');
            return redirect()->route('index.space.spacetype');
        }
    }

    public function edit_spacetype($spacetype_id)
    {
        $spacetype = SpacesType::find($spacetype_id);
        return view('admin-panel.spaces.add-spacetype' , compact('spacetype'));
    }

    public function delete_spacetype($spacetype_id)
    {
        $spacetype = SpacesType::find($spacetype_id);
        $spacetype->delete();
        $spacetypes = SpacesType::all();
        session()->flash('msg-success', 'Space type has been deleted successfully');
        return redirect()->route('index.space.spacetype');
    }

    public function change_top_rated(Request $request)
    {
        $space = Spaces::find($request->input('space_id'));

        if($space)
        {
            if($space->top_rate == 0)
            {
                $space->top_rate = 1;
            } else {
                $space->top_rate = 0;
            }
            $space->save();
        }

        session()->flash('msg-success', 'Space Top rate status updated');

        return redirect()->route('index.spaces');
    }

    public function change_verified(Request $request)
    {
        $space = Spaces::find($request->input('space_id'));

        if($space)
        {
            if($space->verified == 0)
            {
                $space->verified = 1;
            } else {
                $space->verified = 0;
            }
            $space->save();
        }

        session()->flash('msg-success', 'Space Verified status updated');

        return redirect()->route('index.spaces');
    }



}