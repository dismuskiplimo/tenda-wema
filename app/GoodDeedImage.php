<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodDeedImage extends Model
{
    public function thumbnail(){
    	return good_deed_thumbnail($this);
    }

    public function image(){
    	return good_deed_image($this);
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

}
