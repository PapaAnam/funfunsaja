<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class ContentMiddleware
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
        $params     = Route::current()->parameters;
        $paramsName = Route::current()->parametersName;
        $content = $params['content'];
        if($content->type === '1'){
            if(!$user){
                return redirect('/login')->with('msg', 'Anda harus jadi member terlebih dahulu untuk melihat konten premium');
            }else{
                $bc = $user->boughtContent();
                if($bc->where('content_id', $content->id)->count() > 0 || $user->id == $content->user_id)
                    return $next($r);
                return redirect()->route('contents.confirm', [$params['content_kind'], $params['content']]);
            }
            return $next($r);
        }
        return $next($r);
    }
}
