<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class MustLogout
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
        $u = $request->user();
        if(Auth::guard('admin')->check()){
            $u = Auth::guard('admin')->user();
            if(is_null($u->must_logout)){
                Auth::guard('admin')->logout();
                return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
            }
            if($u->must_logout <= date('Y-m-d H:i:s')){
                Auth::guard('admin')->logout();
                return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
            }
        }
        else{
            if(is_null($u->must_logout)){
                Auth::logout();
                return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
            }
            if($u->must_logout <= date('Y-m-d H:i:s')){
                Auth::logout();
                return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
            }
        }
        return $next($request);
    }
}
