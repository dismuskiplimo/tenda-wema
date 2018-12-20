<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonatedItemImage extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function image(){
        return item_image($this);
    }

    public function banner(){
        return item_banner($this);
    }

    public function thumbnail(){
        return item_thumbnail($this);
    }

    public function slide(){
        return item_slide($this);
    }

    public function donated_item(){
        return $this->belongsTo('App\DonatedItem', 'donated_item_id');
    }
}
