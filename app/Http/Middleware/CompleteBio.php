<?php

namespace App\Http\Middleware;

use Closure;

class CompleteBio
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
        $bio = $request->user()->bio()->where('status', '1')->first();
        if(!$bio){
            return redirect('user-profile')->with([
                'message' => 'Lengkapi data diri anda terlebih dahulu',
                'active' => 'bio'
            ]);
        }
        return $next($request);
    }
}
