<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodDeed extends Model
{
    public function images(){
    	return $this->hasMany('App\GoodDeedImage', 'good_deed_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function disapprover(){
    	return $this->belongsTo('App\User', 'disapprover_id');
    }

    public function approver(){
    	return $this->belongsTo('App\User', 'approver_id');
    }

    protected $dates = ['approved_at, disapproved_at, performed_at'];
}
