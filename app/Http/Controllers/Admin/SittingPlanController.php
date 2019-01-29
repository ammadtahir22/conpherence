<?php

namespace App\Http\Controllers\Admin;

use App\Traits\SittingPlanTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\SittingPlan as SittingPlan_Model;


class SittingPlanController extends Controller
{
    use SittingPlanTraits;
    //
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
        $sittingplans = SittingPlan_Model::all();

        return view('admin-panel.sitting-plan.index', compact('sittingplans'));
    }

    public function create()
    {
        return view('admin-panel.sitting-plan.create');
    }


    public function save_sitting_plan(Request $request)
    {
        //dd($request);
        $response = $this->create_sitting_plan($request);
        //dd($response);

        if ($response->getData()->code == 201)
        {
            session()->flash('msg-success', $response->getData()->message);
            return redirect()->route('index.sitting-plan');
        } else {
            session()->flash('msg-error', $response->getData()->message);
            return redirect()->route('index.sitting-plan');
        }
    }

    public function edit_sitting_plan($sitting_plan_id)
    {
        $sitting_plan = SittingPlan_Model::find($sitting_plan_id);

        return view('admin-panel.sitting-plan.create', compact('sitting_plan'));
    }

    public function delete_sitting_plan($sitting_plan_id)
    {
        $sitting_plan = SittingPlan_Model::find($sitting_plan_id);
        $sitting_plan->delete();
        $sittingplans = SittingPlan_Model::all();
        session()->flash('msg-success', 'Sitting plan has been deleted successfully');
        return redirect()->route('index.sitting-plan');
    }
}
