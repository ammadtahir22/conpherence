<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Site\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $redirectTo = '/login';
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @param $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $data['provider'] = $provider;
        $data['id'] = $user['id'];
        $data['name'] = $user->name;
        $data['email'] = $user->email;


        $authUser = User::where('provider_id', $user->id)->first();
        $user_email = User::where('email', $user->email)->first();

        if(isset($user_email) && isset($authUser))
        {
            if($authUser->activated == 1){
                Auth::loginUsingId($authUser->id);
                return redirect('/');
            } else {
                session()->flash('msg-error', 'Please active your account first. We send you an email on sign-up');
                return redirect()->back();
            }

        } elseif(isset($user_email) && !isset($authUser)) {
            if(url()->previous() == url(route('login')))
            {
                if($user_email->activated == 1){
                    $user_email->provider_id = $user->id;
                    $user_email->provider = $provider;
                    $user_email->save();

                    Auth::loginUsingId($user_email->id);
                    return redirect('/');
                } else {
                    session()->flash('msg-error', 'Please active your account first. We send you an email on sign-up');
                    return redirect()->back();
                }
            } else {
                session()->flash('msg-error', 'Email already used. Do you want to Sign-in');
                return view('site.auth.signup')->with('user', $data);
            }
        } elseif(!isset($user_email) && isset($authUser)) {

            if($authUser->activated == 1){
                Auth::loginUsingId($authUser->id);
                return redirect('/');
            } else {
                session()->flash('msg-error', 'Please active your account first. We send you an email on sign-up');
                return redirect()->back();
            }

        } else {
                session()->flash('msg-error', 'Please add remaining fields');
                return view('site.auth.signup')->with('user', $data);
        }

//
//
//
//        if(!$user_email)
//        {
//            return view('auth.signup')->with('user', $data);
//        }
//
//        if($authUser)
//        {
//            Auth::loginUsingId($authUser->id);
//            return redirect($this->redirectTo);
//        }
//
//        if ($user_email) {
//            if(url()->previous() == url(route('login')))
//            {
//                $user_email->provider_id = $user->id;
//                $user_email->provider = $provider;
//                $user_email->save();
//
//                Auth::loginUsingId($user_email->id);
//                return redirect($this->redirectTo);
//            } else {
//                session()->flash('msg-error', 'Email already used. Do you want to Sign-in');
//                return view('auth.signup')->with('user', $data);
//            }
//        }






//        $authUser = $this->findOrCreateUser($user, $provider);
//        Auth::login($authUser, true);
//        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
//    public function findOrCreateUser($user, $provider)
//    {
//        $authUser = User::where('provider_id', $user->id)->first();
//        if ($authUser) {
//            return $authUser;
//        }
//        return User::create([
//            'name'     => $user->name,
//            'email'    => $user->email,
//            'provider' => $provider,
//            'provider_id' => $user->id
//        ]);
//    }
}
