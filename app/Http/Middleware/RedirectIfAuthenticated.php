<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }


        switch ($guard) {
            case 'admin' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.home');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('home.page');
//                    if ($request->user()->type === 'individual') {
//                        return redirect()->route('dashboard-user');
//                    } elseif ($request->user()->type === 'company') {
//                        return redirect()->route('dashboard-company');
//                    }
                }
                break;
        }


//        if(Auth::guard($guard)->check())
//        {
//            if($request->user()->type === 'individual')
//            {
//                return redirect()->route('dashboard-user');
//            } elseif($request->user()->type === 'company') {
//                return redirect()->route('dashboard-company');
//            } elseif($request->user()->type === '1') {
//                return redirect('/admin/home');
//            }
//        }


        return $next($request);
    }
}
