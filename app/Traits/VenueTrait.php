<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use App\Models\Site\Food;
use App\Models\Site\FoodCategory;
use App\Models\Site\FoodDuration;
use App\Models\Site\FoodType;
use App\Models\Site\VenueAddOns;
use Illuminate\Http\Request;
use App\Models\Admin\Venue_category;
use App\Models\Site\Venue;
use Illuminate\Support\Facades\Validator;

trait VenueTrait
{
    private function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;

        return response()->json($response);
    }

    public function index_venue()
    {
        $venues = Venue::all();

        return $this->outputJSON('Success', 200,$venues);
    }

    public function venue_get($slug)
    {
        $venue = Venue::where('slug', $slug)->first();

        if($venue)
        {
            return $this->outputJSON('Successfully get Venue', 200,$venue);
        } else {
            return $this->outputJSON('Venue Not Found', 200,null);
        }
    }

    public function venue_save(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'company' => 'required',
//            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'cancellation_policy' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error', 400, $validator->errors());
        }

        $venue_id = $request->input('id');


        if( $request->is('api/*')){
            //write your logic for api call
            $food_array = json_encode($request->input('food_array'));
        }else{
            //write your logic for web call
            $food_array = $request->input('food_array');
        }



        if(isset($venue_id))
        {
            $venue = Venue::find($venue_id);
            $cover_image = $venue['cover_image'];
            $massage = 'Venue has been updated successfully';
        } else {
            $venue = new Venue();
            $cover_image = ' ';
            $massage = 'Venue has been added successfully';
        }

        $venue_title = get_company_name($request->input('company'));

        $venue->company_id = $request->input('company');
        $venue->title = $venue_title;
        $venue->slug = $venue_title;
        $venue->cover_image = $cover_image;
        $venue->description = $request->input('description');
        $venue->location = $request->input('location');
        $venue->latitude = $request->input('latitude');
        $venue->longitude = $request->input('longitude');
        $venue->country = $request->input('country');
        $venue->city = $request->input('city');
        $venue->cancellation_policy = $request->input('cancellation_policy');
        $venue->status = $request->input('status');
        $venue->food_array = $food_array;
        $venue->top_rate = 0;
        $venue->verified = 0;
        $venue->reviews = 0;
        $venue->save();

        $venue->slug = createSlug($venue_title.'-'.$request->input('city')).'-'.$venue->id;

