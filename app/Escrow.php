<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Escrow extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function donated_item(){
    	return $this->belongsTo('App\DonatedItem', 'donated_item_id');
    }

}
