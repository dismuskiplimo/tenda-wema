<?php

namespace App\Http\Middleware;

use Closure;

class NotSuspended
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
        if(auth()->user()->is_suspended()){
            return redirect()->route('account.suspended');
        }

        return $next($request);
    }
}
