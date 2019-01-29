<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Mail\Contact;
use App\Mail\Subscribe;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Page;
use App\Models\Admin\ContactUS;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Subscribers;
use App\Models\Admin\SpacesType;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin_login()
    {
        return view('admin-panel.auth.signin-admin');
    }

    public function admin_logout()
    {
        Auth::logout();
        return view('admin-panel.auth.signin-admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spacetypes = SpacesType::take(4)->get();
        $venues = Venue::where('status','=', 1)->get();
        $spaces = Spaces::where('top_rate','=', 1)->get();
        foreach ($spaces as $space){
        $spaces_venue[] = $space->venue;
        }

        $cities = get_all_cities();
//dd($spaces_venue);
        return view('site.index', compact('spacetypes', 'venues', 'spaces', 'spaces_venue', 'cities'));
    }


    public function get_how_it_work()
    {
        return view('site/how-it-work');
    }

    public function get_categories()
    {
        $space_types = SpacesType::all();
        $data = [];
        if(isset($space_types))
        {
            foreach ($space_types as $key=>$type)
            {
                  $data[$key]['type'] = $type;
                foreach ($type->spaces as $key1=>$space)
                {
                    if($space->status == 1)
                    {
                        $data[$key]['venus'][$key1] = $space->venue;
                    }
                }

                if (isset($data[$key]['venus']))
                {
                    $data[$key]['venus'] = array_unique($data[$key]['venus']);
                }

            }

        }

        $cities = get_all_cities();

        return view('site/categories' , compact('data','cities'));
    }



    public function get_contact_us()
    {
        return view('site/contact');
    }

    public function unauthorized()
    {
        return view('site/errors/401');
    }

    public function not_found()
    {
        return view('site/errors/404');
    }

    public function change_password(Request $request)
    {


        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            session()->flash('msg-error', 'Your current password does not matches with the password you provided. Please try again.');
            return redirect()->back();
        }
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            session()->flash('msg-error', 'New Password cannot be same as your current password. Please choose a different password.');
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirmed' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', $validator->errors());
        }

            //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();
        session()->flash('msg-success', 'Password changed successfully !');
        return redirect()->back();
    }


    public function page($page)
    {
        $data = Page::where('slug', '=', $page)->firstOrFail();

        return view('site.page', compact('data'));
     
    }
    /** * Show the application dashboard. * * @return \Illuminate\Http\Response */
    public function contactUSPost(Request $request)
    {
        // dd($request);
        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);
        ContactUS::create($request->all());

        Mail::send('site.mail.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message) use($request)
            {
                $message->from($request->get('email'));
                $message->to('info@conpherence.com', 'Conpherence')->subject('Contact Us');
            });

        return redirect()->back()->with('success', 'Thanks for contacting us!');
    }
    
        public function postSubscribeAjax(Request $request) {
        //return "test";
        //dd($request);
        $validation = Validator::make($request->all(), array(
                //email field should be required, should be in an email//format, and should be unique
                'email' => 'required|email|unique:subscribers,email'
            )
        );
        $error_array = array();
        $success_output = '';

        if($validation->fails()) {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {

            $create = Subscribers::create(array(
                'email' => $request->get('email')
            ));


            $success_output = '<div class="alert alert-success">Thank You For Subscribing</div>';
            //If successful, we will be returning the '1' so the form//understands it's successful
            //or if we encountered an unsuccessful creation attempt,return its info

            Mail::to($create)->send(new Subscribe($create));

        }

        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);

    }

    public function post_notification()
    {
        $data = '';

        $data .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="'.url('images/bell.png').'" alt="">';
        $data .= '<span class="badge">'.Auth::user()->unreadNotifications->count().'</span>';
        $data .= '</a>';
        $data .= '<ul class="dropdown-menu scroll-bar">';
        if(Auth::user()->unreadNotifications->count())
        {
            $data .= '<li><div class="dropdown-title">Today</div></li>';
            foreach (Auth::user()->unreadNotifications as $notification)
            {
                $data .= '<li class="active">';
                $data .= '<a href="#">';
                $data .= '<div class="noti-img">';
                $data .= '<img src="'.url('images/booking-img.png').'" alt="" />';
                $data .= '</div>';
                $data .= '<div class="noti-info">';
                $data .= '<div class="noti-info-left">';
                $data .= '<h3>Your Upcoming Booking</h3>';
                $data .= '<h4>'.$notification->data['booking']['space_id'].'<span>'.get_city_by_venue($notification->data['booking']['venue_id']).'</span></h4>';
                $data .= '</div>';
                $data .= '<div class="noti-info-right">';
                $data .= '<span>4.5<i class="star">★★★★★</i></span>';
                $data .= '<h4>AED 400</h4>';
                $data .= '<div class="date">20 to 22 July</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</a>';
                $data .= '</li>';
            }
        } else {
            $data .= '<li> <a> No Notification </a> </li>';
        }
        $data .= '</ul>';

        return response()->json(['data'=>$data]);
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->get()->toArray();
    }

    public function show_all_notification()
    {
        $notifications = Auth::user()->notifications()->paginate(6);


        $notifications_types = [
            'NewBooking' => 'App\Notifications\NewBooking',
            'NewHotelOwnerBooking' => 'App\Notifications\NewHotelOwnerBooking',
            'ApproveBooking' => 'App\Notifications\ApproveBooking',
            'CancelBooking' => 'App\Notifications\CancelBooking',
            'ReminderBooking' => 'App\Notifications\ReminderBooking',
        ];

        return view('site.notifications.all-notifications', compact('notifications','notifications_types'));
    }

    public function cache_clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:cache');
        Artisan::call('config:cache');

        return redirect()->back();
    }
}
