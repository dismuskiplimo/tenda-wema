<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{ErrorLog};

use Mail;

class ModeratorController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('is_moderator');
    }
}
