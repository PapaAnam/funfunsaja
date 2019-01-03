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
        // dd(1);
        $u = $request->user();
        if(!is_null($u)){
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
                $sudah30menit = false;
                if(strtotime(date('Y-m-d H:i:s')) - strtotime($u->aktivitas_terakhir) > 1800){
                    $sudah30menit = true;
                }
                if(is_null($u->must_logout) || is_null($u->aktivitas_terakhir) || $u->must_logout <= date('Y-m-d H:i:s') || $sudah30menit){
                    Auth::user()->update([
                        'logged_in' => '0'
                    ]);
                    Auth::logout();
                    session([
                        'error_msg'=>'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.'
                    ]);
                    return redirect('/')->with('msg', 'Sesi anda habis. Silakan masuk lagi untuk mengakses menu anda.');
                }
            }
        }
        return $next($request);
    }
}
