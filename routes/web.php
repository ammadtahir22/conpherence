<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// home page frontend
Route::get('/', 'Site\HomeController@index')->name('home.page');

//Auth routes
Auth::routes();
Route::get('/password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::get('/user/activation/{token}/{user_id}', 'Auth\RegisterController@activateUser')->name('user.activate');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Clear Cache
Route::get('/cache', 'Site\HomeController@cache_clear')->name('cacheClear');

//Social Login
Route::get('auth/{provider}', 'Auth\SocialController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/change_password', 'Site\HomeController@change_password')->name('change.password');

    //individual routes
    Route::get('/dashboard-user', 'Site\IndividualController@dashboard_user')->name('dashboard-user');
    Route::post('/profile', 'Site\IndividualController@profile_update')->name('profile.update');

    Route::get('/user/dashboard/', 'Site\IndividualController@dashboard')->name('dashboard-user');
    Route::get('/user/dashboard/profile', 'Site\IndividualController@get_profile')->name('user.dashboard.profile');
    Route::get('/user/dashboard/payment', 'Site\IndividualController@get_payment')->name('user.dashboard.payment');
    Route::get('/user/dashboard/bookings', 'Site\BookingController@get_user_bookings')->name('user.dashboard.bookings')->middleware('check.type.individual');
    Route::get('/user/dashboard/bookings-detail/{bookings_id}', 'Site\BookingController@get_user_bookings_detail')->name('user.dashboard.bookings-detail')->middleware('check.type.individual');
    Route::post('/user/dashboard/booking-approve', 'Site\BookingController@update_status')->name('user.dashboard.bookings-approve')->middleware('check.type.individual');

    Route::get('/user/dashboard/wishlists', 'Site\IndividualController@get_wishlists')->name('user.dashboard.wishlists');
    Route::get('/user/dashboard/wishlistsearch', 'Site\WishListController@UserWishlistSearch')->name('user.dashboard.wishlist-search')->middleware('check.type.individual');
    Route::get('/user/dashboard/wishlistsort', 'Site\WishListController@UserWishlistSort')->name('user.dashboard.wishlist-sort')->middleware('check.type.individual');

    Route::get('/user/dashboard/reviews', 'Site\IndividualController@get_reviews')->name('user.dashboard.reviews');
    Route::get('/user/dashboard/reviewsearch', 'Site\ReviewController@ReviewSearch')->name('user.dashboard.review-search')->middleware('check.type.individual');
    Route::get('/user/dashboard/reviewsort', 'Site\ReviewController@ReviewSort')->name('user.dashboard.review-sort')->middleware('check.type.individual');
    Route::post('/user/dashboard/report', 'Site\BookingController@UserReport')->name('user.dashboard.booking-report')->middleware('check.type.individual');
    Route::get('/user/dashboard/report/pdf/{status}/{locations}/{start_dates}/{end_dates}', 'Site\BookingController@downloadUserPDF')->name('user.dashboard.exportuserpdf')->middleware('check.type.individual');
    Route::get('/user/dashboard/report/csv/{status}/{locations}/{start_dates}/{end_dates}', 'Site\BookingController@exportUserCSV')->name('user.dashboard.exportusercsv')->middleware('check.type.individual');
    Route::get('/user/dashboard/bookingsearch', 'Site\BookingController@UserSearch')->name('user.dashboard.booking-search')->middleware('check.type.individual');
    Route::get('/user/dashboard/bookingsort', 'Site\BookingController@UserSort')->name('user.dashboard.booking-sort')->middleware('check.type.individual');

    Route::get('/user/dashboard/saving', 'Site\IndividualController@get_saving_report')->name('user.dashboard.saving.report');
    Route::post('/user/saving/report', 'Site\IndividualController@generate_saving_report')->name('user.saving.report')->middleware('check.type.individual');
    Route::post('/user/saving/report/pdf/', 'Site\IndividualController@download_saving_pdf')->name('user.saving.report.pdf')->middleware('check.type.individual');
    Route::post('/user/saving/report/cvs/', 'Site\IndividualController@download_saving_cvs')->name('user.saving.report.cvs')->middleware('check.type.individual');

    //wishlist routes

    Route::post('/save/wishlist', 'Site\WishListController@save')->name('save.wishlist');
    Route::post('/remove/wishlist', 'Site\WishListController@remove')->name('remove.wishlist');

    //company routes
    Route::get('/company/dashboard/chart/data', 'Site\CompanyController@get_chart_data')->name('company.dashboard.chart.data');

    Route::get('/company/dashboard/', 'Site\CompanyController@dashboard')->name('dashboard-company');
    Route::get('/company/dashboard/profile', 'Site\CompanyController@get_profile')->name('company.dashboard.profile');
    Route::get('/company/dashboard/payment', 'Site\CompanyController@get_payment')->name('company.dashboard.payment');
    Route::get('/company/dashboard/bookings', 'Site\BookingController@get_bookings')->name('company.dashboard.bookings')->middleware('check.type.company');
    Route::get('/company/dashboard/bookings-detail/{bookings_id}', 'Site\BookingController@get_bookings_detail')->name('company.dashboard.bookings-detail')->middleware('check.type.company');
    Route::post('/company/dashboard/booking-approve', 'Site\BookingController@update_status')->name('company.dashboard.bookings-approve')->middleware('check.type.company');
    Route::post('/company/dashboard/report', 'Site\BookingController@report')->name('company.dashboard.booking-report')->middleware('check.type.company');
    Route::get('/company/dashboard/report/pdf/{status}/{locations}/{start_dates}/{end_dates}', 'Site\BookingController@downloadPDF')->name('company.dashboard.exportpdf')->middleware('check.type.company');
    Route::get('/company/dashboard/report/csv/{status}/{locations}/{start_dates}/{end_dates}', 'Site\BookingController@exportCSV')->name('company.dashboard.exportcsv')->middleware('check.type.company');
    Route::get('/company/dashboard/bookingsearch', 'Site\BookingController@search')->name('company.dashboard.booking-search')->middleware('check.type.company');
    Route::get('/company/dashboard/bookingsort', 'Site\BookingController@sort')->name('company.dashboard.booking-sort')->middleware('check.type.company');

    Route::get('/company/dashboard/venue/listingsort', 'Site\VenueController@CompaniesSorting')->name('company.dashboard.venue.listingsort')->middleware('check.type.company');
    Route::get('/company/dashboard/venue/listingsearch', 'Site\VenueController@CompaniesVenueSearch')->name('company.dashboard.venue.listingsearch')->middleware('check.type.company');
    Route::get('/company/dashboard/venue/index', 'Site\VenueController@venue_index')->name('company.dashboard.venue.index')->middleware('check.type.company');
    Route::get('/company/dashboard/venue/add', 'Site\VenueController@create_venue')->name('company.dashboard.venue.add')->middleware('check.type.company');
    Route::get('/company/dashboard/venue/edit/{venue_id}', 'Site\VenueController@create_venue')->name('company.dashboard.venue.add')->middleware('check.type.company');
    Route::delete('/company/dashboard/venue/delete', 'Site\VenueController@delete_venue')->name('company.dashboard.delete.venue')->middleware('check.type.company');
    Route::get('/company/dashboard/venue/edit/{venue_id}', 'Site\VenueController@edit_venue')->name('company.edit.venue')->middleware('check.type.company');
    Route::post('/company/dashboard/venue/save', 'Site\VenueController@save_venue')->name('company.add.venue')->middleware('check.type.company');

    Route::post('/company/dashboard/venue/images/upload', 'Site\VenueController@upload_image')->name('company.venue.upload.image')->middleware('check.type.company');
    Route::post('/company/dashboard/venue/images/delete', 'Site\VenueController@delete_image')->name('company.venue.delete.image')->middleware('check.type.company');

    //Add Company Spaces
    Route::get('/company/dashboard/space/listingsort', 'Site\SpacesController@CompaniesSpaceSorting')->name('company.dashboard.space.listingsort')->middleware('check.type.company');
    Route::get('/company/dashboard/space/listingsearch', 'Site\SpacesController@CompaniesSpaceSearch')->name('company.dashboard.space.listingsearch')->middleware('check.type.company');
    Route::get('/company/dashboard/space/index/{venue_id}', 'Site\SpacesController@index')->name('company.dashboard.space.index')->middleware('check.type.company');
    Route::get('/company/dashboard/space/add/{venue_id}', 'Site\SpacesController@create')->name('company.dashboard.space.add')->middleware('check.type.company');
    Route::post('/company/dashboard/space/amenities/','Site\SpacesController@getAmenitiesByVenueAjax')->name('company.space.amenities');
    Route::post('/company/dashboard/space/addons/','Site\SpacesController@getAddonsByVenueAjax')->name('company.space.addons');
    Route::post('/space/save', 'Site\SpacesController@save')->name('company.add.space')->middleware('check.type.company');
    Route::delete('/company/dashboard/space/delete', 'Site\SpacesController@delete_space')->name('company.dashboard.delete.space')->middleware('check.type.company');
    Route::get('/company/dashboard/space/edit/{space_id}', 'Site\SpacesController@edit')->name('company.dashboard.space.edit')->middleware('check.type.company');

    Route::post('/company/dashboard/space/images/delete', 'Site\SpacesController@delete_image')->name('company.space.delete.image')->middleware('check.type.company');

    //Company manual book routes
    Route::get('/company/dashboard/manual-booking', 'Site\BookingController@manualbooking')->name('company.dashboard.manual-booking')->middleware('check.type.company');
    Route::get('/venue_allspaces', 'Site\VenueController@venue_allspaces')->name('company.manualbooking.venueallspaces');
    Route::post('/company/dashboard/save-manual-booking', 'Site\BookingController@save_manual_booking')->name('company.manualbooking.save');
    Route::get('/company/dashboard/manual-booking-detail/{id}', 'Site\BookingController@manual_booking_detail')->name('company.manualbooking.detail');
    //Comapny manual booking routes

    Route::post('/profile/company', 'Site\CompanyController@profile_update')->name('company.profile.update');
    Route::get('/ajax/get-spaces', 'Site\CompanyController@get_spaces')->name('ajax.get-spaces');

    //Add Company Spaces
    Route::get('/ajax/get-spaces', 'Site\SpacesController@get_spaces')->name('ajax.get-spaces');
    Route::get('/ajax/edit-space', 'Site\SpacesController@edit_space')->name('ajax.edit-space');

    //payment routes
    Route::post('/save_credit_card', 'Site\PaymentController@save_credit_card')->name('save.creditcard');
    Route::get('/edit/credit_card', 'Site\PaymentController@edit_credit_card')->name('edit.creditcard');
    Route::delete('/edit/card/delete', 'Site\PaymentController@delete_card')->name('delete.creditcard');

    //Subscribers

    // Route::post('/subscribers/submit', 'Admin\SubscribersController@postSubmit')->name('subscribers.submit');
    // Route::post('/subscribers','Admin\SubscribersController@postSubscribeAjax')->name('subscribers');

    //Booking Routes
    Route::get('/venue/{slug}/booking', 'Site\BookingController@index')->name('booking');
    Route::post('/booking/save', 'Site\BookingController@save')->name('booking-space');
    Route::get('/booking/thankyou', 'Site\BookingController@thankyou')->name('thank-you');

    Route::post('/booking/check_space_status', 'Site\BookingController@check_space_status_for_booking')->name('check-space-status');

    Route::get('/live/notification', 'Site\HomeController@post_notification')->name('post.notification');
    Route::post('/notification/booking', 'Site\BookingController@notification');

    Route::get('/notifications', 'Site\HomeController@notifications')->name('get.notifications');
    Route::get('/notifications/all', 'Site\HomeController@show_all_notification')->name('show.all.notifications');
    Route::get('/notification/read', 'Site\HomeController@show_all_notification')->name('show.all.notifications');

    //Review Routes

    Route::get('/user/add_review/{booking_id}', 'Site\ReviewController@index')->name('add.review');
    Route::post('/user/review/save', 'Site\ReviewController@save_reviews')->name('review.save');




});



