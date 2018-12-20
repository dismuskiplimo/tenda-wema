<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;

use App\{Message,MessageNotification,Notification, ReportType, UserReport, UserReportType, SimbaCoinLog, DonatedItem, Comment, Post};

class BackController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('check_coins');
        $this->initialize();
    }

    public function updateUserPassword(Request $request){
        $this->validate($request,[
            'old_password' => 'required|max:191',
            'new_password' => 'required|max:191|confirmed',
            'new_password_confirmation' => 'required|max:191',
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
            'fname'  	=> 'required|max:191',
            'lname' 	=> 'required|max:191',
            'dob' 		=> 'required|max:191',
            'username' 	=> 'required|max:191',
            'email' 	=> 'required|email|max:191',
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

    public function approveReport(Request $request, $id){
        $user_report = UserReport::findOrFail($id);
        $user_report->approved = 1;
        $user_report->approved_by = auth()->user()->id;
        $user_report->approved_at = $this->date;

        $user = $user_report->user;

        $extras = '';

        $user_report_type = $user->report_types()->where('report_type_id', $user_report->report_type_id)->first();

        if(!$user_report_type){
            $user_report_type = new UserReportType;
            $user_report_type->user_id = $user->id;
            $user_report_type->report_type_id = $user_report->report_type_id;
            $user_report_type->save();
        }

        $type = $user_report_type->report_type->type;

        $coins = 0;

        $instance = $user_report_type->count;

        if($type == 'post.flagged'){
            if($instance == 0){
                $coins = config('coins.lose.post_flagged.first_instance');
            }

            elseif($instance == 1){
                $coins = config('coins.lose.post_flagged.second_instance');
            }

            elseif($instance == 2){
                $coins = config('coins.lose.post_flagged.third_instance');
            }

            else{
                $coins = config('coins.lose.post_flagged.forth_instance');
            }
        }

        elseif($type == 'media.flagged'){
            if($instance == 0){
                $coins = config('coins.lose.media_flagged.first_instance');
            }

            elseif($instance == 1){
                $coins = config('coins.lose.media_flagged.second_instance');
            }

            elseif($instance == 2){
                $coins = config('coins.lose.media_flagged.third_instance');
            }

            else{
                $coins = config('coins.lose.media_flagged.forth_instance');
            }
        }

        elseif($type == 'language.inappropriate'){
            if($instance == 0){
                $coins = config('coins.lose.inappropriate_language.first_instance');
            }

            elseif($instance == 1){
                $coins = config('coins.lose.inappropriate_language.second_instance');
            }

            elseif($instance == 2){
                $coins = config('coins.lose.inappropriate_language.third_instance');
            }

            else{
                $coins = config('coins.lose.inappropriate_language.forth_instance');
            }
        }

        elseif($type == 'conduct.inappropriate'){
            if($instance == 0){
                $coins = config('coins.lose.inappropriate_conduct.first_instance');
            }

            elseif($instance == 1){
                $coins = config('coins.lose.inappropriate_conduct.second_instance');
            }

            elseif($instance == 2){
                $coins = config('coins.lose.inappropriate_conduct.third_instance');
            }

            else{
                $coins = config('coins.lose.inappropriate_conduct.forth_instance');
            }
        }

        elseif($type == 'community.disrupt'){
            if($instance == 0){
                $coins = config('coins.lose.disrupts_community.first_instance');
            }

            elseif($instance == 1){
                $coins = config('coins.lose.disrupts_community.second_instance');
            }

            elseif($instance == 2){
                $coins = config('coins.lose.disrupts_community.third_instance');
            }

            else{
                $coins = config('coins.lose.disrupts_community.forth_instance');
            }
        }

        elseif($type == 'reporting.malicious'){
            if($instance == 0){
                $coins = config('coins.lose.malicious_reporting.first_instance');
            }

            else{
                $coins = config('coins.lose.malicious_reporting.second_instance');
            }
        }

        elseif($type == 'rules.non-adhere'){
            $coins = config('coins.lose.non_adherence_to _principles.first_instance');
        }

        else{
            session()->flash('error', 'Invalid Value');
            return redirect()->back();
        }

        $user_report_type->count += 1;
        $user_report_type->update();

        $user_report->update();

        $user->coins -= $coins;
        $user->update();

        $this->settings->available_balance->value += $coins;
        $this->settings->available_balance->update();

        $message = 'You have been reported. Reason: ' . $user_report_type->report_type->description;

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $user->id;
        $simba_coin_log->message               = $message;
        $simba_coin_log->type                  = 'debit';
        $simba_coin_log->coins                 = $coins;
        $simba_coin_log->previous_balance      = $user->coins + $coins;
        $simba_coin_log->current_balance      += $user->coins;
        $simba_coin_log->save();

        $notification                       = new Notification;
        $notification->from_id              = auth()->user()->id;
        $notification->to_id                = $user->id;
        $notification->message              = $message;
        $notification->notification_type    = 'user.reported.approved';
        $notification->model_id             = $user_report->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->save();

        if($user_report->section == 'item'){
            $message = 'Item Deleted. Reason: ' . $user_report_type->report_type->description;

            return redirect()->route('admin.donated-item.delete', ['id' => $user_report->model_id, 'reason' => $message]);
        }

        if($user_report->section == 'post'){

            $post = Post::where('slug', $user_report->post_model->slug)->firstOrFail();

            $comments = $post->comments;

            if(count($comments)){
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            $post->delete();

            $extras .= 'Post Deleted';
    
        }

        if($user_report->section == 'comment'){
            $comment = Comment::findOrFail($user_report->comment_model->id);

            $comment->delete();

            $extras .= 'Comment Deleted';
        }

        session()->flash('success', 'Misconduct Confirmed. ' . $extras);

        return redirect()->back();
    }

    public function dismissReport(Request $request, $id){
        $this->validate($request, [
            'reason' => 'required|max:800',
        ]);

        $user_report = UserReport::findOrFail($id);
        $user_report->approved = 0;
        $user_report->approved_by = null;
        $user_report->approved_at = null;

        $user_report->dismissed = 1;
        $user_report->dismissed_by = auth()->user()->id;
        $user_report->dismissed_at = $this->date;
        $user_report->dismissed_reason = $request->reason;
        
        $user_report->update();

        $message = 'You reported ' . $user_report->user->name . ' on ' . simple_datetime($user_report->created_at) . '. However, we dismissed the request because ' . $request->reason;

        $notification                       = new Notification;
        $notification->from_id              = auth()->user()->id;
        $notification->to_id                = $user_report->reporter->id;
        $notification->message              = $message;
        $notification->notification_type    = 'user.reported.dismissed';
        $notification->model_id             = $user_report->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->save();

        session()->flash('success', 'Misconduct dismissed.');
         return redirect()->back();
    }
}
