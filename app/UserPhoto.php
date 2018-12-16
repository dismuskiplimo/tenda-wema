<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    public function thumbnail(){
    	return user_thumbnail($this->thumbnail);
    }

    public function photo(){
    	return user_photo($this->photo);
    }
}
