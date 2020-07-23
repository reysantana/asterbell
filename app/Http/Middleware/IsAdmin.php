<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
      if (Auth::user() && Auth::user()->type == '1') {
        return $next($request);
      }

      // if (Auth::user() && Auth::user()->email == 'topmedia@e-intro.com.my') {
      //   return $next($request);
      // }

      Auth::guard()->logout();
      return redirect('/login')->with('error', 'Sorry, you don\'t have access to this page.');
    }
}
