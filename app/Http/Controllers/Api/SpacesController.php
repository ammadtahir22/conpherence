<?php

namespace App\Http\Controllers\Api;

use App\Models\Site\Spaces;
use App\Traits\SpacesTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpacesController extends Controller
{
    use SpacesTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->space_index();
    }

    /**
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_space($slug, Request $request)
    {
        return $this->space_get($slug);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_space(Request $request)
    {
        return $this->create_space($request);
    }

    public function delete_space($id)
    {
        return $this->space_delete($id);
    }

    public function update_space(Request $request)
    {
        if($request->has('id'))
        {
            $space = Spaces::find($request->input('id'));

            if($space)
            {
                return $this->create_space($request);
            } else {
                return outputJSON('Space not found', 404, null);
            }
        } else {
            return outputJSON('Space ID required', 400, null);
        }

    }




}
