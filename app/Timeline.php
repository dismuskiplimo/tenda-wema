<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public function donated_item(){
    	return $this->belongsTo('App\DonatedItem', 'model_id');
    }

    public function user(){
    	return $this->belongsTo('App\DonatedItem', 'user_id');
    }
}
