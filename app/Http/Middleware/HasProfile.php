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

        $profile = $user->profile;

        if(!$profile->redeemed){
            $elements = 8;
            
            $sum = $profile->about_me + $profile->memberships + $profile->education + $profile->work_experience + $profile->skills + $profile->awards + $profile->hobbies + $profile->achievements;

            if($sum == $elements){

                $user->coins += config('coins.earn.complete_profile');
                $user->accumulated_coins += config('coins.earn.complete_profile');
                $user->update();
                
                $user->check_social_level();

                $settings = Setting::get();

                $set = new \stdClass();

                foreach ($settings as $setting) {
                    $set->{$setting->name} = $setting;
                }

                $set->available_balance->value       += config('coins.earn.complete_profile');
                $set->available_balance->update();

                $set->coins_in_circulation->value    += config('coins.earn.complete_profile');
                $set->coins_in_circulation->update();

                $simba_coin_log                        = new \App\SimbaCoinLog;
                $simba_coin_log->user_id               = $user->id;
                $simba_coin_log->message               = 'Simba Coins earned for completing profile';
                $simba_coin_log->type                  = 'credit';
                $simba_coin_log->coins                 = config('coins.earn.complete_profile');
                $simba_coin_log->previous_balance      = $user->coins - config('coins.earn.complete_profile');;
                $simba_coin_log->current_balance       = $user->coins;
                $simba_coin_log->save();

                $profile->redeemed = 1;
                $profile->update();

                session()->flash('success', 'Profile Completed, you have been awarded ' . config('coins.earn.complete_profile') . ' Simba Coins');
            }
        }

        return $next($request);
    }
}
