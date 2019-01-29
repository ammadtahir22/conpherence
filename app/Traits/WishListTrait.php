<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 11/8/2018
 * Time: 10:57 AM
 */

namespace App\Traits;


use App\Models\Site\Wishlist;
use Illuminate\Support\Facades\Auth;

trait WishListTrait
{
    private function outputJSON($message = '', $responseCode = 200, $result = null) {
        $response["message"] = $message;
        $response["code"] = $responseCode;
        $response["data"] = $result;

        return response()->json($response);
    }

    public function index_wishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();

        if(count($wishlists) > 0)
        {
            return $this->outputJSON('Wishlist of current user', 200,$wishlists);
        } else {
            return $this->outputJSON('Wishlist not found', 404,$wishlists);
        }
    }

    public function save_wishlist($request)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)
            ->where('list_name', $request->input('item'))
            ->where('item_id', $request->input('id'))
            ->first();

        if(!$wishlist)
        {
            $wishlist = New Wishlist();
        }

        $wishlist->user_id = Auth::user()->id;
        $wishlist->list_name = $request->input('item');
        $wishlist->item_id = $request->input('id');

        $wishlist->save();

        if($request->input('item') == 'space')
        {
            $massage = 'Space added in your Wishlist';
        } else {
            $massage = 'Venue added in your Wishlist';
        }

        return $this->outputJSON($massage, 201,$wishlist);
    }

    public function remove_wishlist($request)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)
            ->where('list_name', $request->input('item'))
            ->where('item_id', $request->input('id'))
            ->first();

        if($wishlist)
        {
            $wishlist->delete();

            if($request->input('item') == 'space')
            {
                $massage = 'Space removed from your Wishlist';
            } else {
                $massage = 'Venue removed from your Wishlist';
            }

            return $this->outputJSON($massage, 200,$wishlist);
        } else {
            return $this->outputJSON('Wishlist item not found', 404,$wishlist);
        }
    }
}