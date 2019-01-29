<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckUserTypeCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            if(($request->user()->type === 'company') || $request->user()->type === '1')
            {
                return $next($request);
            }

        if( $request->is('api/*')){
            //write your logic for api call
            return outputJSON('Unauthorized', 401,null);
        }else{
            //write your logic for web call
            return redirect()->route('unauthorized');
        }




    }
}
