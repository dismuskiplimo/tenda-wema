<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodDeedImage extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
