<?php

namespace App\Http\Middleware;

use Closure;

class BuatAktivitas
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
        if(!is_null($u)){
            $u->update([
                'aktivitas_terakhir'=>date('Y-m-d H:i:s'),
            ]);
        }
        return $next($request);
    }
}
