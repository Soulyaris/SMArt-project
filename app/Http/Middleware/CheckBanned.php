<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBanned
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
        if (Auth::check()):
            if (!(Auth::user()->isActive)):
                Auth::logout();
                return redirect()->route('gallery')->with('warning', 'Your account has been banned!');
            endif;
        endif;

        return $next($request);
    }
}
