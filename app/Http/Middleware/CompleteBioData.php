<?php

namespace App\Http\Middleware;

use Closure;

class CompleteBioData
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
        $bio = $request->user()->biodata()->where('status', '1')->first();
        if(!$bio){
            return redirect('user-profile')->with([
                'message' => 'Lengkapi biodata anda terlebih dahulu',
                'active' => 'biodata'
            ]);
        }
        return $next($request);
    }
}
