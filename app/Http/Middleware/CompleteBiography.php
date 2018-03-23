<?php

namespace App\Http\Middleware;

use Closure;

class CompleteBiography
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
        $bio = $request->user()->biography()->where('status', '1')->first();
        if(!$bio){
            return redirect('user-profile')->with([
                'message' => 'Lengkapi biografi anda terlebih dahulu',
                'active' => 'biography'
            ]);
        }else{
            if(!$bio->social_media || !$bio->contact || !$bio->education || !$bio->work_experience || !$bio->certificate || !$bio->appreciation || !$bio->organization || !$bio->portfolio){
                return redirect('user-profile')->with([
                    'message' => 'Lengkapi biografi anda terlebih dahulu',
                    'active' => 'biography'
                ]);  
            }
        }
        return $next($request);
    }
}
