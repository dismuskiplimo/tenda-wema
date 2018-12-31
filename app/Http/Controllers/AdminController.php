<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, DonatedItem, DonatedItemImage, Profile, Timeline, UserReview, SimbaCoinLog, Notification, GoodDeed, GoodDeedImage, Membership, Education, WorkExperience, Skill, Award, Hobby, Achievement, Escrow, CoinPurchaseHistory, Conversation, Message, MessageNotification, MpesaTransaction, Donation, ContactUs, Paypal_Transaction, ReportType, UserReport, UserReportType, DonatedItemReview, CancelOrder, ErrorLog};

use Image, Auth, Session, Mail;

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
    	return view('pages.admin.account', [
    		'title' => 'Account',
    		'nav'	=> 'admin.account',
    	]);
    }

    public function showAccountSettings(){
    	return view('pages.admin.account-settings', [
    		'title' => 'Account Settings',
    		'nav'	=> 'admin.account-settings',
    	]);
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
        $simba_coin_log->message               = config('coins.earn.good_deed') . ' Simba Coins for diong a good deed. (' . $deed->name . ')';
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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Good Deed Approved';

            try{
                \Mail::send('emails.good-deed-approved', ['title' => $title, 'deed' => $deed], function ($message) use($title, $deed){
                    $message->subject($title);
                    $message->to($deed->user->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Good Deed Not Approved';

            try{
                \Mail::send('emails.good-deed-disapproved', ['title' => $title, 'deed' => $deed], function ($message) use($title, $deed){
                    $message->subject($title);
                    $message->to($deed->user->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

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
        $notification->message              = 'Your Donated Item Purchase Was Approved. (' . $donated_item->name .')';
        $notification->notification_type    = 'donated-item.purchase.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Purchase Approved';

            try{
                \Mail::send('emails.donated-item-purchase-approved-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

                \Mail::send('emails.donated-item-purchase-approved-seller', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

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
        $simba_coin_log->message               = 'Reversal - Payment for Donated item bought.  (' . $donated_item->name . ')';
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $escrow->amount;
        $simba_coin_log->previous_balance      = $buyer->coins - $escrow->amount ;
        $simba_coin_log->current_balance       = $buyer->coins;
        $simba_coin_log->save();

    	$escrow->delete();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Purchase Not Approved';

            try{
                \Mail::send('emails.donated-item-purchase-disapproved-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

                \Mail::send('emails.donated-item-purchase-disapproved-seller', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }


        session()->flash('success', 'Purchase Disapproved');

        return redirect()->back();
    }

    public function confirmDonatedItemDelivery(Request $request, $id){
    	$this->validate($request, [
    		'reason' => 'max:50000',
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
        $simba_coin_log->message               = 'Payment for Donated item sold. (' . $donated_item->name . ')';
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
        $notification->message              = 'Your Donated Item Purchase was marked as delivered by the admin. The Coins will now be released to the seller';
        $notification->notification_type    = 'donated-item.delivery.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->donor->id;
        $notification->system_message       = 1;
        $notification->message              = 'The Item Purchased by '. $donated_item->buyer->name .' Was marked as delivered. The funds have been released to your account.';
        $notification->notification_type    = 'donated-item.delivery.approved';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Delivered';

            try{
                \Mail::send('emails.donated-item-received-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

                \Mail::send('emails.donated-item-received-donor', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

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
	        $simba_coin_log->message               = 'Reversal - Payment for Donated item sold. (' . $donated_item->name . ')';
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
        $simba_coin_log->message               = 'Refund - Payment for Donated item purchase. (' . $donated_item->name . ')';
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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Purchase Disputed';

            try{
                \Mail::send('emails.donated-item-purchase-disputed-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

                \Mail::send('emails.donated-item-purchase-disputed-seller', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Removed from Community Shop';

            try{
                \Mail::send('emails.donated-item-deleted-donor', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

        $donated_item->delete();

    	session()->flash('success', 'Donated Item deleted');

    	return redirect()->route('admin.donated-items' , ['type' => 'all']);
    }

    public function cancelDonatedItemPurchase(Request $request, $id){
        
        $donated_item = DonatedItem::findOrFail($id);

        $user = auth()->user();

        $donated_item->disapproved          = 0;
        $donated_item->disapproved_at       = null;
        $donated_item->disapproved_by       = null;
        $donated_item->disapproved_reason   = null;

        $donated_item->approved             = 0;
        $donated_item->approved_by          = null;
        $donated_item->approved_at          = null;

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->buyer->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->message              = 'Your Donated Item Purchase Was Cancelled. (' . $donated_item->name . ')';
        $notification->notification_type    = 'donated-item.purchase.cancelled';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->donor->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->message              = 'Your Donated Item (' . $donated_item->name . ') Sale Was Cancelled. The item has been returned to the community shop';
        $notification->notification_type    = 'donated-item.purchase.cancelled';
        $notification->model_id             = $donated_item->id;
        $notification->save();
        $notification->save();

        $escrow                             = $donated_item->escrow;
        $buyer                              = $donated_item->buyer;
        $buyer->coins                       += $escrow->amount;
        
        $buyer->update();

        $simba_coin_log                     = new SimbaCoinLog;
        $simba_coin_log->user_id            = $buyer->id;
        $simba_coin_log->message            = 'Reversal - Payment for Donated item bought.  (' . $donated_item->name . ')';
        $simba_coin_log->type               = 'credit';
        $simba_coin_log->coins              = $escrow->amount;
        $simba_coin_log->previous_balance   = $buyer->coins - $escrow->amount ;
        $simba_coin_log->current_balance    = $buyer->coins;
        $simba_coin_log->save();

        $donated_item->bought               = 0;
        $donated_item->buyer_id             = null;
        $donated_item->bought_at            = null;

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Purchase Cancelled';

            try{
                \Mail::send('emails.donated-item-purchase-cancelled-donor', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

                \Mail::send('emails.donated-item-purchase-cancelled-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

        $donated_item->update();

        $escrow->delete();


        session()->flash('success', 'Purchase Cancelled');

        return redirect()->back();
    }

    //**********************END OF DONATED ITEMS ***********************************


    //**********************CANCEL ORDER REQUEST ***********************************

    public function showOrderCancellations($type){
        if($type == 'all'){
            $cancel_requests    = CancelOrder::orderBy('created_at', 'DESC')->paginate(50);
            $nav                = 'admin.cancel-orders';
            $title              = 'All Order Cancellation Requests';
        }

        return view('pages.admin.cancel-orders', [
            'nav'               => $nav,
            'title'             => $title,
            'cancel_requests'   => $cancel_requests,
        ]);
    }

    public function showOrderCancellation($id){
        $cancel_request = CancelOrder::findOrFail($id);

        return view('pages.admin.cancel-order', [
            'nav'               => 'admin.cancel-order',
            'title'             => 'Cancel Order Request',
            'cancel_request'    => $cancel_request,
            'item'              => $cancel_request->donated_item,
        ]);
    }

    public function approveOrderCancellation(Request $request, $id){
        $cancel_request = CancelOrder::findOrFail($id);
        $user           = auth()->user();
        $donated_item   = $cancel_request->donated_item;

        $donated_item->approved     = 0;
        $donated_item->approved_by  = null;
        $donated_item->approved_at  = null;

        $donated_item->disapproved          = 0;
        $donated_item->disapproved_at       = null;
        $donated_item->disapproved_by       = null;
        $donated_item->disapproved_reason   = null;

        $cancel_request->approved          = 1;
        $cancel_request->approved_by       = $user->id;
        $cancel_request->approved_at       = $this->date;
        $cancel_request->update();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->buyer->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->message              = 'Your Donated Item (' . $donated_item->name . ')' . ' Purchase Was Cancelled.';
        $notification->notification_type    = 'donated-item.purchase.cancelled';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $notification                       = new Notification;
        $notification->from_id              = $user->id;
        $notification->to_id                = $donated_item->donor->id;
        $notification->system_message       = 1;
        $notification->from_admin           = 1;
        $notification->message              = 'Your Donated Item (' . $donated_item->name . ') Sale Was Cancelled. The item has been returned to the community shop';
        $notification->notification_type    = 'donated-item.purchase.cancelled';
        $notification->model_id             = $donated_item->id;
        $notification->save();

        $escrow                     = $donated_item->escrow;

        $buyer                      = $donated_item->buyer;

        $buyer->coins               += $escrow->amount;
        
        $buyer->update();

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $buyer->id;
        $simba_coin_log->message               = 'Reversal - Payment for Donated item bought.  (' . $donated_item->name . ')';
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = $escrow->amount;
        $simba_coin_log->previous_balance      = $buyer->coins - $escrow->amount ;
        $simba_coin_log->current_balance       = $buyer->coins;
        $simba_coin_log->save();

        
        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donated Item Purchase Cancelled';

            try{
                \Mail::send('emails.donated-item-purchase-cancelled-donor', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->donor->email);
                });

                \Mail::send('emails.donated-item-purchase-cancelled-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                    $message->subject($title);
                    $message->to($donated_item->buyer->email);
                });

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }


        $donated_item->bought       = 0;
        $donated_item->buyer_id     = null;
        $donated_item->bought_at    = null;
        $donated_item->update();

        $escrow->delete();

        session()->flash('success', 'Purchase cancelled');

        return redirect()->back();

    }

    public function dismissOrderCancellation(Request $request, $id){
        $this->validate($request, [
            'reason' => 'required|max:50000'
        ]);

        $user = auth()->user();

        $cancel_request                     = CancelOrder::findOrFail($id);

        $cancel_request->dismissed          = 1;
        $cancel_request->dismissed_by       = $user->id;
        $cancel_request->dismissed_at       = $this->date;
        $cancel_request->dismissed_reason   = $request->reason;
        $cancel_request->update();

        $notification           = new Notification;
        $notification->from_id  = null;
        $notification->to_id    = $cancel_request->user->id;
        $notification->message  = 'Purchase cancellation for (' . $cancel_request->donated_item->name . ') declined. Reason: ' . $request->reason;
        $notification->notification_type = 'purchase-cancellation.declined';
        $notification->model_id = $cancel_request->donated_item->id;
        $notification->save();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Purchase Cancellation Dismissed';

            try{
                \Mail::send('emails.donated-item-purchase-cancel-dismissed', ['title' => $title, 'cancel_request' => $cancel_request], function ($message) use($title, $cancel_request){
                    $message->subject($title);
                    $message->to($cancel_request->user->email);
                });

               

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Request Dismissed');

        return redirect()->back();
    }

    //**********************END OF ORDER CANCEL REQUEST ***********************************

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

    	$stars = $user->reviews ? ($user->rating / $user->reviews) : 0;

		$stars = $stars == 5 ? 5 : floor($stars);

    	return view('pages.admin.user', [
    		'title' => $user->name,
    		'nav'	=> 'admin.user',
    		'user'	=> $user,
    		'me'	=> $me,
    		'stars'	=> $stars,
    	]);
    }

    public function verifyUser(Request $request, $id){
    	$user = User::findOrFail($id);

    	$admin = auth()->user();

    	$user->verified = 1;
    	$user->verified_at = $this->date;
    	$user->verified_by = $admin->id;  	

    	$user->update();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Account Verified';

            try{
                \Mail::send('emails.user-account-verified', ['title' => $title, 'user' => $user], function ($message) use($title, $user){
                    $message->subject($title);
                    $message->to($user->email);
                });

               

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

    	session()->flash('success', 'User Verified');

    	return redirect()->back();
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

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Account Closed';

            try{
                \Mail::send('emails.user-account-closed', ['title' => $title, 'user' => $user], function ($message) use($title, $user){
                    $message->subject($title);
                    $message->to($user->email);
                });

               

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

    	session()->flash('success', 'Account Closed');

    	return redirect()->back();
    }

    public function showUserDonatedItems(Request $request, $id){
    	$user = User::findOrFail($id);

    	$donated_items = $user->donated_items()->orderBy('created_at', 'DESC')->paginate(48);

    	return view('pages.admin.user-donated-items', [
    		'title' 		=> $user->name . ' | Donated Items (' . number_format($donated_items->total()) . ')',
    		'nav'			=> 'admin.user.donated-items',
    		'user'			=> $user,
    		'donated_items'	=> $donated_items,
    	]);
    }

    public function showUserTransactions(Request $request, $id){
    	$user 			= User::findOrFail($id);
    	$transactions 	= $user->transactions()->orderBy('created_at', 'DESC')->paginate(50);

    	return view('pages.admin.user-transactions', [
    		'title' 		=> $user->name . ' | Transactions (' . number_format($transactions->total()) . ')' ,
    		'nav'			=> 'admin.user.transactions',
    		'user'			=> $user,
    		'transactions' 	=> $transactions,
    	]);
    }

    public function showUserBoughtItems(Request $request, $id){
    	$user = User::findOrFail($id);

    	$bought_items = $user->bought_items()->orderBy('created_at', 'DESC')->paginate(48);

    	return view('pages.admin.user-bought-items', [
    		'title' 		=> $user->name . ' | Bought Items (' . number_format($bought_items->total()) . ')',
    		'nav'			=> 'admin.user.bought-items',
    		'user'			=> $user,
    		'bought_items'	=> $bought_items,
    	]);
    }

    public function showUserReviews(Request $request, $id){
    	$user = User::findOrFail($id);

    	$reviews = $user->reviews()->orderBy('created_at', 'DESC')->paginate(48);

    	return view('pages.admin.user-reviews', [
    		'title' 	=> $user->name . ' | Reviews (' . number_format($reviews->total()) . ')',
    		'nav'		=> 'admin.user.reviews',
    		'user'		=> $user,
    		'reviews'	=> $reviews,
    	]);
    }

    public function showUserPhotos(Request $request, $id){
    	$user = User::findOrFail($id);

    	$photos = $user->photos()->orderBy('created_at', 'DESC')->paginate(48);

    	return view('pages.admin.user-photos', [
    		'title' 	=> $user->name . ' | Photos (' . number_format($photos->total()) . ')',
    		'nav'		=> 'admin.user.photos',
    		'user'		=> $user,
    		'photos'	=> $photos,
    	]);
    }

    public function showUserGoodDeeds(Request $request, $id){
    	$user = User::findOrFail($id);
    	$good_deeds = $user->good_deeds()->where('approved', 1)->orderBy('created_at', 'DESC')->paginate(50);

    	return view('pages.admin.user-good-deeds', [
    		'title' 		=> $user->name . ' | Good Deeds (' . number_format($good_deeds->total()) . ')',
    		'nav'			=> 'admin.user.good-deeds',
    		'user'			=> $user,
    		'good_deeds' 	=> $good_deeds,
    	]);
    }

    public function showUserSimbaCoinLogs(Request $request, $id){
    	$user = User::findOrFail($id);
    	$simba_coin_logs = $user->simba_coin_logs()->orderBy('created_at', 'DESC')->paginate(50);

    	return view('pages.admin.user-simba-coin-logs', [
    		'title' 			=> $user->name . ' | Simba Coin Logs (' . number_format($simba_coin_logs->total()) . ')',
    		'nav'				=> 'admin.user.simba-coin-logs',
    		'user'				=> $user,
    		'simba_coin_logs' 	=> $simba_coin_logs,

    	]);
    }

    //*********************END OF USERS*********************************************

    
    //***************************************************START OF TRANSACTIONS **********************


    public function showTransactions($type){
    	if($type == 'mpesa'){
    		$title 			= 'MPESA Transactions';
    		$nav 			= 'admin.transactions.mpesa';
    		$page 			= 'pages.admin.mpesa-transactions';
    		$transactions 	= MpesaTransaction::orderBy('created_at', 'DESC')->paginate(50);
    	}

        elseif($type == 'paypal'){
            $title          = 'Paypal Transactions';
            $nav            = 'admin.transactions.paypal';
            $page           = 'pages.admin.paypal-transactions';
            $transactions   = Paypal_Transaction::orderBy('created_at', 'DESC')->paginate(50);
        }
        else{
    		abort(404);
    	}

    	return view($page, [
    		'title' 		=> $title,
    		'nav' 			=> $nav,
    		'transactions' 	=> $transactions,
    	]);
    }

    //*************************END OF TRANSACTIONS *****************************************

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

    public function showComposeMessageForm(){
        $pagination = 50;
        $users = User::where('usertype', 'USER')->where('is_admin', 0)->where('closed', 0)->orderBy('name', 'ASC')->paginate($pagination);

        return view('pages.admin.compose-message', [
            'title' => 'Compose Message',
            'nav'   => 'admin.compose-message',
            'users' => $users,
        ]);
    }

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
                'from'      => 'Admin',
                'message'   => $message->message,
                'time'      => $message->created_at->diffForHumans(),
            ];

            $response = ['status' => 200, 'message' => $msg, 'details' => $details];
            
            return response()->json($response);
        }

        session()->flash('success', $msg);

        return redirect()->back();
    }

    public function showMessages($type){
    	$pagination = 50;

    	if($type == 'all'){
    		$title 			= 'Conversations';
    		$nav 			= 'admin.conversations.all';

    		$conversations 	= Conversation::where('support', 1)->orWhere('from_admin', 1)->orderBy('updated_at', 'DESC')->paginate($pagination);
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

    // ********************SITE SETTINGS *****************************************

    public function showSiteSettings(){
    	
    	return view('pages.admin.site-settings', [
    		'title'		=> 'Site Settings',
    		'nav'		=> 'admin.site-settings',
    		'settings'	=> $this->settings,
    	]);
    }


    // **********************END OF SITE SETTINGS ***********************************

    // ******************************NOTIFICATIONS *********************************

    public function showNotifications(){
    	
    	return view('pages.admin.notifications', [
    		'title'		=> 'Notifications',
    		'nav'		=> 'admin.notifications',
    	]);
    }

    // ************************END OF NOTIFICATIONS ********************************

    
    // **************************SUPPORT THE CAUSE *********************************

    public function showSupportCausesPage(){
        $donations = Donation::orderBy('created_at', 'DESC')->paginate(50);

        return view('pages.admin.support-causes', [
            'title'     => 'Support Cause Requests',
            'nav'       => 'admin.support-causes',
            'donations' => $donations,
        ]);
    }

    public function showSupportCausePage($id){
        $donation = Donation::findOrFail($id);

        return view('pages.admin.support-cause', [
            'title' => 'Support the Cause',
            'nav'   => 'admin.support-cause',
            'donation'  => $donation,
        ]);
    }

    public function postConfirmCause(Request $request, $id){
        $donation = Donation::findOrFail($id);

        $user = auth()->user();

        $donation->received = 1;
        $donation->received_by = $user->id;
        $donation->received_at = $this->date;
        $donation->update();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donation Received';

            try{
                \Mail::send('emails.donation-received', ['title' => $title, 'user' => $donation], function ($message) use($title, $donation){
                    $message->subject($title);
                    $message->to($donation->email);
                });

               

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Donation marked as received');

        return redirect()->back();
    }

    public function postDismissCause(Request $request, $id){
        $this->validate($request, [
            'reason' => 'required|max:800',
        ]);

        $donation = Donation::findOrFail($id);

        $user = auth()->user();

        $donation->received = 0;
        $donation->received_by = null;
        $donation->received_at = null;

        $donation->dismissed = 1;
        $donation->dismissed_by = $user->id;
        $donation->dismissed_at = $this->date;
        $donation->dismissed_reason = $request->reason;

        $donation->update();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . ' | Donation Request Dismissed';

            try{
                \Mail::send('emails.donation-dismissed', ['title' => $title, 'user' => $donation], function ($message) use($title, $donation){
                    $message->subject($title);
                    $message->to($donation->email);
                });

               

            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Donation request dismissed');

        return redirect()->back();
    }

    // ************************END OF SUPPORT CAUSE*********************************

    
    // ************************CONTACT US MESSAGES**********************************

    public function showContactFormPage(){
        $contacts = ContactUs::orderBy('created_at', 'DESC')->paginate(50);

        return view('pages.admin.contact-form-messages', [
            'title'     => 'Contact From Messages',
            'nav'       => 'admin.contact-form-messages',
            'contacts'  => $contacts,
        ]);
    }

    public function showContactFormMessage($id){
        $contact = ContactUs::findOrFail($id);
        $user = auth()->user();

        if(!$contact->read){
            $contact->read = 1;
            $contact->read_at = $this->date;
            $contact->read_by = $user->id;
            $contact->update();
        }

        return view('pages.admin.contact-form-message', [
            'title'     => $contact->subject,
            'nav'       => 'admin.support-causes',
            'contact'   => $contact,
        ]);
    }

    // ************************* END OF CONTACT US MESSAGES *************************

    
    // ************************ USER REPORTS ****************************************

    public function getReportedUsers($type){
        if($type == 'all'){
            $reports = UserReport::orderBy('created_at', 'DESC')->withTrashed()->paginate(50);
            $title = 'All Misconduct Instances';
            $nav = 'user.reported.all';

        }elseif($type == 'approved'){
            $reports = UserReport::where('approved', 1)->where('dismissed', 0)->orderBy('created_at', 'DESC')->withTrashed()->paginate(50);
            $title = 'Confirmed Misconducts';
            $nav = 'user.reported.approved';

        }elseif($type == 'dismissed'){
            $reports = UserReport::where('dismissed', 1)->where('approved', 0)->orderBy('created_at', 'DESC')->withTrashed()->paginate(50);
            $title = 'Dismissed Misconducts';
            $nav = 'user.reported.dismissed';
        }elseif($type == 'pending'){
            $reports = UserReport::where('approved', 0)->where('dismissed', 0)->orderBy('created_at', 'DESC')->withTrashed()->paginate(50);
            $title = 'Confirmed Misconducts';
            $nav = 'user.reported.approved';
        }else{
            abort(404);
        }

        return view('pages.admin.user-misconducts', [
            'title'     => $title,
            'nav'       => $nav,
            'reports'   => $reports,
        ]);
    }

    public function getReportedUserSingle($id){
        $user_report = UserReport::withTrashed()->findOrFail($id);

        return view('pages.admin.user-misconduct', [
            'title'     => $user_report->report_type->description,
            'nav'       => 'admin.user-misconduct',
            'report'    => $user_report,
        ]);
    }

    // ************************ END OF USER REPORTS *********************************

}
