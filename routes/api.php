<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@user');

    // venues
    Route::post('venue/create', 'Api\VenueController@save_venue')->name('api.create.venue')->middleware('check.type.company');
    Route::delete('venue/delete/{id}', 'Api\VenueController@delete_venue')->name('api.delete.venue')->middleware('check.type.company');
    Route::post('venue/update', 'Api\VenueController@update_venue')->name('api.update.venue')->middleware('check.type.company');
    Route::get('venue/{slug}', 'Api\VenueController@get_venue')->name('api.get.venue');
    Route::get('venues/index', 'Api\VenueController@venue_index')->name('api.index.venue');

    // space
    Route::post('space/create', 'Api\SpacesController@save_space')->name('api.create.space')->middleware('check.type.company');
    Route::delete('space/delete/{id}', 'Api\SpacesController@delete_space')->name('api.delete.space')->middleware('check.type.company');
    Route::post('space/update', 'Api\SpacesController@update_space')->name('api.update.space')->middleware('check.type.company');
    Route::get('space/{slug}', 'Api\SpacesController@get_space')->name('api.get.space');
    // example //http://localhost/conpherence/api/space/meeting-room
    Route::get('spaces/index', 'Api\SpacesController@index')->name('api.index.space');
    // example //http://localhost/conpherence/api/spaces/index

    // search
    Route::get('/venues/search', 'Api\VenueController@venue_search')->name('api.venue.search.all');

    //booking
    Route::post('/booking/save', 'Api\BookingController@save')->name('api.booking.save');
    Route::post('/booking/status/update', 'Api\BookingController@update_status')->name('api.booking.status.update');
    Route::get('/booking/user/index', 'Api\BookingController@user_booking_index')->name('api.user.booking.index')->middleware('check.type.individual');
    Route::get('/booking/user/{booking_id}', 'Api\BookingController@user_booking_detail')->name('api.user.booking.detail')->middleware('check.type.individual');

    Route::get('/booking/company/index', 'Api\BookingController@hotel_booking_index')->name('api.hotel.booking.index')->middleware('check.type.company');
    Route::get('/booking/company/{booking_id}', 'Api\BookingController@hotel_booking_detail')->name('api.hotel.booking.detail')->middleware('check.type.company');

    //wishlist
    Route::post('/wishlist/save', 'Api\WishListController@save')->name('api.wishlist.save')->middleware('check.type.individual');
    Route::post('/wishlist/remove', 'Api\WishListController@remove')->name('api.wishlist.remove')->middleware('check.type.individual');
    Route::get('/wishlist/index', 'Api\WishListController@index')->name('api.wishlist.index')->middleware('check.type.individual');

    //reviews
    Route::get('/reviews', 'Api\ReviewsController@index')->name('api.reviews.index')->middleware('check.type.individual');
    Route::post('/reviews/create', 'Api\ReviewsController@create')->name('api.reviews.create')->middleware('check.type.individual');
});
