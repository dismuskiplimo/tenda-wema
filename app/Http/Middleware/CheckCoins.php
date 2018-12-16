<?php

namespace App\Http\Middleware;

use Closure;

class CheckCoins
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
        if(auth()->check()){
            auth()->user()->check_social_level();
        }

        return $next($request);
    }
}
