<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, Profile, SimbaCoinLog, Timeline};

Use Auth, Session;

class AuthController extends Controller
{
    public function __construct(){
        $this->initialize();
    }

    public function showLoginForm(){
    	if(auth()->check()){
    		return redirect()->route('dashboard');
    	}

    	return view('pages.auth.login',[
    		'title' => 'Login',
    	]);
    }

    public function postLogin(Request $request){
    	if(auth()->check()){
    		return redirect()->route('dashboard');
    	}

    	$this->validate($request, [
    		'username' => 'required|max:255',
    		'password' => 'required|max:255',
    	]);

    	$username 	= ['username' 	=> $request->username, 'password' => $request->password, 'closed' => 0];
    	$email 		= ['email' 		=> $request->username, 'password' => $request->password, 'closed' => 0];

    	$remember	= $request->has('remember');

    	if(auth()->attempt($username, $remember) || auth()->attempt($email, $remember)){
    		$user = auth()->user();

            $profile = $user->profile;

            if(!$profile){
                $profile = new Profile;
                $profile->user_id = $user->id;
                $profile->save();
            }

            $message 	= 'Successfully Logged in';
    		$status		= 200;

    		if($request->ajax()){
    			$response = ['status' => $status, 'message' => $message];
    			return response()->json($response);
    		}

    		return redirect()->route('dashboard');
    	}

    	$message 	= 'Invalid username/password';
		$status		= 403;

		if($request->ajax()){
			$response = ['status' => $status, 'message' => $message];
			return response()->json($response);
		}

		return redirect()->back()->withInput();
    }

    public function showSignupForm(){
    	if(auth()->check()){
    		return redirect()->route('dashboard');
    	}

    	return view('pages.auth.signup',[
    		'title' => 'Signup',
    	]);
    }

    public function postSignup(Request $request){
    	if(auth()->check()){
    		return redirect()->route('dashboard');
    	}

    	$customMessages = [
    		'accepted' => 'You must accept the terms and conditions',
    	];

    	$this->validate($request, [
    		'fname' 	=> 'required|max:255',
    		'lname' 	=> 'required|max:255',
    		'email' 	=> 'required|max:255|unique:users',
    		'username' 	=> 'required|max:255|unique:users|alpha_dash',
    		'dob' 		=> 'required|max:255',
    		'password' 	=> 'required|max:255|confirmed',
    		'accepted' 	=> 'accepted',
    	], $customMessages);

    	$user 						       = new User;
    	$user->fname 				      = $request->fname;
        $user->lname                      = $request->lname;
    	$user->name 				      = $request->fname . ' ' . $request->lname;
    	$user->email 				      = $request->email;
    	$user->username 			      = strtolower($request->username);
    	$user->dob 					      = $request->dob;
        $user->password                   = bcrypt($request->password);
        $user->social_level               = 'MWANZO';
        $user->social_level_attained_at   = $this->date;
    	$user->last_seen	              = $this->date;
    	
    	$user->coins 				      = config('coins.earn.join_community');
    	$user->accumulated_coins	      = $user->coins;
    	$user->save();

        $this->settings->available_balance->value += $user->coins;
        $this->settings->available_balance->update();

        $this->settings->coins_in_circulation->value += $user->coins;
        $this->settings->coins_in_circulation->update();

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $user->id;
        $simba_coin_log->message               = 'Free Simba Coins for joining ' . config('app.name') . 'Community';
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $user->coins;
        $simba_coin_log->previous_balance      = 0;
        $simba_coin_log->current_balance      += $user->coins;
        $simba_coin_log->save();

    	$profile = $user->profile;

    	if(!$profile){
    		$profile = new Profile;
	    	$profile->user_id = $user->id;
	    	$profile->save();
    	}

    	$user->profile_id = $profile->id;

        $timeline           = new Timeline;
        $timeline->user_id  = $user->id;
        $timeline->model_id = $user->id;
        $timeline->message  = 'Joined ' . config('app.name') . ' Community';
        $timeline->type     = 'user.register';
        $timeline->save();

    	$message 	= 'Signup Successfull';
		$status		= 200;

		auth()->login($user);

		if($request->ajax()){
			$response = ['status' => $status, 'message' => $message];
			return response()->json($response);
		}

		return redirect()->route('dashboard');
    }

    public function logout(){
    	if(auth()->check()){
    		auth()->logout();
    	}

    	session()->flash('success', 'Logged Out');

    	return redirect()->route('auth.login');
    }

}
