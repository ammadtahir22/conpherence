<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site\Amenities;
use App\Traits\AmenitiesTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AmenitiesController extends Controller
{
    use AmenitiesTrait;
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
        $amenities = Amenities::all();

        return view('admin-panel.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin-panel.amenities.create');
    }

    public function save_amenities(Request $request)
    {
        //dd($request);
        $response = $this->create_amenities($request);
        //dd($response);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('index.amenities');
        } else {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('index.amenities');
        }
    }

    public function edit_amenities($amenities_id)
    {
        $amenities = Amenities::find($amenities_id);

        return view('admin-panel.amenities.create', compact('amenities'));
    }

    public function delete_amenities($amenities_id)
    {
        $amenities = Amenities::find($amenities_id);
        $amenities->delete();
        $amenities = Amenities::all();
        session()->flash('msg-success', 'Amenity has been deleted successfully');
        return redirect()->route('index.amenities');
    }

}
