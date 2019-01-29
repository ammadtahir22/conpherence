<?php

namespace App\Http\Controllers\Api;

use App\Models\Site\Venue;
use App\Traits\SearchTrait;
use App\Traits\VenueTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VenueController extends Controller
{
    use VenueTrait;
    use SearchTrait;

    public function get_venue($slug, Request $request)
    {
        return $this->venue_get($slug);
    }

    public function venue_index(Request $request)
    {
        return $this->index_venue();
    }

    public function save_venue(Request $request)
    {
        return $this->venue_save($request);
    }

    public function update_venue(Request $request)
    {
        if($request->has('id'))
        {
            $venue = Venue::find($request->input('id'));

            if($venue)
            {
                return $this->venue_save($request);
            } else {
                return outputJSON('Venue not found', 404, null);
            }
        } else {
            return outputJSON('Venue id is required', 400, null);
        }

    }

    public function delete_venue($id)
    {
        return $this->venue_delete($id);
    }

    public function venue_search(Request $request)
    {
        return $this->search_venue_ajax($request);
    }
}