//Route::get('/notification/list', function (){
//    event(new \App\Events\NewBooking('check this msg'));
//})->name('post.notification');


// admin routes
Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Admin\AdminController@index')->name('admin.home');

    Route::get('/dashboard/line/chart/data', 'Admin\AdminController@get_dashboard_line_chart_data')->name('admin.dashboard.line.chart.data');
    Route::get('/dashboard/pie/chart/data', 'Admin\AdminController@get_dashboard_pie_chart_data')->name('admin.dashboard.pie.chart.data');

    //admin blog
    Route::get('/post/all', 'Admin\BlogController@posts_index')->name('all.posts');
    Route::get('/post/create', 'Admin\BlogController@create_post')->name('create.post');
    Route::post('/post/save', 'Admin\BlogController@save_post')->name('save.post');
    Route::get('/post/edit/{post_id}', 'Admin\BlogController@edit_post')->name('edit.post');
    Route::delete('/post/delete/{post_id}', 'Admin\BlogController@delete_post')->name('delete.post');
    Route::post('/post/image/save/{id}', 'Admin\BlogController@save_post_image')->name('save.image.post');

    //admin comments section
    Route::get('/comments/all', 'Admin\BlogController@comment_index')->name('all.comments');
    Route::post('/comments/change_comment_status', 'Admin\BlogController@change_comment_status')->name('change.comments');

    //post categories
    Route::get('/post/category/all', 'Admin\BlogController@categories_index')->name('all.post.categories');
    Route::get('/post/category/create', 'Admin\BlogController@create_category')->name('create.category');
    Route::post('/post/category/save', 'Admin\BlogController@save_category')->name('save.category');
    Route::get('/post/category/edit/{category_id}', 'Admin\BlogController@edit_category')->name('edit.category');
    Route::delete('/post/category/delete/{category_id}', 'Admin\BlogController@delete_category')->name('delete.category');

    //news
    Route::get('/news/all', 'Admin\NewsController@news_index')->name('all.news');
    Route::get('/news/create', 'Admin\NewsController@create_news')->name('create.news');
    Route::post('/news/save', 'Admin\NewsController@save_news')->name('save.news');
    Route::get('/news/edit/{news_id}', 'Admin\NewsController@edit_news')->name('edit.news');
    Route::delete('/news/delete/{news_id}', 'Admin\NewsController@delete_news')->name('delete.news');

    //news categories
    Route::get('/news/category/all', 'Admin\NewsController@categories_index')->name('all.news.categories');
    Route::get('/news/category/create', 'Admin\NewsController@create_category')->name('create.news.category');
    Route::post('/news/category/save', 'Admin\NewsController@save_category')->name('save.news.category');
    Route::get('/news/category/edit/{category_id}', 'Admin\NewsController@edit_category')->name('edit.news.category');
    Route::delete('/news/category/delete/{category_id}', 'Admin\NewsController@delete_category')->name('delete.news.category');

    //Booking
    Route::get('/booking/all', 'Admin\BookingController@booking_index')->name('all.booking');
    Route::get('/booking/detail/{bookings_id}', 'Admin\BookingController@bookings_detail')->name('detail.booking');
    Route::get('/booking/detail/manual-detail/{id}', 'Admin\BookingController@manual_booking_detail')->name('company.manualbooking.detail');
    Route::post('/booking/booking-approve', 'Admin\BookingController@update_status')->name('bookings-approve');
    Route::get('/career/all', 'Admin\CareerController@career_index')->name('all.careers');
    Route::get('/career/create', 'Admin\CareerController@create_career')->name('create.career');
    Route::post('/career/save', 'Admin\CareerController@save_career')->name('save.career');
    Route::get('/career/edit/{news_id}', 'Admin\CareerController@edit_career')->name('edit.career');
    Route::delete('/career/delete/{news_id}', 'Admin\CareerController@delete_career')->name('delete.career');


    //careers categories
    Route::get('/career/category/all', 'Admin\CareerController@categories_index')->name('all.career.categories');
    Route::get('/career/category/create', 'Admin\CareerController@create_category')->name('create.career.category');
    Route::post('/career/category/save', 'Admin\CareerController@save_category')->name('save.career.category');
    Route::get('/career/category/edit/{category_id}', 'Admin\CareerController@edit_category')->name('edit.career.category');
    Route::delete('/career/category/delete/{category_id}', 'Admin\CareerController@delete_category')->name('delete.career.category');

    //Venue
    Route::get('/venue/all', 'Admin\VenueController@venue_index')->name('all.venue');
    Route::get('/venue/create', 'Admin\VenueController@create_venue')->name('create.venue');
    Route::post('/venue/save', 'Admin\VenueController@save_venue')->name('save.venue');
    Route::get('/venue/edit/{venue_id}', 'Admin\VenueController@edit_venue')->name('edit.venue');
    Route::delete('/venue/delete/{venue_id}', 'Admin\VenueController@delete_venue')->name('delete.venue');
    Route::post('/venue/change_top_rated', 'Admin\VenueController@change_top_rated')->name('top_rate.venue');
    Route::post('/venue/change_verified', 'Admin\VenueController@change_verified')->name('verified.venue');

    Route::post('/venue/images/delete', 'Admin\VenueController@delete_image')->name('delete.image.venue');

    //Food Type
    Route::get('/food/type/all', 'Admin\VenueController@food_type_index')->name('all.foodtype');
    Route::get('/food/type/create', 'Admin\VenueController@create_type')->name('create.foodtype');
    Route::post('/food/type/save', 'Admin\VenueController@save_food_type')->name('save.food.type');
    Route::get('/food/type/edit/{food_type_id}', 'Admin\VenueController@edit_food_type')->name('edit.food.type');
    Route::delete('/food/type/delete/{food_type_id}', 'Admin\VenueController@delete_food_type')->name('delete.food.type');

    //Venue food categories
    Route::get('/food/category/all', 'Admin\VenueController@categories_index')->name('all.food.categories');
    Route::get('/food/category/create', 'Admin\VenueController@create_category')->name('create.food.category');
    Route::post('/food/category/save', 'Admin\VenueController@save_category')->name('save.food.category');
    Route::get('/food/category/edit/{category_id}', 'Admin\VenueController@edit_category')->name('edit.food.category');
    Route::delete('/food/category/delete/{category_id}', 'Admin\VenueController@delete_category')->name('delete.food.category');


    //Spaces
    Route::get('/spaces/all', 'Admin\SpacesController@index')->name('index.spaces');
    Route::get('/spaces/create', 'Admin\SpacesController@create')->name('create.spaces');
    Route::post('/spaces/save', 'Admin\SpacesController@save')->name('save.spaces');
    Route::get('/spaces/edit/{space_id}', 'Admin\SpacesController@edit')->name('edit.spaces');
    Route::get('/spaces/delete/{space_id}', 'Admin\SpacesController@delete')->name('delete.spaces');
    Route::post('/space/amenities/','Admin\SpacesController@getAmenitiesByVenueAjax')->name('space.amenities');
    Route::post('/space/addons/','Admin\SpacesController@getAddonsByVenueAjax')->name('space.addons');

    Route::post('/space/images/delete', 'Admin\SpacesController@delete_image')->name('delete.image.space');

    Route::post('/space/change_top_rated', 'Admin\SpacesController@change_top_rated')->name('top_rate.space');
    Route::post('/space/change_verified', 'Admin\SpacesController@change_verified')->name('verified.space');


    //Spaces Types
    Route::get('/space/spacetype/all', 'Admin\SpacesController@spacetype_index')->name('index.space.spacetype');
    Route::get('/space/spacetype/create', 'Admin\SpacesController@create_spacetype')->name('create.space.spacetype');
    Route::post('/space/spacetype/save', 'Admin\SpacesController@save_spacetype')->name('save.space.spacetype');
    Route::get('/space/spacetype/edit/{sitting_plan_id}', 'Admin\SpacesController@edit_spacetype')->name('edit.space.spacetype');
    Route::get('/space/spacetype/delete/{sitting_plan_id}', 'Admin\SpacesController@delete_spacetype')->name('delete.space.spacetype');

    //Sitting Plan For Spaces
    Route::get('/sitting-plan/all', 'Admin\SittingPlanController@index')->name('index.sitting-plan');
    Route::get('/sitting-plan/create', 'Admin\SittingPlanController@create')->name('create.sitting-plan');
    Route::post('/sitting-plan/save', 'Admin\SittingPlanController@save_sitting_plan')->name('save.sitting-plan');
    Route::get('/sitting-plan/edit/{sitting_plan_id}', 'Admin\SittingPlanController@edit_sitting_plan')->name('edit.sitting-plan');
    Route::get('/sitting-plan/delete/{sitting_plan_id}', 'Admin\SittingPlanController@delete_sitting_plan')->name('delete.sitting-plan');

    //Amenities For Spaces
    Route::get('/amenities/all', 'Admin\AmenitiesController@index')->name('index.amenities');
    Route::get('/amenities/create', 'Admin\AmenitiesController@create')->name('create.amenities');
    Route::post('/amenities/save', 'Admin\AmenitiesController@save_amenities')->name('save.amenities');
    Route::get('/amenities/edit/{amenities_id}', 'Admin\AmenitiesController@edit_amenities')->name('edit.amenities');
    Route::get('/amenities/delete/{amenities_id}',  'Admin\AmenitiesController@delete_amenities')->name('delete.amenities');

    //Accessibility For Spaces
    Route::get('/accessibilities/all', 'Admin\AccessibilitiesController@index')->name('index.accessibilities');
    Route::get('/accessibilities/create', 'Admin\AccessibilitiesController@create')->name('create.accessibilities');
    Route::post('/accessibilities/save', 'Admin\AccessibilitiesController@save_accessibilities')->name('save.accessibilities');
    Route::get('/accessibilities/edit/{accessibilities_id}', 'Admin\AccessibilitiesController@edit_accessibilities')->name('edit.accessibilities');
    Route::get('/accessibilities/delete/{accessibilities_id}', 'Admin\AccessibilitiesController@delete_accessibilities')->name('delete.accessibilities');

    //Spaces categories
    Route::get('/spaces/all', 'Admin\SpacesController@index')->name('index.spaces');
    Route::get('/spaces/create', 'Admin\SpacesController@create')->name('create.spaces');
