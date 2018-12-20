<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function reporter(){
    	return $this->belongsTo('App\User', 'reported_by');
    }

    public function approver(){
    	return $this->belongsTo('App\User', 'approved_by');
    }

    public function dismisser(){
    	return $this->belongsTo('App\User', 'dismissed_by');
    }

    public function report_type(){
    	return $this->belongsTo('App\ReportType', 'report_type_id');
    }

    public function status(){
    	if(!$this->approved && !$this->dismissed){
    		return 'PENDING REVIEW';
    	}

    	elseif($this->approved && !$this->dismissed){
    		return 'MISCONDUCT CONFIRMED';
    	}

    	elseif(!$this->approved && $this->dismissed){
    		return 'MISCONDUCT DISMISSED';
    	}

    	else{
    		return 'UNKNOWN';
    	}
    }

    public function user_model(){
    	return $this->belongsTo('App\User', 'model_id'->withTrashed(););
    }

    public function item_model(){
    	return $this->belongsTo('App\DonatedItem', 'model_id')->withTrashed();
    }

    public function post_model(){
    	return $this->belongsTo('App\Post', 'model_id')->withTrashed();;
    }

    public function comment_model(){
    	return $this->belongsTo('App\Comment', 'model_id')->withTrashed();;
    }
}
