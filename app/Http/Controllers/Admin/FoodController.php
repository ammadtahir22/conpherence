<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Food_category;
use App\Models\Admin\Venue_category;
use App\Models\Site\Company;
use App\Models\Site\Venue;
use App\Traits\VenueTrait as Venue_trait;
use Illuminate\Http\Request;


class FoodController extends Controller
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
    public function categories_index()
    {
        $categories = Food_category::all();

        return view('admin-panel.food.all-categories', compact('categories'));
    }

    public function create_category()
    {
        return view('admin-panel.venue.add-category');
    }

    public function save_category(Request $request)
    {
        $response = $this->create_venue_category($request);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', 'Category saved successfully');
            return redirect()->route('all.venue.categories');
        } elseif ($response->getData()->code == 400)
        {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('all.venue.categories');
        }
        else {
            session()->flash('msg-error', 'Category not saved');
            return redirect()->route('all.venue.categories');
        }
    }

    public function edit_category($category_id)
    {
        $category = Venue_category::find($category_id);

        return view('admin-panel.venue.add-category', compact('category'));
    }

    public function delete_category($category_id)
    {
        $category = Venue_category::find($category_id);

        if($category)
        {
            foreach ($category->venues as $venue)
            {
                $venue->category_id = 1;
                $venue->save();
            }

            $category->delete();
            session()->flash('msg-success', 'Category deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.venue.categories');
    }

    public function venue_index()
    {
        $venues = Venue::all();

        return view('admin-panel.venue.all-venues', compact('venues'));
    }

    public function create_venue()
    {
        $categories = Venue_category::all();
        $companies = Company::all();

        return view('admin-panel.venue.add-venue', compact('categories','companies'));
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

    public function edit_venue($venue_id)
    {
        $venue = Venue::find($venue_id);

        $categories = Venue_category::all();
        $companies = Company::all();

        return view('admin-panel.venue.add-venue', compact('venue','categories','companies'));
    }
}
