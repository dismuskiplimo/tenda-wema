<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpesaRaw extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
