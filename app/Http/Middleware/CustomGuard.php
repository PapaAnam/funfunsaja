<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Auth\Middleware\Authenticate;
use Auth;

class CustomGuard //extends Authenticate
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
        if(!Auth::guard('admin')->check()){
            return redirect('/administrator/login');
        }
        return $next($request);
    }
}
