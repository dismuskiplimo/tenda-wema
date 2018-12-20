<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodDeed extends Model
{
    use SoftDeletes;

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

    protected $dates = ['approved_at, disapproved_at, performed_at', 'deleted_at'];
}
