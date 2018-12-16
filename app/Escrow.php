<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function donated_item(){
    	return $this->belongsTo('App\DonatedItem', 'donated_item_id');
    }

}