//    Route::post('/venue/category/save', 'Admin\VenueController@save_category')->name('save.venue.category');
//    Route::get('/venue/category/edit/{category_id}', 'Admin\VenueController@edit_category')->name('edit.news.category');
//    Route::delete('/venue/category/delete/{category_id}', 'Admin\VenueController@delete_category')->name('delete.news.category');

    //Sitting Plan For Spaces
    Route::get('/sitting-plan/all', 'Admin\SittingPlanController@index')->name('index.sitting-plan');
    Route::get('/sitting-plan/create', 'Admin\SittingPlanController@create')->name('create.sitting-plan');
    Route::post('/sitting-plan/save', 'Admin\SittingPlanController@save_sitting_plan')->name('save.sitting-plan');
    Route::get('/sitting-plan/edit/{sitting_plan_id}', 'Admin\SittingPlanController@edit_sitting_plan')->name('edit.sitting-plan');
//    Route::delete('/venue/category/delete/{category_id}', 'Admin\VenueController@delete_category')->name('delete.news.category');

    //user
    Route::get('/users', 'Admin\AdminController@users')->name('admin.users');
    Route::get('/add_user', 'Admin\AdminController@add_user')->name('admin.add.users');
    Route::post('/save_user', 'Admin\AdminController@save_user')->name('admin.save.users');
    Route::post('/change_user_status', 'Admin\AdminController@change_user_status')->name('admin.change.user');
    Route::get('/pages', 'Admin\PageController@index')->name('admin.pages');
    Route::get('/page/create', 'Admin\PageController@create')->name('admin.create');
    Route::post('/page/save', 'Admin\PageController@save')->name('admin.save');
    Route::get('/page/{page_id}/edit', 'Admin\PageController@edit')->name('admin.edit');
    Route::post('/page/{page_id}/update', 'Admin\PageController@update')->name('admin.update');
    Route::delete('/page/{page_id}/delete', 'Admin\PageController@delete')->name('admin.delete');
    Route::get('/subscribers','Admin\SubscribersController@index')->name('admin.subscribers');
    Route::delete('/subscribers/{subscribers_id}/delete', 'Admin\SubscribersController@delete')->name('admin.subscribe.delete');
    Route::get('/mails','Admin\ContactUsController@index')->name('admin.mails');
    Route::delete('/mails/{mail_id}/delete', 'Admin\ContactUsController@delete')->name('admin.mail.delete');
    Route::get('/reviews', 'Admin\AdminController@reviews')->name('admin.reviews');
    Route::post('/change_review_status', 'Admin\AdminController@change_review_status')->name('admin.reviews');

    //Grades routes
    Route::get('/grades', 'Admin\AdminController@grades')->name('admin.grades');

    //earn point routes
    Route::get('/earn-points', 'Admin\AdminController@get_earn_points')->name('admin.earn.points');
    Route::post('save/earn-points', 'Admin\AdminController@save_earn_points')->name('admin.save.earn.points');
    Route::get('hotel/report', 'Admin\ReportingController@hotel_report')->name('admin.hotelowner.report');
    Route::post('hotel/report', 'Admin\ReportingController@get_hotel_report')->name('admin.hotelowner.gethotelreport');
    Route::post('hotel/download_pdf_report', 'Admin\ReportingController@download_pdf_report')->name('admin.downloadpdf_report');
    Route::post('hotel/download_excel_report', 'Admin\ReportingController@download_excel_report')->name('admin.downloadexcel_report');

    Route::get('user/saving/report/get', 'Admin\ReportingController@saving_report')->name('admin.user.savingreport');
    Route::post('user/saving/report/get', 'Admin\ReportingController@get_saving_point_report')->name('admin.getuser.savingreport');

    //Admin side:- Sale report
    Route::get('user/sale/report', 'Admin\ReportingController@user_sale_report')->name('admin.usersale.report');
    Route::post('user/sale/report', 'Admin\ReportingController@get_usersale_report')->name('admin.getuser.salereport');

    Route::get('hotel/sale/report', 'Admin\ReportingController@hotel_sale_report')->name('admin.hotelsale.report');
    Route::post('hotel/sale/report', 'Admin\ReportingController@get_hotelsale_report')->name('admin.gethotel.salereport');


    //Admin side:- Sale report
});

