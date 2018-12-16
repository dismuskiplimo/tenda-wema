<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Carbon\Carbon;

use App\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $date, $image_path, $pagination, $user, $settings;

    public function initialize(){
    	$this->pagination 	= 16;
    	$this->date 		= Carbon::now();
    	$this->image_path 	= base_path(config('app.public_path') . '/images/uploads');

    	$this->user 		= auth()->user();

    	$this->settings = new \stdClass();

    	$settings = Setting::get();

    	foreach ($settings as $setting) {
    		$this->settings->{$setting->name} = $setting;
    	}
    }
}
