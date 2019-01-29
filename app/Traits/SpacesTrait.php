<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/26/2018
 * Time: 12:26 PM
 */

namespace App\Traits;

use App\Models\Admin\SpacesType;
use App\Models\Site\SpaceCapacityPlan;
use Illuminate\Http\Request;
use App\Models\Site\Spaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait SpacesTrait
{
    protected function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;
        return response()->json($response);
    }


    public function create_space(Request $request)
    {

    //     dd($request);
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required',
            'title' => 'required|string|max:255',
            'ckeditor' => 'required',
            'status' => 'required'
        ]);

 ///dd($request);
        if($validator->fails()){
            return $this->outputJSON('Validation Error', 400, $validator->errors());
        }
        $spaces_id = $request->input('id');
        $slug = createSlug($request->input('title'));

        if(isset($spaces_id))
        {
            $spaces = Spaces::find($spaces_id);
            $image = $spaces['image'];
        } else {
            $spaces = new Spaces();
            $image = ' ';
        }
        $count = $request->input('count');

        //dd(json_encode($request->input('free_amenity')));
        //dd($count);
        $spaces->venue_id = $request->input('venue_id');
        $spaces->user_id = Auth::user()->id;
        $spaces->amenities = json_encode($request->input('amenities_id'));
        $spaces->free_amenities = json_encode($request->input('free_amenity'));
        $spaces->title = $request->input('title');
        $spaces->slug = $slug;
        $spaces->image = $image;
        $spaces->description = $request->input('ckeditor');
        $spaces->cancellation_policy = $request->input('cancellation_policy');
        $spaces->hours = $request->input('hours');
        $spaces->cancel_cost = $request->input('cancel_cost');
        $spaces->price = $request->input('price');
        $spaces->status = $request->input('status');
        $spaces->top_rate = 0;
        $spaces->verified = 0;
        $spaces->save();


        $spaces->slug = $slug.'-'.$spaces->id;

       // dd($count);
        if($spaces->id){
            $spaces->spaceCapacityPlan()->delete();
        }
        for ($i = 0; $i <= $count; $i++) {
//            echo $request->input('sitting-plans-' . $i) ;
            if($request->input('sitting-plans-' . $i)) {
            SpaceCapacityPlan::updateOrCreate(
                [
                 'space_id' => $spaces->id,
                 'sitting_plan_id' => $request->input('sitting-plans-' . $i)
                ],
                [
                    'capacity' => $request->input('capacity-' . $i),
                ]);
            }

        }


        if($request->has('space-type')) {
            if($spaces->spaceTypes)
            {
                $spaces->spaceTypes()->detach();
            }
            
            $spaces->spaceTypes()->sync($request->input('space-type'), false);
        }

        if($request->has('accessibility_id')) {
                $spaces->accessibilities()->sync($request->input('accessibility_id'));
        }

      /*  if($request->has('amenities_id')) {
            $spaces->amenities()->sync($request->input('amenities_id'));
        } */

      // Api image name
        if($request->has('image_name'))
        {
            $spaces->image = $request->input('image_name');
            $spaces->save();
        }

        if($request->hasFile('image'))
        {
            $path = 'images/spaces/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $spaces->image = $fileName;
            $spaces->save();
        }

        if($request->hasFile('gallery'))
        {
            if(isset($spaces_id))
            {
                $data = json_decode($spaces->gallery);
            } else {
                $data = [];
            }

            foreach($request->file('gallery') as $gallery)
            {
                $path = 'images/spaces/'.$spaces->id.'/';
                $fileName = $gallery->getClientOriginalName();
                $gallery->storeAs($path,$fileName);
                $data[] = $fileName;
            }
            $spaces->gallery = json_encode($data);
        }

        $spaces->save();
        if(isset($spaces_id) && $spaces_id != ''){
            return $this->outputJSON('Space has been updated successfully', 201,$spaces);
        }else{
            return $this->outputJSON('Space has been added successfully', 201,$spaces);
        }
    }

    public function space_image_delete(Request $request)
    {
        $space = Spaces::find($request->input('id'));
        $images = [];

        if($space)
        {
            $images = json_decode($space['gallery']);
            if (($key = array_search($request->input('key'), $images)) !== FALSE) {
                unset($images[$key]);
            }

            $images = array_values($images);
            $space['gallery'] = json_encode($images);
            $space->save();

        }

        return response()->json($images);
    }
    /******************************************************************************/


    public function create_spaces_spacetype(Request $request)
    {
      //  dd($request);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'user_id' => 'required',
            'slug' => 'required'
        ]);


        if($validator->fails()){
            return $this->outputJSON('Validation Error', 400, $validator->errors());
        }
        $spacetype_id = $request->input('id');

        if(isset($spacetype_id))
        {
            $space_spacetype = SpacesType::find($spacetype_id);
            $image = $space_spacetype['image'];
        } else {
            $spaces = new SpacesType();
            $image = ' ';
        }

       // $space_spacetype = SpacesType::updateOrCreate(['id' => $spacetype_id], $request->all());
        $space_spacetype = SpacesType::updateOrCreate(['id' => $spacetype_id],
            ['title' => $request->input('title'), 'user_id' => $request->input('user_id'),'slug' => $request->input('slug'),'description' => $request->input('description'),
                'image' => ' ',
            ]);

        if($request->hasFile('image'))
        {
            $path = 'images/space-type/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $space_spacetype->image = $fileName;
            $space_spacetype->save();
        }
        if(isset($spacetype_id) && $spacetype_id != ''){
            return $this->outputJSON('Space type has been updated successfully', 201,$space_spacetype);
        }else{
            return $this->outputJSON('Space type has been added successfully', 201,$space_spacetype);
        }
    }

    public function space_get($slug)
    {
        $space = Spaces::where('slug', $slug)->first();

        if($space)
        {
            return $this->outputJSON('Successfully get Space', 200,$space);
        } else {
            return $this->outputJSON('Space Not Found', 200,null);
        }
    }

    public function space_index()
    {
        $spaces = Spaces::all();

        if($spaces)
        {
            return $this->outputJSON('Successfully get all Spaces', 200,$spaces);
        } else {
            return $this->outputJSON('Spaces Not Found', 200,null);
        }
    }

    public function space_delete($space_id)
    {
        $space = Spaces::find($space_id);

        if($space)
        {
            $space->spaceCapacityPlan()->delete();
            $space->spaceTypes()->detach();
            $space->accessibilities()->detach();
            $space->bookingInfo()->delete();
            $space->reviews()->delete();
//            $spaces->amenities()->detach();
            $space->delete();


            $massage = 'Space Delete successfully';
            $code = 200;
        } else {
            $massage = 'Space Not found';
            $code = 404;
        }

        return $this->outputJSON($massage, $code,null);
    }

}