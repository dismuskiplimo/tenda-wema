<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

class ModeratorController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('is_moderator');
    }
}
