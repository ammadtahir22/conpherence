<?php

namespace App\Http\Controllers\Api;

use App\Traits\BookingTrait;
use App\Traits\WishListTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListController extends Controller
{
    use WishListTrait;

    public function index()
    {
        return $this->index_wishlist();
    }

    public function save(Request $request)
    {
        return $this->save_wishlist($request);
    }

    public function remove(Request $request)
    {
        return $this->remove_wishlist($request);
    }
}
