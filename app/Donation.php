<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $dates = ['deteted_at', 'dismissed_at', 'received_at'];

    public function status(){
    	if($this->received == 0 && $this->dismissed == 0){
    		return 'DONATION NOT RECEIVED';
    	}

    	if($this->received == 1 && $this->dismissed == 0){
    		return 'DONATION RECEIVED';
    	}

    	if($this->received == 0 && $this->dismissed == 1){
    		return 'REQUEST DISMISSED';
    	}

    	else{
    		return 'UNKNOWN';
    	}
    }

    public function dismisser(){
    	return $this->belongsTo('App\User', 'dismissed_by');
    }

    public function receiver(){
    	return $this->belongsTo('App\User', 'received_by');
    }
}
