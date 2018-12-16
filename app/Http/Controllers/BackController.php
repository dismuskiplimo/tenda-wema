<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;

use App\{Message,MessageNotification,Notification};

class BackController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('check_coins');
    }

    public function updateUserPassword(Request $request){
        $this->validate($request,[
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255|confirmed',
            'new_password_confirmation' => 'required|max:255',
        ]);

        $user = auth()->user();

        if(Hash::check($request->old_password ,$user->password)){
            $user->password = Hash::make($request->new_password);

            $user->update();

            $message = 'Password Updated';

            if($request->ajax()){
                $response = ['status' => '200', 'message' => $message];
                return response()->json($response);
            }

            session()->flash('success', $message);
        }else{
            $message = 'Old password does not match the password in our database';

            if($request->ajax()){
                $response = ['status' => '403', 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);          
        }

        return redirect()->back();
    }

    public function updateUserProfile(Request $request){
        $this->validate($request, [
            'fname'  	=> 'required|max:255',
            'lname' 	=> 'required|max:255',
            'dob' 		=> 'required|max:255',
            'username' 	=> 'required|max:255',
            'email' 	=> 'required|email|max:255',
        ]);

        $user = auth()->user();

        $user->fname 	= $request->fname;
        $user->lname 	= $request->lname;
        $user->name 	= $request->fname . ' ' . $user->lname;
        $user->dob 		= $request->dob;

        if($request->email != $user->email){
            $this->validate($request, [
                'email' => 'unique:users',
            ]);

            $user->email = $request->email;
        }

        if($request->username != $user->username){
            $this->validate($request, [
                'username' => 'unique:users',
            ]);

            $user->email = $request->email;
        }

        $user->update();

        session()->flash('success', 'Profile Updated');

        return redirect()->back();
    }


    public function getNewMessagesCount(){
        $user = auth()->user();
        
        $notifications = $user->message_notifications()->where('read', 0)->count();

        $response = ['count' => $notifications];

        return response()->json($response);
    }

    public function getNewNotificationsCount(){
        $user = auth()->user();

        $notifications = $user->notifications()->where('read', 0)->count();

        $response = ['count' => $notifications];

        return response()->json($response);
    }

    public function getAllNewCount(){
        $user = auth()->user();

        $notifications  = $user->notifications()->where('read', 0)->count();

        $messages       = $user->message_notifications()->where('read', 0)->count();

        $response       = [
            'messages'  => [
                'count' => $messages,
            ],

            'notifications'  => [
                'count' => $notifications,
            ],
            
        ];

        return response()->json($response);
    }
}
