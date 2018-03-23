<?php

namespace App\Http\Middleware;

use Closure;

class CompleteUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($r, Closure $next)
    {
        $user = $r->user();
        if(!$user->username || !$user->description)
            return redirect('/user-profile/edit')->with('message', 'Lengkapi profil anda terlebih dahulu');
        
        return $next($r);
    }
}
