<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\ErrorLog;

use Carbon\Carbon;

use App\Setting;

use Mail, Config;

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


        if($this->settings->mail_db_preferred->value){
            Config::set('mail.driver', $this->settings->mail_driver->value);
            Config::set('mail.host', $this->settings->mail_host->value);
            Config::set('mail.port', $this->settings->mail_port->value);
            Config::set('mail.from.address', $this->settings->mail_from_address->value);
            Config::set('mail.from.name', $this->settings->mail_from_name->value);
            Config::set('mail.encryption', $this->settings->mail_encryption->value);
            Config::set('mail.username', $this->settings->mail_username->value);
            Config::set('mail.password', $this->settings->mail_password->value);

            Config::set('services.sparkpost.secret', $this->settings->sparkpost_secret->value);
            Config::set('services.sparkpost.options.endpoint', $this->settings->sparkpost_endpoint->value);

            Config::set('services.mailgun.secret', $this->settings->mailgun_secret->value);
            Config::set('services.mailgun.domain', $this->settings->mailgun_domain->value);
            Config::set('services.mailgun.endpoint', $this->settings->mailgun_endpoint->value);
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
                \Mail::send('emails.exception-detected', ['title' => $title, 'e' => $e], function ($message) use($title){
                    $message->subject($title);
                    $message->to(config('app.developer_email'));
                });

            }catch(\Exception $e){
                
            }
        }
    }
}
