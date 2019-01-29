<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('web');
    }

    protected function authenticated(Request $request, $user)
    {
        $remember = $request->remember;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
            $url = $user->checkUserType();
            return redirect()->intended($url);
        }

        return redirect()->intended();
    }

    public function showLoginForm()
    {
        return view('site.auth.signin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
