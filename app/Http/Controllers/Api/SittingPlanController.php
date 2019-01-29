<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Traits\SittingPlanTraits;
//use App\Models\Admin\SittingPlan as SittingPlan_Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Site\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;


class SittingPlanController extends BaseController
{
    //
    use SittingPlanTraits;

    public function create_plan(Request $request)
    {
        return $this->create_sitting_plan($request);
    }
}
