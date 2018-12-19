<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayPal_Transaction extends Model
{
    use SoftDeletes;
    
    protected $table = 'paypal_transactions';

    public function user(){
    	return $this->belongsTo('App\User','user_id')->withTrashed();
    }
}
