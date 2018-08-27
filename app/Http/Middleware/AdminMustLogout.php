<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMustLogout
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
        if(Auth::guard('admin')->check()){
            $u = Auth::guard('admin')->user();
            $sudah30menit = false;
            if(strtotime(date('Y-m-d H:i:s')) - strtotime($u->aktivitas_terakhir) > 1800){
                $sudah30menit = true;
            }
            if(is_null($u->must_logout) || is_null($u->aktivitas_terakhir) || $u->must_logout <= date('Y-m-d H:i:s') || $sudah30menit){
                Auth::guard('admin')->logout();
                session([
                    'error_msg'=>'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.'
                ]);
                if($request->ajax()){
                    return response('login ulang', 401);
                }
                return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
            }
        }
        return $next($request);
    }
}
