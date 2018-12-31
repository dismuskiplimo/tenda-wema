<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\ErrorLog;

use Carbon\Carbon;

use App\Setting;

use Mail;

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

    public function log_error(\Exception $e){
        $error_log          = new ErrorLog;
        $error_log->title   = $e->getMessage();
        $error_log->content = $e;
        $error_log->save();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . " | Error - Action needed";

            try{
                \Mail::send('emails.exception-detected', ['title' => $title, 'e' => $e], function ($message) use($e){
                    $message->subject($title);
                    $message->to(config('app.developer_email'));
                });

            }catch(\Exception $e){
                
            }
        }
    }
}
