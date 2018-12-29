<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, Profile, SimbaCoinLog, Timeline};

Use Auth, Session, Mail, Socialite;

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
        $user->last_seen                  = $this->date;
    	$user->email_token	              = $generateRandomString(191);
    	
    	$user->save();

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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . " | Please Verify your email";

            try{
                \Mail::send('emails.email-verify', ['title' => $title, 'user' => $user], function ($message) use($user, $title){
                    $message->subject($title);
                    $message->to($user->email);
                });

            }catch(\Exception $e){
                session()->flash('error', $e->getMessage());
            }
        }

		auth()->login($user);

		if($request->ajax()){
			$response = ['status' => $status, 'message' => $message];
			return response()->json($response);
		}

		return redirect()->route('dashboard');
    }

    public function verifyEmail(Request $request, $token){
        $user = User::where('email_token', $token)->where('email_verified', 0)->first();

        if($user){
            $user->email_verified = 1;
            $user->email_verified_at = $this->date;
            $user->email_token = null;

            $user->coins                      = config('coins.earn.join_community');
            $user->accumulated_coins          = $user->coins;

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

            $user->update();

            if($this->settings->mail_enabled->value){
                $title = 'Welcome to ' . config('app.name');

                try{
                    \Mail::send('emails.welcome-email', ['title' => $title, 'user' => $user], function ($message) use($user, $title){
                        $message->subject($title);
                        $message->to($user->email);
                    });

                }catch(\Exception $e){
                    session()->flash('error', $e->getMessage());
                }
            }

            if(auth()->check()){
                auth()->logout();
            }

            session()->flash('success', 'Email Verified, please log in to continue');

            return redirect()->route('auth.login');

        }else{
            session()->flash('error', 'Invalid Token');
            return redirect()->route('auth.login');
        }
    }

    public function resendVerificationEmail(){
        if(!auth()->check()){
            session()->flash('error', 'Please Login to continue');
            return redirect()->route('auth.login');
        }

        $user = auth()->user();

        if($user->email_verified){
            session()->flash('success', 'Your email has already been verified');
            return redirect()->route('user.dashboard');
        }

        if(!$user->email_token){
            $user->email_token = generateRandomString(191);
            $user->update();
        }

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . " | Please Verify your email";

            try{
                \Mail::send('emails.email-verify', ['title' => $title, 'user' => $user], function ($message) use($user, $title){
                    $message->subject($title);
                    $message->to($user->email);
                });

            }catch(\Exception $e){
                session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Verification Email Sent, please check your inbox');
        return redirect()->back();
    }

    public function updateUserEmail(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:191',
        ]);

        if(!auth()->check()){
            session()->flash('error', 'Please Login to continue');
            return redirect()->route('auth.login');
        }

        $user = auth()->user();

        if($user->email != $request->email){
             $this->validate($request, [
                'email' => 'unique:users,email',
            ]);
        }

        $user->email = $request->email;
        $user->update();

        return $this->resendVerificationEmail();
    }

    public function logout(){
    	if(auth()->check()){
    		auth()->logout();
    	}

    	session()->flash('success', 'Logged Out');

    	return redirect()->route('auth.login');
    }


    // *************************************GOOGLE API **********************************************

    public function getGoogleLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function processGoogleLogin(){
        try{
            $socialite_user = Socialite::driver('google')->user();

            $exists = User::where('email', $socialite_user->email)->first();

            if($exists){
            
                auth()->login($exists);

                return redirect()->route('dashboard');
            }

            $names = explode(' ', $socialite_user->name);
            
            $fname = $names[0];

            try{
                $lname = $names[1];
            }catch(\Exception $e){
                $lname = 'Last';
            }

            $user                             = new User;
            $user->fname                      = $fname;
            $user->lname                      = $lname;
            $user->name                       = $fname . ' ' . $lname;
            $user->email                      = $socialite_user->email;
            $user->username                   = strtolower($socialite_user->email);
            $user->dob                        = null;
            $user->password                   = bcrypt($socialite_user->email);
            $user->social_level               = 'MWANZO';
            $user->social_level_attained_at   = $this->date;
            $user->last_seen                  = $this->date;
            $user->email_token                = null;
            $user->email_verified              = 1;
            $user->email_verified_at           = $this->date;

            $user->coins                      = config('coins.earn.join_community');
            $user->accumulated_coins          = $user->coins;

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
            
            $user->save();

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

            if($this->settings->mail_enabled->value){
                $title = 'Welcome to ' . config('app.name');

                try{
                    \Mail::send('emails.welcome-email', ['title' => $title, 'user' => $user], function ($message) use($user, $title){
                        $message->subject($title);
                        $message->to($user->email);
                    });

                }catch(\Exception $e){
                    session()->flash('error', $e->getMessage());
                }
            }

            auth()->login($user);

            return redirect()->route('dashboard');


        }catch(\Exception $e){
            return redirect()->back();
        }
    }

    // *********************************FACEBOOK API ************************************************

    public function getFacebookLogin(){
        return Socialite::driver('facebook')->redirect();
    }

    public function processFacebookLogin(){
        try{
            $socialite_user = Socialite::driver('facebook')->user();

            dd($socialite_user);
            
        }catch(\Exception $e){
            dd($e);
        }
    }

}
