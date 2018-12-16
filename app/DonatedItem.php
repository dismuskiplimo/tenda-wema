<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class DonatedItem extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];
}