//home pages
Route::get('/how-it-work', 'Site\HomeController@get_how_it_work')->name('how-it-work');
//Route::get('/contact-us', 'Site\HomeController@get_contact_us')->name('contact_us');
Route::post('/subscribers','Site\HomeController@postSubscribeAjax')->name('subscribers');
Route::get('/categories', 'Site\HomeController@get_categories')->name('categories');


// general routes
Route::get('/get-cities/', 'GeneralController@get_cities')->name('get.cities');


//site venue
Route::post('/venue/{slug}', 'Site\VenueController@get_venue')->name('venue');
Route::get('/venue/{slug}', 'Site\VenueController@get_venue')->name('get.venue');
Route::get('/venues/search', 'Site\VenueController@venue_search_for_all')->name('venue.search.all');
Route::get('/venues/search/filter', 'Site\VenueController@venue_filter_ajax')->name('venue.search.filter');

//Site Spaces
Route::get('/venue/space/{slug}', 'Site\SpacesController@getSpace')->name('space');

//site blog
Route::get('/blogs', 'Site\BlogController@get_blog_index')->name('blog.index');
Route::get('/blog/{blog_id}', 'Site\BlogController@get_blog')->name('blog');
Route::post('/blog/comment', 'Site\BlogController@save_comment')->name('blog.comment');

