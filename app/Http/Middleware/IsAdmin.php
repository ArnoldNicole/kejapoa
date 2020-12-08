<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
           if (Auth::user() &&  Auth::user()->is_admin) {
                return $next($request);
           }

           return redirect('profile')->with('error','You have not admin access');
       }
}
