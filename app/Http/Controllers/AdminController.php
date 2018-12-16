<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, DonatedItem, DonatedItemImage, Profile, Timeline, UserReview, SimbaCoinLog, Notification, GoodDeed, GoodDeedImage, Membership, Education, WorkExperience, Skill, Award, Hobby, Achievement, Escrow, CoinPurchaseHistory, Conversation, Message, MessageNotification};

use Image, Auth, Session;

use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('is_admin');
    	$this->middleware('not_closed');

    	$this->initialize();
    }

    public function showDashboard(){
    	return view('pages.admin.dashboard', [
    		'title' => 'Dashboard',
    		'nav'	=> 'admin.dashboard',
    	]);
    }

    public function showAccount(){
    }

    public function showAccountSettings(){	
    }

    //**************************DEEDS****************************************

    public function showDeeds($type){
    	$pagination = 20;

    	if($type == 'pending-approval'){
    		$title = 'Deeds Pending Approval';
    		$deeds = GoodDeed::where('approved', 0)->where('disapproved', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'approved'){
    		$title = 'Approved Deeds';
    		$deeds = GoodDeed::where('approved', 1)->where('disapproved', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'disapproved'){
    		$title = 'Disapproved Deeds';
    		$deeds = GoodDeed::where('approved', 0)->where('disapproved', 1)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'all'){
    		$title = 'All Deeds';
    		$deeds = GoodDeed::orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	else{
    		abort(404);
    	}

    	return view('pages.admin.deeds', [
    		'title'	=> $title,
    		'nav'	=> 'admin.deeds',
    		'deeds'	=> $deeds,
    	]);
    }

    public function showDeed($id){
    	$deed = GoodDeed::findOrFail($id);

    	return view('pages.admin.deed', [
    		'title'	=> $deed->name,
    		'nav'	=> 'admin.deed',
    		'deed'	=> $deed,
    	]);
    }

    public function approveDeed(Request $request, $id){
    	$deed = GoodDeed::findOrFail($id);

    	$user = auth()->user();

    	$deed->approved 	= 1;
    	$deed->approver_id 	= $user->id;
    	$deed->approved_at 	= $this->date;

    	$deed->disapproved 			= 0;
    	$deed->disapproved_reason 	= null;
    	$deed->disapproved_at 		= null;
    	$deed->disapprover_id		= null;


    	$deed->update();

    	$deed_user = $deed->user;
    	$deed_user->coins += config('coins.earn.good_deed');
    	$deed_user->accumulated_coins += config('coins.earn.good_deed');
    	$deed_user->update();

    	$deed_user->check_social_level();

    	$simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $deed->user->id;
        $simba_coin_log->message               = config('coins.earn.good_deed') . ' Simba Coins for diong a good deed. DESC: ' . $deed->name;
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = config('coins.earn.good_deed');
        $simba_coin_log->previous_balance      = $deed->user->coins - config('coins.earn.good_deed');
        $simba_coin_log->current_balance      += $deed->user->coins;
        $simba_coin_log->save();

    	$timeline           = new Timeline;
        $timeline->user_id  = $deed->user_id;
        $timeline->model_id = $deed->id;
        $timeline->message  = 'Peformed a good deed : ' . $deed->name;
        $timeline->type     = 'deed.approved';
        $timeline->save();

    	$notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $deed->user->id;
        $notification->system_message       = 1;
        $notification->from_admin       	= 1;
        $notification->message              = 'Your Good deed ' . $deed->name . ' has been approved. You have earned ' . config('coins.earn.good_deed') . ' Simba Coins';
        $notification->notification_type    = 'deed.approved';
        $notification->model_id             = $deed->id;
        $notification->save();

        session()->flash('success', 'Deed Approved');

        return redirect()->back();
    }

    public function disapproveDeed(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'required|max:800',
    	]);

    	$deed = GoodDeed::findOrFail($id);

    	$user = auth()->user();

    	$deed->approved 	= 0;
    	$deed->approver_id 	= null;
    	$deed->approved_at 	= null;

    	$deed->disapproved 			= 1;
    	$deed->disapproved_reason 	= $request->reason;
    	$deed->disapproved_at 		= $this->date;
    	$deed->disapprover_id		= $user->id;

    	$deed->update();

    	$notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $deed->user->id;
        $notification->system_message       = 1;
        $notification->from_admin       	= 1;
        $notification->message              = 'Your Good deed ' . $deed->name . ' has been disapproved. Reason : ' . $deed->disapproved_reason ;
        $notification->notification_type    = 'deed.disapproved';
        $notification->model_id             = $deed->id;
        $notification->save();

        session()->flash('success', 'Deed Dispproved');

        return redirect()->back();
    }

    //**********************************END OF DEEDS ********************************


    //**********************************START OF DONATED ITEMS ************************

    public function showDonatedItems($type){
    	$pagination = 20;

    	if($type == 'pending-approval'){
    		$title 			= 'Bought Items Pending Approval';
    		$donated_items 	= DonatedItem::where('bought', 1)->where('approved', 0)->where('disputed', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'community-shop'){
    		$title 			= 'Donated Items in the Community Shop';
    		$donated_items 	= DonatedItem::where('bought', 0)->where('approved', 0)->where('disapproved', 0)->where('disputed', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'approved'){
    		$title 			= 'Bought Goods Approved by Admin';
    		$donated_items 	= DonatedItem::where('bought', 1)->where('approved', 1)->where('disapproved', 0)->where('disputed', 0)->where('received', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}


    	elseif($type == 'delivered'){
    		$title 			= 'Bought Goods Delivered';
    		$donated_items 	= DonatedItem::where('bought', 1)->where('approved', 1)->where('disapproved', 0)->where('disputed', 0)->where('received', 1)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'disapproved'){
    		$title 			= 'Bought Goods Disapproved by Admin';
    		$donated_items 	= DonatedItem::where('disapproved', 1)->where('approved', 0)->where('disputed', 0)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	elseif($type == 'all'){
    		$title 			= 'All Donated Items';
    		$donated_items 	= DonatedItem::orderBy('created_at', 'DESC')->paginate($pagination);
    	}


    	elseif($type == 'trashed'){
    		$title 			= 'Trashed Items';
    		$donated_items 	= DonatedItem::orderBy('created_at', 'DESC')->onlyTrashed()->paginate($pagination);
    	}

    	elseif($type == 'disputed'){
    		$title 			= 'Disputed Items';
    		$donated_items 	= DonatedItem::where('disputed', 1)->orderBy('created_at', 'DESC')->paginate($pagination);
    	}

    	else{
    		abort(404);
    	}

    	return view('pages.admin.donated-items', [
    		'title'				=> $title,
    		'nav'				=> 'admin.donated-items',
    		'donated_items'		=> $donated_items,
    	]);
    }

    public function showDonatedItem(Request $request, $id){
    	$donated_item = DonatedItem::withTrashed()->findOrFail($id);

    	$user = auth()->user();

    	return view('pages.admin.donated-item',[
    		'title'			=> $donated_item->name,
    		'nav'			=> 'admin.donated-item',
    		'donated_item'	=> $donated_item,
    		'item'			=> $donated_item,
    	]);
    }

    public function approveDonatedItemPurchase(Request $request, $id){
    	$donated_item = DonatedItem::findOrFail($id);

    	$user = auth()->user();

    	$donated_item->approved = 1;
    	$donated_item->approved_by = $user->id;
    	$donated_item->approved_at = $this->date;

    	$donated_item->disapproved 			= 0;
    	$donated_item->disapproved_at 		= null;
    	$donated_item->disapproved_by 		= null;
    	$donated_item->disapproved_reason 	= null;

    	$donated_item->update();

    	$notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->buyer->id;
        $notification->system_message       = 1;
        $notification->from_admin       	= 1;
        $notification->message              = 'Your Donated Item Purchase Was Approved. DESC' . $donated_item->name;
        $notification->notification_type    = 'donated-item.purchase.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        session()->flash('success', 'Purchase Approved');

        return redirect()->back();
    }

    public function disapproveDonatedItemPurchase(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'required|max:800',
    	]);

    	$donated_item = DonatedItem::findOrFail($id);

    	$user = auth()->user();

    	$donated_item->approved = 0;
    	$donated_item->approved_by = null;
    	$donated_item->approved_at = null;

    	$donated_item->disapproved 			= 1;
    	$donated_item->disapproved_at 		= $this->date;
    	$donated_item->disapproved_by 		= $user->id;
    	$donated_item->disapproved_reason 	= $request->reason;

    	$notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->buyer->id;
        $notification->system_message       = 1;
        $notification->from_admin       	= 1;
        $notification->message              = 'Your Donated Item Purchase Was Not Approved. REASON' . $donated_item->disapproved_reason;
        $notification->notification_type    = 'donated-item.purchase.disapproved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $donated_item->bought 		= 0;
    	$donated_item->buyer_id 	= null;
    	$donated_item->bought_at 	= null;

    	$donated_item->update();

    	$escrow = $donated_item->escrow;

    	$buyer = $donated_item->buyer;

    	$buyer->coins += $escrow->amount;
    	$buyer->update();

    	$simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $buyer->id;
        $simba_coin_log->message               = 'Reversal - Payment for Donated item bought. DESC: ' . $donated_item->name;
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $escrow->amount;
        $simba_coin_log->previous_balance      = $buyer->coins - $escrow->amount ;
        $simba_coin_log->current_balance       = $buyer->coins;
        $simba_coin_log->save();

    	$escrow->delete();


        session()->flash('success', 'Purchase Disapproved');

        return redirect()->back();
    }

    public function confirmDonatedItemDelivery(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'max:800',
    	]);

    	$donated_item = DonatedItem::findOrFail($id);

    	$user = auth()->user();

    	$donated_item->disapproved 			= 0;
    	$donated_item->disapproved_at 		= null;
    	$donated_item->disapproved_by 		= null;
    	$donated_item->disapproved_reason 	= null;

    	$donated_item->received 			= 1;
    	$donated_item->received_at 			= $this->date;
    	$donated_item->received_message		= $request->reason . ' : Initiated by Admin';

    	$donated_item->update();

    	$escrow 					= $donated_item->escrow;
    	$donor 						= $donated_item->donor;

    	$donor->coins 				+= $escrow->amount;
    	$donor->accumulated_coins 	+= $escrow->amount;
    	$donor->update();

    	$donor->check_social_level();

    	$escrow->released 		= 1;
    	$escrow->released_at 	= $this->date;
    	$escrow->released_by 	= $user->id;
    	$escrow->update();

    	$timeline           = new \App\Timeline;
        $timeline->user_id  = $donated_item->buyer->id;
        $timeline->model_id = $donated_item->id;
        $timeline->message  = 'Purchased Donated Item:  ' . $donated_item->name;
        $timeline->type     = 'donated-item.delivery.approved';
        $timeline->extra    = '';
        $timeline->save();

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $donor->id;
        $simba_coin_log->message               = 'Payment for Donated item sold. DESC: ' . $donated_item->name;
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $escrow->amount;
        $simba_coin_log->previous_balance      = $donor->coins - $escrow->amount ;
        $simba_coin_log->current_balance       = $donor->coins;
        $simba_coin_log->save();

    	$notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->buyer->id;
        $notification->system_message       = 1;
        $notification->from_admin       	= 1;
        $notification->message              = 'Your Donated Item Purchase was marked as Deliverd by the admin. The Coins will now be released to the donor';
        $notification->notification_type    = 'donated-item.delivery.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->donor->id;
        $notification->system_message       = 1;
        $notification->message              = 'The Item Purchased by '. $donated_item->buyer->name .' Was marked as delivered. The funds have been released to your account.';
        $notification->notification_type    = 'donated-item.purchase.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        session()->flash('success', 'Item Marked as Received');

        return redirect()->back();
    }

    public function disputeDonatedItem(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'required|max:800',
    	]);

    	$donated_item = DonatedItem::findOrFail($id);

    	$user = auth()->user();

    	$donated_item->approved = 0;
    	$donated_item->approved_at = null;
    	$donated_item->approved_by = null;

    	$donated_item->disapproved 			= 0;
    	$donated_item->disapproved_at 		= null;
    	$donated_item->disapproved_by 		= null;
    	$donated_item->disapproved_reason 	= null;

    	$donated_item->disputed = 1;
    	$donated_item->disputed_at = $this->date;
    	$donated_item->disputed_by = $user->id;
    	$donated_item->disputed_reason = $request->reason;

    	$donated_item->received = 0;
    	$donated_item->received_at = null;
    	$donated_item->received_message = null;

     	$escrow = $donated_item->escrow;
    	$donor = $donated_item->donor;
    	$buyer = $donated_item->buyer;

    	if($escrow->released){
    		$buyer->coins += $escrow->amount;
    		$buyer->update();

    		$donor->coins -= $escrow->amount;
    		$donor->update();

    		$simba_coin_log                        = new SimbaCoinLog;
	        $simba_coin_log->user_id               = $donor->id;
	        $simba_coin_log->message               = 'Reversal - Payment for Donated item sold. DESC: ' . $donated_item->name;
	        $simba_coin_log->type                  = 'debit';
	        $simba_coin_log->coins                 = $escrow->amount;
	        $simba_coin_log->previous_balance      = $donor->coins + $escrow->amount ;
	        $simba_coin_log->current_balance       = $donor->coins;
	        $simba_coin_log->save();

	        $notification                       = new Notification;
	        $notification->from_id              = $user->id;
	        $notification->to_id                = $donor->id;
	        $notification->message              = 'Payment for Item ['. $donated_item->name .'] has been reversed';
	        $notification->system_message		= 1;
	        $notification->from_admin       	= 1;
	        $notification->notification_type    = 'donated-item.disputed';
	        $notification->model_id             = $donated_item->id;
	        $notification->save();

    	}else{
    		$buyer->coins += $escrow->amount;
    		$buyer->update();
    	}

    	$donated_item->bought 		= 0;
    	$donated_item->buyer_id 	= null;
    	$donated_item->bought_at 	= null;

    	$donated_item->update();

    	$simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $buyer->id;
        $simba_coin_log->message               = 'Refund - Payment for Donated item purchase. DESC: ' . $donated_item->name;
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $escrow->amount;
        $simba_coin_log->previous_balance      = $buyer->coins - $escrow->amount ;
        $simba_coin_log->current_balance       = $buyer->coins;
        $simba_coin_log->save();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $buyer->id;
        $notification->message              = 'Payment for Item ['. $donated_item->name .'] has been reversed';
        $notification->system_message		= 1;
        $notification->from_admin       	= 1;
        $notification->notification_type    = 'donated-item.disputed';
        $notification->model_id             = $donated_item->id;
        $notification->save();

    	$escrow->delete();

    	session()->flash('success', 'Item Disputed');

    	return redirect()->back();
    }

    public function deleteDonatedItem(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'required|max:800',
    	]);

    	$donated_item = DonatedItem::findOrFail($id);

    	$user = auth()->user();

    	$donated_item->deleted_by = $user->id;
    	$donated_item->deleted_reason = $request->reason;
    	$donated_item->update();

    	$donated_item->delete();

    	session()->flash('success', 'Donated Item deleted');

    	return redirect()->route('admin.donated-items' , ['type' => 'all']);
    }

    //**********************END OF DONATED ITEMS ***********************************

    //**********************USERS***************************************************

    public function showUsers($type){
    	$pagination = 20;

    	if($type == 'all'){
    		$title = 'All Users';
    		$users = User::where('usertype', 'USER')->where('is_admin', 0)->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	elseif($type == 'active'){
    		$title = 'Active Users';
    		$users = User::where('usertype', 'USER')->where('is_admin', 0)->where('closed', '0')->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	elseif($type == 'inactive'){
    		$title = 'Closed Accounts';
    		$users = User::where('usertype', 'USER')->where('is_admin', 0)->where('closed', '1')->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	else{
    		abort(404);
    	}

    	return view('pages.admin.users', [
    		'title' => $title,
    		'nav'	=> 'admin.users',
    		'users'	=> $users,
    	]);
    }

    public function showAdmins($type){
    	$pagination = 20;

    	if($type == 'all'){
    		$title = 'All Admins';
    		$users = User::where('usertype', 'ADMIN')->where('is_admin', 1)->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	elseif($type == 'active'){
    		$title = 'Active Admins';
    		$users = User::where('usertype', 'ADMIN')->where('is_admin', 1)->where('closed', '0')->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	elseif($type == 'inactive'){
    		$title = 'Closed Admin Accounts';
    		$users = User::where('usertype', 'ADMIN')->where('is_admin', 1)->where('closed', '1')->orderBy('name', 'ASC')->paginate($pagination);
    	}

    	else{
    		abort(404);
    	}

    	return view('pages.admin.users', [
    		'title' => $title,
    		'nav'	=> 'admin.users',
    		'users'	=> $users,
    	]);
    }

    public function showUser($id){
    	$user 	= User::findOrFail($id);
    	$me 	= false;

    	if($user->id == auth()->user()->id){
    		$me = true;
    	}

    	return view('pages.admin.user', [
    		'title' => $user->name,
    		'nav'	=> 'admin.user',
    		'user'	=> $user,
    		'me'	=> $me,
    	]);
    }

    public function closeAccount(Request $request, $id){
    	$user = User::findOrFail($id);

    	$admin = auth()->user();

    	$user->closed = 1;
    	$user->closed_at = $this->date;
    	$user->closed_by = $admin->id;
    	$user->closed_reason = $request->reason;
    	

    	if($user->coins > 0){

    		$previous_coins = $user->coins;

    		$this->settings->available_balance->value += $user->coins;
    		$this->settings->available_balance->update();
    		$user->coins = 0;

    		$simba_coin_log                        = new SimbaCoinLog;
        	$simba_coin_log->user_id               = $user->id;
        	$simba_coin_log->message               = 'Coins sent back to community after closing account';
	        $simba_coin_log->type                  = 'debit';
	        $simba_coin_log->coins                 = $previous_coins;
	        $simba_coin_log->previous_balance      = $previous_coins ;
	        $simba_coin_log->current_balance       = 0;
	        $simba_coin_log->save();

    	}

    	$user->update();

    	session()->flash('success', 'Account Closed');

    	return redirect()->back();
    }

    //*********************END OF USERS*********************************************

    public function showTransactions($type){
    	
    }

    //***************************************************START OF ESCROW**********************

    public function showEscrow($type){
    	$pagination = 50;

    	if($type == 'settled'){
    		$title = 'Settled Escrow';
    		$escrow = Escrow::where('released', 1)->paginate($pagination);
    	}elseif($type == 'pending'){
    		$title = 'Pending Escrow';
    		$escrow = Escrow::where('released', 0)->paginate($pagination);
    	}else{
    		abort(404);
    	}

    	return view('pages.admin.escrow', [
    		'nav'		=> 'admin.escrow',
    		'title'		=> $title,
    		'escrow'	=> $escrow,
    	]);
    }

    //*************************END OF ESCROW*****************************************

    
    //***************************** MESSAGES ****************************************

    public function newMessage(Request $request, $id){

        $sender     = auth()->user();

        $recepient  = User::findOrFail($id);

        $from_conversation  = Conversation::where('from_admin', '1')->where('to_id', $recepient->id)->first();
        $to_conversation    = Conversation::where('support', '1')->where('from_id', $recepient->id)->first();
        
        if($from_conversation){
            $conversation = $from_conversation;
        }elseif($to_conversation){
            $conversation = $to_conversation;
        }else{
            $conversation = new Conversation;
            $conversation->to_id = $recepient->id;
            $conversation->from_id = $sender->id;
            $conversation->from_admin = 1;
            $conversation->support = 1;
            $conversation->save();
        }

        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Message Sent']);
        }

        return redirect()->route('admin.message.view', ['id' => $conversation->id]);
    }

    public function showMessages($type){
    	$pagination = 50;

    	if($type == 'all'){
    		$title 			= 'Conversations';
    		$nav 			= 'admin.conversations.all';

    		$conversations 	= Conversation::where('support', 1)->orWhere('from_admin', 1)->orderBy('updated_at', 'DESC')->paginate($pagination);

    	// }elseif($type == 'unread'){
    	// 	$conversations 	= Conversation::where('support', 1)->orWhere('from_admin', 1)->orderBy('updated_at', 'ASC')->get();


    	// 	$con = [];

    	// 	foreach ($conversations as $conversation) {
    	// 		$unread = false;
    	// 		$conversation->thread = '';

    	// 		$last_message = $conversation->messages()->orderBy('created_at', 'DESC')->first();

    	// 		if($last_message){
    	// 			if($last_message->support && is_null($last_message->to_id) && !$last_message->read){
	    // 				$unread = true;
	    // 			}

	    // 			$conversation->thread = $last_message->message;
    	// 		}

    	// 		$conversation->unread = $unread;
    	// 		$con[] = $conversation; 
    	// 	}

    	// 	$conversations = $con;

    	// 	$title 			= 'Unread Conversations';
    	// 	$nav 			= 'admin.conversations.unread';

    	// }elseif($type == 'read'){

    	// 	$title 			= 'Read Conversations';
    	// 	$nav 			= 'admin.conversations.read';

    	}

    	else{
    		abort(404);
    	}

    	return view('pages.admin.conversations', [
    		'title'			=> $title,
    		'nav'			=> $nav,
    		'conversations'	=> $conversations
    	]);
    }

    public function showMessage($id){
    	$conversation = Conversation::findOrFail($id);

    	$unread_messages = $conversation->messages()->where('support', 1)->where('from_admin', '0')->where('read', 0)->get();

    	foreach ($unread_messages as $message) {
    		$message->read = 1;
    		$message->read_at = $this->date;
    		$message->update();
    	}

    	if($conversation->from_admin)
			$recepient = $conversation->to;
		else{
			$recepient = $conversation->from;
		}

    	return view('pages.admin.conversation', [
    		'title'			=> $recepient->name,
    		'nav'			=> 'admin.conversation',
    		'conversation'	=> $conversation,
    		'recepient'		=> $recepient,
    	]);
    }

    public function showComposeMessageForm(){
    	$pagination = 50;
    	$users = User::where('usertype', 'USER')->where('is_admin', 0)->where('closed', 0)->orderBy('name', 'ASC')->paginate($pagination);

    	return view('pages.admin.compose-message', [
    		'title'	=> 'Compose Message',
    		'nav'	=> 'admin.compose-message',
    		'users'	=> $users,
    	]);
    }

    public function postMessage(Request $request, $id){
        $this->validate($request, [
            'message' => 'required',
        ]);

        $user               = auth()->user();
        $recepient          = null;

        $conversation = Conversation::findOrFail($id);

        if($conversation->from_admin){
            $recepient = $conversation->to;
        }else{
            $recepient = $conversation->from;
        }

        if(!$recepient){
            $message = 'Recepient not found';

            if($request->ajax()){
                $response = ['status' => 404, 'message' => $message];
                return response()->json($response);
            }
            session()->flash('error', $message);
            return redirect()->back();
        }

        $message                    = new Message;
        $message->from_id           = $user->id;
        $message->to_id             = $recepient->id;
        $message->conversation_id   = $conversation->id;
        $message->message           = ucfirst($request->message);
        $message->support           = $conversation->support;
        $message->from_admin        = 1;
        $message->save();

        $message_notification                       = new MessageNotification;
        $message_notification->from_id              = $user->id;
        $message_notification->to_id                = $recepient->id;
        $message_notification->conversation_id      = $conversation->id;
        $message_notification->message_id           = $message->id;
        $message_notification->support              = $conversation->support;
        $message_notification->from_admin           = 1;
        $message_notification->save();

        $conversation->updated_at = $this->date;
        $conversation->update();

        $msg = 'Message sent';

        if($request->ajax()){
            $details = [
            	'from'		=> 'Admin',
            	'message'	=> $message->message,
            	'time'		=> $message->created_at->diffForHumans(),
            ];

            $response = ['status' => 200, 'message' => $msg, 'details' => $details];
            
            return response()->json($response);
        }

        session()->flash('success', $msg);

        return redirect()->back();
    }

    public function getAjaxConversation($id){
        $user           = auth()->user();
        
        $conversation   = Conversation::find($id);

        if(!$conversation){
            return response()->json(['status' => 404, 'message' => 'Conversation not found']);
        }

        $messages = $conversation->messages()->where('read', 0)->where('from_admin', 0)->get();
        
        $notifications = $conversation->notifications()->where('read', 0)->where('from_admin', 0)->get();

        if(count($notifications)){
            foreach ($notifications as $notification) {
                $notification->read = 1;
                $notification->read_at = $this->date;
                $notification->update();
            }
        }
        
        $count = count($messages);

        if($count){
            foreach ($messages as $message) {
                $message->read = 1;
                $message->read_at = $this->date;
                $message->update();
            }
        }

        $messages = [];

        foreach ($conversation->messages()->orderBy('created_at', 'ASC')->get() as $message) {
            if($message->from_admin){
                $from = 'Admin';
            }else{
                if($message->from_id){
                	$from = $message->sender->name;
                }
            }
            

            $messages[] = [
                'from'      => $from,
                'mine'      => $message->from_admin ? '1' : '0',
                'message'   => $message->message,
                'time'      => $message->created_at->diffForHumans(),
            ];
        }

        $response = [
            'status'    => 200,
            'message'   => 'Success',
            'messages'  =>  $messages,
            'count'     =>  $count,
        ];

        return response()->json($response);
    }

    //*********************END OF MESSAGES*****************************************

    public function showSiteSettings(){
    	
    	return view('pages.admin.site-settings', [
    		'title'		=> 'Site Settings',
    		'nav'		=> 'admin.site-settings',
    		'settings'	=> $this->settings,
    	]);
    }

}
