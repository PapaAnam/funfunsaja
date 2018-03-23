<?php

namespace App\Http\Middleware;

use Closure;

class CompleteBankAccount
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
        $bank = $request->user()->bank()->where('status', '1')->first();
        if(!$bank){
            return redirect('user-profile')->with([
                'message' => 'Lengkapi rekening anda terlebih dahulu',
                'active' => 'bank'
            ]);
        }
        return $next($request);
    }
}
