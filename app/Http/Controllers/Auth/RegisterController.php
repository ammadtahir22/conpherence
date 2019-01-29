<?php

namespace App\Http\Controllers\Auth;


use App\Mail\Signup;
use App\Models\Site\Company;
use App\Models\Site\Individual;
use App\Models\Site\User;
use App\Http\Controllers\Controller;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = $this->redirectTo();
    }

    protected function redirectTo()
    {
        if(Auth::check())
        {
            if(Auth::user()->type === 'individual')
            {
                return 'dashboard-user';
            } else {
                return 'dashboard-company';
            }
        } else {
            return '/home';
        }
    }

    public function showRegistrationForm()
    {
        return view('site.auth.signup');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'required',
            'type' => 'required|string',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if($user){
//            $user->notify(new UserRegisteredNotification($user->activation_code));

            Mail::to($user)->send(new Signup($user));

            session()->flash('msg-success', 'We sent you an activation code. Please check your e-mail.');
            return redirect('/register');
        } else {
            session()->flash('msg-error', 'Error came up.');
            return redirect('/register');
        }
    }


    /**
     * @param $data
     * @return mixed
     */
    protected function create($data)
    {
        $activation_code = str_random(60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'provider_id' => $data['provider_id'],
            'provider' => $data['provider'],
            'ip' => '192.168.1.1',
            'last_login' => date('Y-m-d H:i:s'),
            'activated' => false,
            'activation_code' => $activation_code,
        ]);

        if($data['type'] == 'company')
        {
            Company::create([
                'user_id' => $user->id,
                'name' => $data['company_name'],
            ]);
        } else {
            Individual::create([
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }

    public function activateUser($activation_code, $user_id)
    {
        $user = User::where('activation_code', $activation_code)->where('id', $user_id)->first();

        if($user)
        {
            if($user->activated == 0)
            {
                $user->activated = 1;
                $user->save();

                session()->flash('msg-success', 'You account is activated. Please login.');
            } else {
                session()->flash('msg-success', 'User is already activated. Please login.');
            }

        } else {
            session()->flash('msg-error', 'Link expire.');
        }
        return redirect('/login');
    }
}
