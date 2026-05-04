<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class SetLocale
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

        if(Session::has('lang')){
            app()->setLocale(Session::get('lang'));
        }else{
            $lang = 'en';
//            if(Auth::user()){
//                if(!is_null(Auth::user()->lang)){
//                    $lang = Auth::user()->lang;
//                }
//            }
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