//Pages
Route::get('/page/{page_slug}', 'Site\HomeController@page')->name('site.page');

//site news
Route::get('/news', 'Site\NewsController@get_news_index')->name('news.index');
Route::get('/news/{news_id}', 'Site\NewsController@get_news')->name('news');

//site career
Route::get('/career', 'Site\CareerController@get_career_index')->name('career.index');
Route::get('/career/search', 'Site\CareerController@search_career')->name('career.search');
Route::get('/career/{career_id}', 'Site\CareerController@get_career')->name('career');
Route::post('/career/apply', 'Site\CareerController@apply_career')->name('career.apply');

//Contact Us
Route::get('/contact-us', 'Site\HomeController@get_contact_us')->name('contact-us');
//Route::get('contact-us', 'Admin\ContactUSController@contactUS');
Route::post('contact-us', 'Site\HomeController@contactUSPost')->name('contactus.store');

//error pages
Route::get('/unauthorized', 'Site\HomeController@unauthorized')->name('unauthorized');
Route::get('/not-found', 'Site\HomeController@not_found')->name('not-found');

//Mailchimp Routes
Route::get('manageMailChimp', 'Site\MailChimpController@manageMailChimp');
Route::post('subscribe',['as'=>'subscribe','uses'=>'Site\MailChimpController@subscribe']);
Route::post('sendCompaign',['as'=>'sendCompaign','uses'=>'Site\MailChimpController@sendCompaign']);