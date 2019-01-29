<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Site\SittingPlan as SittingPlan_Model;
use Illuminate\Support\Facades\Validator;

trait SittingPlanTraits
{
    protected function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;

        return response()->json($response);
    }

    public function create_sitting_plan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
//            'image' => 'required',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error.', 400, $validator->errors());
        }
        $category_id = $request->input('id');


        $sitting_plan = SittingPlan_Model::updateOrCreate(['id' => $category_id],
                ['title' => $request->input('title'),
                'image' => ' ',
            ]);

        if($request->hasFile('image'))
        {
        $path = 'images/sitting-plan/';
        $fileName = request()->image->getClientOriginalName();
        $request->image->storeAs($path,$fileName);
            $sitting_plan->image = $fileName;
            $sitting_plan->save();
        }
        if(isset($category_id) && $category_id != ''){
            return $this->outputJSON('Sitting plan has been added successfully', 201,$sitting_plan);
        }else{
            return $this->outputJSON('Sitting plan has been updated successfully', 201,$sitting_plan);
        }
    }

}