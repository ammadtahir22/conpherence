<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    // ajax request
    public function get_cities(Request $request)
    {
        $country = $request->input('country');

        $cities = get_cities_for_country($country);
        $options = '';

        if(count($cities) > 0)
        {
            foreach ($cities as $city)
            {
                $options .= '<option value="'.$city.'">'.$city.'</option>';
            }
        } else {
            $options .= '<option disabled selected>No City found</option>';
        }

        return response()->json(['data' => $options]);
    }


}
