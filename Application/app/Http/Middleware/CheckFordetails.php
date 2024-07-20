<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckFordetails
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->password == null) {

            return redirect('/addition/password');

        } elseif (Auth::user() && Auth::user()->email == null) {

            return redirect('/addition/email');

        }

        return $next($request);
    }
}