//        if($request->has('category')) {
//            $venue->venueCategories()->sync($request->input('category'), false);
//        }

        if($request->has('amenities_id'))
        {
            $venue->amenities()->sync($request->input('amenities_id'));
        }


        // Api image name
        if($request->has('cover_image_name'))
        {
            $venue->cover_image = str_replace(" ","",$request->input('cover_image_name'));
        }

        if($request->hasFile('cover_image'))
        {
            $path = 'images/venues/'.$venue->id.'/cover/';
            $fileName = str_replace(' ', '_', request()->cover_image->getClientOriginalName());
            $request->cover_image->storeAs($path,$fileName);
            $venue->cover_image = $fileName;
        }


        if($request->hasFile('images'))
        {
            if(isset($venue_id))
            {
                $data = json_decode($venue->images);
            } else {
                $data = [];
            }

            foreach($request->file('images') as $image)
            {
                $path = 'images/venues/'.$venue->id.'/';
                $fileName = $image->getClientOriginalName();
                $image->storeAs($path,$fileName);
                $data[] = $fileName;
            }
            $venue->images = json_encode($data);
        }

        $venue->save();


        if($request->has('total_account_add_ons'))
        {
            $total_add_ons = $request->input('total_account_add_ons');

            for ($i = 1; $i <= $total_add_ons; $i++) {
                if($request->input('addons'.$i) != null)
                {
                    VenueAddOns::updateOrCreate(['id' => $request->input('addons_id'.$i)], [
                        'venue_id' => $venue->id,
                        'amenity_id' => $request->input('addons'.$i),
                        'price' => $request->input('addone_price'.$i),
                    ]);
                }
            }
        }


        if($request->has('duration_1'))
        {
            $food_durations = $venue->foodDuration;

            if(count($food_durations) > 0)
            {
                foreach ($food_durations as $key=>$duration)
                {
                    $key = $key + 1;

                    $duration->food_duration = $request->input('duration_'.$key);
                    $duration->start_time = date("H:i:s", strtotime($request->input('start_time_'.$key)));
                    $duration->end_time = date("H:i:s", strtotime($request->input('end_time_'.$key)));
                    $duration->save();
                }
            } else {
                for ($i=1; $i<=5; $i++)
                {
                    $food_duration = new FoodDuration();

                    $food_duration->venue_id = $venue->id;
                    $food_duration->food_duration = $request->input('duration_'.$i);
                    $food_duration->start_time = date("H:i:s", strtotime($request->input('start_time_'.$i)));
                    $food_duration->end_time = date("H:i:s", strtotime($request->input('end_time_'.$i)));

                    $food_duration->save();
                }
            }
        }



        $food_category_array = json_decode($food_array);
        if(isset($food_category_array))
        {
            foreach ($venue->foodCategory as $categorys)
            {
                $categorys->foods()->delete();
                $categorys->delete();
            }

            foreach ($food_category_array as $category)
            {
                $food_category = new FoodCategory();

                $food_duration = FoodDuration::where('venue_id', $venue->id)->where('food_duration', $category->food_duration)->first();

                $food_category->venue_id = $venue->id;
                $food_category->food_duration_id = $food_duration->id;
                $food_category->title = $category->category;
                $food_category->currency = $category->food_currency;
                $food_category->price = $category->food_price;
                $food_category->save();


                foreach ($category->food_items as $food_item)
                {
                    $food = new Food();

                    $food->category_id = $food_category->id;
                    $food->title = $food_item;
                    $food->save();
                }
            }
        }


        if(isset($venue_id) && $venue->status == 0)
        {
            foreach ($venue->spaces as $space)
            {
                $space->status = 0;
                $space->save();
            }
        }



        return $this->outputJSON($massage, 201,$venue);
    }

    public function venue_image_delete(Request $request)
    {
        $venue = Venue::find($request->input('id'));
        $images = [];

        if($venue)
        {
            $images = json_decode($venue['images']);
            if (($key = array_search($request->input('key'), $images)) !== FALSE) {
                unset($images[$key]);
            }

            $images = array_values($images);
            $venue['images'] = json_encode($images);
            $venue->save();

        }

        return response()->json($images);
    }

    public function venue_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'company' => 'required',
//            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'cancellation_policy' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error', 400, $validator->errors());
        }

        return $this->venue_save($request);
    }

    public function venue_delete($id)
    {
        $venue = Venue::find($id);

        if($venue)
        {
            $venue->amenities()->detach();
            $venue->venueAddOns()->delete();
            $venue->foodDuration()->delete();

            foreach ($venue->spaces as $space)
            {
                $space->spaceCapacityPlan()->delete();
                $space->spaceTypes()->detach();
                $space->accessibilities()->detach();
                $space->bookingInfo()->delete();
                $space->reviews()->delete();
                $space->delete();
            }

            foreach ($venue->foodCategory as $categorys)
            {
                $categorys->foods()->delete();
                $categorys->delete();
            }

            $venue->delete();

            $massage = 'Venue has been deleted successfully';
            $code = 200;
        } else {
            $massage = 'Venue Not found';
            $code = 404;
        }

        return $this->outputJSON($massage, $code,null);
    }

    public function create_food_type(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error.', 400, $validator->errors());
        }
        $food_type_id = $request->input('id');
//dd($food_type_id);

        $food_types = FoodType::updateOrCreate(['id' => $food_type_id],
            ['title' => $request->input('title')
            ]);

        if(isset($food_type_id) &&  $food_type_id != ''){
            return $this->outputJSON('Food type has been updated successfully', 201,$food_types);
        }else{
            return $this->outputJSON('Food type has been added successfully', 201,$food_types);
        }
    }
}