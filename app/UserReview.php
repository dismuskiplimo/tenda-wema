<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReview extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function rater(){
    	return $this->belongsTo('App\User', 'rater_id');
    }
}
