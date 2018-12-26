<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'dob' , 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'email_confirmed_at', 'last_seen', 'closed_at', 'suspended_from', 'suspended_until', 'social_level_attained_at', 'verified_at', 'deleted_at',
    ];

    public function is_admin(){
        return $this->usertype == 'ADMIN' && $this->is_admin ? true : false;
    }

    public function is_user(){
        return $this->usertype == 'USER' ? true : false;
    }

    public function is_moderator(){
        return $this->moderator ? true : false;
    }

    public function is_suspended(){
        return $this->suspended ? true : false;
    }

    public function is_closed(){
        return $this->closed ? true : false;
    }

    public function is_active(){
        return $this->active ? true : false;
    }
    
    public function is_email_verified(){
        return $this->email_verified ? true : false;
    }

    public function profile_picture(){
        return profile_picture($this);
    }

    public function image(){
        return profile_picture($this);
    }

    public function badge(){
        return social_badge($this->social_level);
    }

    public function social_status(){
        return ucfirst(strtolower($this->social_level)) . ' Member';
    }

    public function profile_thumbnail(){
        return profile_thumbnail($this);
    }

    public function thumbnail(){
        return profile_thumbnail($this);
    }

    public function profile(){
        return $this->hasOne('App\Profile', 'user_id');
    }

    public function simba_coin_logs(){
        return $this->hasMany('App\SimbaCoinLog', 'user_id');
    }

    public function can_be_moderator(){
        return $this->accumulated_coins >= config('coins.social_levels.hodari') ? true : false;
    }

    public function message_notifications(){
        return $this->hasMany('App\MessageNotification', 'to_id');
    }

    public function notifications(){
        return $this->hasMany('App\Notification', 'to_id');
    }

    public function user_reports(){
        return $this->hasMany('App\UserReport', 'user_id');
    }

    public function report_types(){
        return $this->hasMany('App\UserReportType', 'user_id');
    }

    public function check_social_level(){
        $changes          = false;
        $previous_balance = 0;
        $current_balance  = 0;
        $amount           = 0;

        if($this->accumulated_coins < config('coins.social_levels.uungano') && $this->social_level != 'MWANZO'){
            $this->social_level     = 'MWANZO';
            $new_level              = $this->social_level;
            $changes                = true;
        }

        elseif($this->accumulated_coins >= config('coins.social_levels.uungano') && $this->accumulated_coins < config('coins.social_levels.stahimili') && $this->social_level != 'UUNGANO'){
            
            $this->social_level      = 'UUNGANO';
            
            $previous_balance        = $this->coins;

            $this->coins             += config('coins.earn.mwanzo_uungano');
            $this->accumulated_coins += config('coins.earn.mwanzo_uungano');

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.mwanzo_uungano');

            $current_balance         = $this->coins;
            
            $changes                  = true;

        }

        elseif($this->accumulated_coins >= config('coins.social_levels.stahimili') && $this->accumulated_coins < config('coins.social_levels.shupavu') && $this->social_level != 'STAHIMILI'){
            
            $this->social_level       = 'STAHIMILI';
            
            $previous_balance         = $this->coins;

            $this->coins             += config('coins.earn.uungano_stahimili');
            $this->accumulated_coins += config('coins.earn.uungano_stahimili');

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.uungano_stahimili');

            $current_balance          = $this->coins;

            $changes                  = true;

        }

        elseif($this->accumulated_coins >= config('coins.social_levels.shupavu') && $this->accumulated_coins < config('coins.social_levels.hodari') && $this->social_level != 'SHUPAVU'){
            
            $this->social_level       = 'SHUPAVU';
            
            $previous_balance         = $this->coins;
            
            $this->coins             += config('coins.earn.stahimili_shupavu');
            $this->accumulated_coins += config('coins.earn.stahimili_shupavu');

            $current_balance          = $this->coins;

            $changes                  = true;

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.stahimili_shupavu');
        }

        elseif($this->accumulated_coins >= config('coins.social_levels.hodari') && $this->accumulated_coins < config('coins.social_levels.shujaa') && $this->social_level != 'HODARI'){
            
            $this->social_level       = 'HODARI';
            
            $previous_balance         = $this->coins;

            $this->coins             += config('coins.earn.shupavu_hodari');
            $this->accumulated_coins += config('coins.earn.shupavu_hodari');

            $current_balance          = $this->coins;

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.shupavu_hodari');

            $changes                  = true;
        }

        elseif($this->accumulated_coins >= config('coins.social_levels.shujaa') && $this->accumulated_coins < config('coins.social_levels.bingwa') && $this->social_level != 'SHUJAA'){
            
            $this->social_level       = 'SHUJAA';
            
            $previous_balance         = $this->coins;

            $this->coins             += config('coins.earn.hodari_shujaa');
            $this->accumulated_coins += config('coins.earn.hodari_shujaa');

            $current_balance          = $this->coins;

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.hodari_shujaa');

            $changes                  = true;
        }

        elseif($this->accumulated_coins >= config('coins.social_levels.bingwa') && $this->social_level != 'BINGWA'){
            
            $this->social_level       = 'BINGWA';

            $previous_balance         = $this->coins;

            $this->coins             += config('coins.earn.shujaa_bingwa');
            $this->accumulated_coins += config('coins.earn.shujaa_bingwa');

            $current_balance          = $this->coins;

            $new_level                = $this->social_level;
            $amount                   = config('coins.earn.shujaa_bingwa');

            $changes                  = true;

        }

        if($changes){
            $message = 'You have attained ' . strtolower($new_level) . ' social level.';

            if($amount > 0){
                $settings = Setting::get();

                $set = new \stdClass();

                foreach ($settings as $setting) {
                    $set->{$setting->name} = $setting;
                }

                $set->available_balance->value       += $amount;
                $set->available_balance->update();

                $set->coins_in_circulation->value    += $amount;
                $set->coins_in_circulation->update();

                $simba_coin_log                        = new \App\SimbaCoinLog;
                $simba_coin_log->user_id               = $this->id;
                $simba_coin_log->message               = 'Simba Coins earned for advancing to ' . strtolower($new_level) . ' social level.';
                $simba_coin_log->type                  = 'credit';
                $simba_coin_log->coins                 = $amount;
                $simba_coin_log->previous_balance      = $previous_balance;
                $simba_coin_log->current_balance      += $current_balance;
                $simba_coin_log->save();

                $message .= ' You have been awarded ' . $amount . ' Simba Coins for advancing to ' . $new_level . ' Social Level';

                $timeline           = new \App\Timeline;
                $timeline->user_id  = $this->id;
                $timeline->model_id = $this->id;
                $timeline->message  = 'Advanced to  ' . strtolower($new_level) . ' social level';
                $timeline->type     = 'social_level.upgraded';
                $timeline->extra    = $new_level;
                $timeline->save();

                $notification                       = new \App\Notification;
                $notification->from_id              = null;
                $notification->to_id                = $this->id;
                $notification->message              = $message;
                $notification->notification_type    = 'social-level.updated';
                $notification->model_id             = $this->id;
                $notification->system_message       = 1;
                $notification->save();
            }

            $this->social_level_attained_at = Carbon::now();
            $this->update();
            
            //session()->flash('success', $message);
        }   
    }

    public function check_profile(){
        if(!$this->profile){
            $profile = new \App\Profile;
            $profile->user_id = $this->id;
            $profile->save();
        }

        return true;
    }

    public function reviews(){
        return $this->hasMany('App\UserReview', 'user_id');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction', 'user_id');
    }

    public function photos(){
        return $this->hasMany('App\UserPhoto', 'user_id');
    }

    public function donated_items(){
        return $this->hasMany('App\DonatedItem', 'donor_id');
    }

    public function bought_items(){
        return $this->hasMany('App\DonatedItem', 'buyer_id');
    }

    public function good_deeds(){
        return $this->hasMany('App\GoodDeed', 'user_id');
    }

    public function timeline(){
        return $this->hasMany('App\Timeline', 'user_id');
    }

    public function memberships(){
        return $this->hasMany('App\Membership', 'user_id');
    }

    public function education(){
        return $this->hasMany('App\Education', 'user_id');
    }

    public function work_experience(){
        return $this->hasMany('App\WorkExperience', 'user_id');
    }

    public function skills(){
        return $this->hasMany('App\Skill', 'user_id');
    }

    public function awards(){
        return $this->hasMany('App\Award', 'user_id');
    }

    public function achievements(){
        return $this->hasMany('App\Achievement', 'user_id');
    }

    public function quotes_i_love(){
        return $this->hasMany('App\QuotesILove', 'user_id');
    }

    public function interests(){
        return $this->hasMany('App\MyInterest', 'user_id');
    }

    public function books_you_should_read(){
        return $this->hasMany('App\BooksYouShouldRead', 'user_id');
    }

    public function world_i_desire(){
        return $this->hasMany('App\WorldIDesire', 'user_id');
    }

    public function hobbies(){
        return $this->hasMany('App\Hobby', 'user_id');
    }

    public function coin_purchase_history(){
        return $this->hasMany('App\CoinPurchaseHistory', 'user_id');
    }

    public function stars(){
        $stars = $this->reviews ? ($this->rating / $this->reviews) : 0;

        $stars = $stars == 5 ? 5 : floor($stars);

        $str = '';

        for($i = 0; $i < $stars; $i++){
            $str .= '<i class="fa fa-star text-warning"></i>';
        }

        return empty($str) ? '<small><i>User not reviewed yet</i></small>' : $str;
    }

    public function check_profile_completion(){
        $profile = $this->profile;

        if(!$profile->redeemed){
            $elements = $this->elements();
            
            $sum = $this->sections_complete();

            if($sum == $elements){

                $this->coins                += config('coins.earn.complete_profile');
                $this->accumulated_coins    += config('coins.earn.complete_profile');
                $this->update();
                
                $this->check_social_level();

                $settings = \App\Setting::get();

                $set = new \stdClass();

                foreach ($settings as $setting) {
                    $set->{$setting->name} = $setting;
                }

                $set->available_balance->value         += config('coins.earn.complete_profile');
                $set->available_balance->update();

                $set->coins_in_circulation->value      += config('coins.earn.complete_profile');
                $set->coins_in_circulation->update();

                $simba_coin_log                        = new \App\SimbaCoinLog;
                $simba_coin_log->user_id               = $this->id;
                $simba_coin_log->message               = 'Simba Coins earned for completing profile';
                $simba_coin_log->type                  = 'credit';
                $simba_coin_log->coins                 = config('coins.earn.complete_profile');
                $simba_coin_log->previous_balance      = $this->coins - config('coins.earn.complete_profile');;
                $simba_coin_log->current_balance       = $this->coins;
                $simba_coin_log->save();

                $profile->redeemed = 1;
                $profile->update();

                $message = 'Profile Completed, you have been awarded ' . config('coins.earn.complete_profile') . ' Simba Coins';

                $notification                       = new \App\Notification;
                $notification->from_id              = null;
                $notification->to_id                = $this->id;
                $notification->message              = $message;
                $notification->notification_type    = 'profile.completed';
                $notification->model_id             = $this->id;
                $notification->system_message       = 1;
                $notification->save();
            }
        }
    }

    public function sections_complete(){
        $this->check_profile();

        $profile = $this->profile;

        $sum = $profile->about_me + $profile->hobbies + $profile->quotes_i_love + $profile->my_interests + $profile->books_you_should_read + $profile->world_i_desire;;

        return $sum;
    }

    public function elements(){
        return 6;
    }
}
