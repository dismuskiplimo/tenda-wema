<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPhoto extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function thumbnail(){
    	return user_thumbnail($this->thumbnail);
    }

    public function photo(){
    	return user_photo($this->photo);
    }
}
