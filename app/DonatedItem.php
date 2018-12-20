<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class DonatedItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function images(){
    	return $this->hasMany('App\DonatedItemImage', 'donated_item_id');
    }

    public function donor(){
    	return $this->belongsTo('App\User', 'donor_id');
    }

    public function buyer(){
        return $this->belongsTo('App\User', 'buyer_id');
    }

    public function approver(){
        return $this->belongsTo('App\User', 'approved_by');
    }

    public function disapprover(){
        return $this->belongsTo('App\User', 'disapproved_by');
    }

    public function escrow(){
        return $this->hasOne('App\Escrow', 'donated_item_id');
    }

    public function reviews(){
        return $this->hasMany('App\DonatedItemReview', 'donated_item_id');
    }

    public function category(){
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function banner(){
    	return item_banner($this);
    }

    public function image(){
    	return item_image($this);
    }

    public function thumbnail(){
    	return item_thumbnail($this);
    }

    public function status(){
        
        if($this->bought == 1 && $this->approved == 0 && $this->disputed == 0 && !$this->deleted_at){
            return 'PENDING APPROVAL';
        }

        elseif($this->bought == 0 && $this->approved == 0 && $this->disputed == 0 && $this->disapproved == 0 && !$this->deleted_at){
            return 'COMMUNITY SHOP';
        }

        elseif($this->bought == 1 && $this->approved == 1 && $this->disputed == 0 && $this->disapproved == 0 && $this->received == 0 && !$this->deleted_at){
            return 'APPROVED BUT NOT DELIVERED YET';
        }

        elseif($this->bought == 1 && $this->approved == 1 && $this->disputed == 0 && $this->disapproved == 0 && $this->received == 1 && !$this->deleted_at){
            return 'APPROVED AND DELIVERED';
        }

        elseif($this->approved == 0 && $this->disputed == 0 && $this->disapproved == 1 && !$this->deleted_at){
            return 'DISAPPROVED';
        }

        elseif($this->disputed == 1 && is_null($this->deleted_at) && !$this->deleted_at){
            return 'DISPUTED';
        }

        elseif($this->deleted_at){
            return 'TRASHED';
        }

        else{
            return 'STATE UNKNOWN';
        }
    }
}
