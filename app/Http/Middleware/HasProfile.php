<?php

namespace App\Http\Middleware;

use Closure;

use App\{Profile, SimbaCoinLog, Setting};

class HasProfile
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
        $user = auth()->user();

        if(!$user->profile){
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->save();
        }

        $user->check_profile_completion();

        return $next($request);
    }
}
