<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonatedItemReview extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function item(){
    	return $this->belongsTo('App\DonatedItem', 'donated_item_id')->withTrashed();
    }
}
