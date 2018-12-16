<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function donated_items(){
    	return $this->hasMany('App\DonatedItem', 'category_id');
    }
}
