<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use App\Models\Site\Accessibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait AccessibilitiesTrait
{
    protected function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;

        return response()->json($response);
    }

    public function create_accessibilities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
         //   'image' => 'required',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error.', 400, $validator->errors());
        }
        $category_id = $request->input('id');


        $accessibilities = Accessibility::updateOrCreate(['id' => $category_id],
            ['name' => $request->input('name'),
                'image' => ' ',
            ]);

        if($request->hasFile('image'))
        {
            $path = 'images/accessibilities/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $accessibilities->image = $fileName;
            $accessibilities->save();
        }

        if(isset($category_id) && $category_id != ''){
            return $this->outputJSON('Accessibility has been updated successfully', 201,$accessibilities);
        }else{
            return $this->outputJSON('Accessibility has been added successfully', 201,$accessibilities);
        }
    }

}