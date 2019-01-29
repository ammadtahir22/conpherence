<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Venue_category;
use App\Models\Site\Amenities;
use App\Models\Site\Company;
use App\Models\Site\FoodDuration;
use App\Models\Site\FoodType;
use App\Models\Site\Venue;
use App\Traits\VenueTrait as Venue_trait;
use Illuminate\Http\Request;


class VenueController extends Controller
{
    use Venue_trait;
    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function categories_index()
//    {
//        $categories = Venue_category::all();
//
//        return view('admin-panel.venue.all-categories', compact('categories'));
//    }
//
//    public function create_category()
//    {
//        return view('admin-panel.venue.add-category');
//    }
//
//    public function save_category(Request $request)
//    {
//        $response = $this->create_venue_category($request);
//
//        if ($response->getData()->code == 201)
//        {
//            session()->flash('msg-success', 'Category saved successfully');
//            return redirect()->route('all.venue.categories');
//        } elseif ($response->getData()->code == 400)
//        {
//            session()->flash('msg-error', $response->getData()->message);
//            return redirect()->route('all.venue.categories');
//        }
//        else {
//            session()->flash('msg-error', 'Category not saved');
//            return redirect()->route('all.venue.categories');
//        }
//    }
//
//    public function edit_category($category_id)
//    {
//        $category = Venue_category::find($category_id);
//
//        return view('admin-panel.venue.add-category', compact('category'));
//    }
//
//    public function delete_category($category_id)
//    {
//        $category = Venue_category::find($category_id);
//
//        if($category)
//        {
//            foreach ($category->venues as $venue)
//            {
//                $venue->category_id = 1;
//                $venue->save();
//            }
//
//            $category->delete();
//            session()->flash('msg-success', 'Category deleted successfully');
//        } else {
//            session()->flash('msg-error', 'Error');
//        }
//
//        return redirect()->route('all.venue.categories');
//    }

    public function venue_index()
    {
        $response = $this->index_venue();
        $venues = $response->getData()->data;

        return view('admin-panel.venue.all-venues', compact('venues'));
    }

    public function create_venue()
    {

        $countries_plugin = init_countries_plugins();

        $countries = $countries_plugin->all()->pluck('name.common');

//        $cities_array = $countries_plugin->where('name.common', 'Oman')->first();
//        dd($cities_array);

        $categories =[];
        $companies = Company::all();
        $amenities = Amenities::all();
        $food_types = FoodType::all();

       // dd($food_types);

        return view('admin-panel.venue.add-venue', compact('categories','companies', 'countries' , 'amenities', 'food_types'));
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

        return redirect()->route('all.venue');
    }

    public function delete_image(Request $request)
    {
        return $this->venue_image_delete($request);
    }

    public function edit_venue($venue_id)
    {
        $venue = Venue::find($venue_id);

        $categories =[];
        $companies = Company::all();
        $countries_plugin = init_countries_plugins();
        $countries = $countries_plugin->all()->pluck('name.common');
        $amenities = Amenities::all();
        $food_duration = FoodDuration::all();
        $venue_durations = $venue->foodDuration;
        $v_amenities = $venue->amenities;
        $food_types = FoodType::all();

       // dd($venue_foodtype);
        return view('admin-panel.venue.add-venue', compact('venue','categories','companies','countries', 'amenities','venue_durations','v_amenities', 'food_types'));
    }

    public function delete_venue($venue_id)
    {
        $venue = Venue::find($venue_id);

        if($venue)
        {
            foreach ($venue->spaces as $space)
            {
                $space->spaceCapacityPlan()->delete();
                $space->spaceTypes()->detach();
                $space->accessibilities()->detach();
                $space->amenities()->detach();
                $space->delete();
            }

            foreach ($venue->foodCategory as $categorys)
            {
                $categorys->foods()->delete();
                $categorys->delete();
            }
            
            $venue->delete();


            session()->flash('msg-success', 'Venue has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        $response = $this->index_venue();
        $venues = $response->getData()->data;

        return view('admin-panel.venue.all-venues', compact('venues'));
    }
    public function food_type_index()
    {
        $food_types = FoodType::all();

        return view('admin-panel.food.all-foodtypes', compact('food_types'));
    }
    public function create_type()
    {

        return view('admin-panel.food.add-foodtype');
    }

    public function save_food_type(Request $request)
    {

        $response = $this->create_food_type($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('all.foodtype');
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('all.foodtype');
        }
        else {
            session()->flash('msg-error', 'Food Type not saved');
            return redirect()->route('all.foodtype');
        }
    }

    public function edit_food_type($food_type_id)
    {
        $food_types = FoodType::find($food_type_id);

        return view('admin-panel.food.add-foodtype', compact('food_types'));
    }

    public function delete_food_type($food_type_id)
    {
        $food_types = FoodType::find($food_type_id);

        if($food_types)
        {
            $food_types->delete();
            session()->flash('msg-success', 'Food type has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.foodtype');
    }

    public function change_top_rated(Request $request)
    {
        $venue = Venue::find($request->input('venue_id'));

        if($venue)
        {
            if($venue->top_rate == 0)
            {
                $venue->top_rate = 1;
            } else {
                $venue->top_rate = 0;
            }
            $venue->save();
        }

        session()->flash('msg-success', 'Venue Top rate status updated');

        return redirect()->route('all.venue');
    }

    public function change_verified(Request $request)
    {
        $venue = Venue::find($request->input('venue_id'));

        if($venue)
        {
            if($venue->verified == 0)
            {
                $venue->verified = 1;
            } else {
                $venue->verified = 0;
            }
            $venue->save();
        }

        session()->flash('msg-success', 'Venue Verified status updated');

        return redirect()->route('all.venue');
    }
}
