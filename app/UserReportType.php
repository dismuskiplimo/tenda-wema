<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReportType extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function report_type(){
    	return $this->belongsTo('App\ReportType', 'report_type_id');
    }
}
