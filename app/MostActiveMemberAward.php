<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MostActiveMemberAward extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'valid_until'];

     public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
