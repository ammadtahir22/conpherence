<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site\Accessibility;
use App\Traits\AccessibilitiesTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessibilitiesController extends Controller
{
    use AccessibilitiesTrait;
    //
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //

    public function index()
    {
        $accessibilities = Accessibility::all();

        return view('admin-panel.accessibilities.index', compact('accessibilities'));
    }

    public function create()
    {
        return view('admin-panel.accessibilities.create');
    }

    public function save_accessibilities(Request $request)
    {
        //dd($request);
        $response = $this->create_accessibilities($request);
        //dd($response);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('index.accessibilities');
        } else {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('index.accessibilities');
        }
    }

    public function edit_accessibilities($accessibilities_id)
    {
        $accessibilities = Accessibility::find($accessibilities_id);

        return view('admin-panel.accessibilities.create', compact('accessibilities'));
    }

    public function delete_accessibilities($accessibilities_id)
    {
        $accessibilities = Accessibility::find($accessibilities_id);
        $accessibilities->delete();
        $accessibilities = Accessibility::all();
        session()->flash('msg-success', 'Accessibility has been deleted successfully');
        return redirect()->route('index.accessibilities');
    }
}
