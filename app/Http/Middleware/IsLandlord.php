<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsLandlord
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
            if (Auth::user() &&  Auth::user()->is_landlord) {
                 return $next($request);
            }

            return redirect('dashboard')->with('error','Page reserved for Landlords');
        }
}
