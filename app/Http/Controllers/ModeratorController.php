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
    	$user_reports = UserReport::where('approved', 0)->where('dismissed', 0)->paginate(50);

    	return view('pages.user.misconducts-reported', [
    		'title' 		=> 'Misconducts Reported',
    		'nav'			=> 'moderator.misconducts-reported',
    		'user_reports' 	=> $user_reports,
    	]);
    }

    public function showMisconductReported($id){
    	$report = UserReport::findOrFail($id);

    	return view('pages.user.misconduct-reported', [
    		'title' 		=> 'Misconduct Reported',
    		'nav'			=> 'moderator.misconduct-reported',
    		'report' 		=> $report,
    	]);
    }
}
