<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function rater(){
    	return $this->belongsTo('App\User', 'rater_id');
    }
}
