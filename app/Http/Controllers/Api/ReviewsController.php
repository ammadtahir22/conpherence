<?php

namespace App\Http\Controllers\Api;

use App\Traits\BookingTrait;
use App\Traits\ReviewTrait;
use App\Traits\WishListTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{
    use ReviewTrait;

    public function index()
    {
        return $this->get_user_reviews();
    }

    public function create(Request $request)
    {
        return $this->create_review($request);
    }

    public function remove(Request $request)
    {
        return $this->remove_wishlist($request);
    }
}
