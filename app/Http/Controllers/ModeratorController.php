<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{ErrorLog, UserReport};

use Mail;

class ModeratorController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('is_moderator');

    	$this->middleware('not_closed');
        $this->middleware('check_coins');
        $this->middleware('has_profile');
        $this->middleware('email_verified');

        $this->initialize();
    }

    public function showMisconductsReported(){

    }

    public function showMisconductReported($id){
    	$user_report = UserReport::findOrFail($id);
    }
}
