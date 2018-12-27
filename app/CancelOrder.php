<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelOrder extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function donated_item(){
    	return $this->belongsTo('App\DonatedItem', 'donated_item_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function approver(){
    	return $this->belongsTo('App\User', 'approved_by');
    }

    public function dismisser(){
    	return $this->belongsTo('App\User', 'dismissed_by');
    }

    public function status(){
    	if(!$this->approved && !$this->dismissed){
    		$status = 'PENDING REVIEW';
    	}

    	elseif($this->approved && !$this->dismissed){
    		$status = 'APPROVED';
    	}

    	elseif(!$this->approved && $this->dismissed){
    		$status = 'DISMISSED';
    	}

    	else{
    		$status = 'UNKNOWN';
    	}

    	return $status;
    }
}
