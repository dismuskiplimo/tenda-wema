<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, DonatedItem, DonatedItemImage, Profile, Timeline, UserReview, SimbaCoinLog, Notification, GoodDeed, GoodDeedImage, Membership, Education, WorkExperience, Skill, Award, Hobby, Achievement,QuotesILove, MyInterest, BooksYouShouldRead, WorldIDesire, Escrow, CoinPurchaseHistory, Conversation, Message, MessageNotification, ReportType, UserReport, UserReportType, Post, Comment, DonatedItemReview, CancelOrder, ErrorLog, ModeratorRequest, CommunityMemberAward, MostActiveMemberAward};

use Image, Auth, Session, Mail;

use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
        $this->middleware('is_user');
    	$this->middleware('not_closed');
        $this->middleware('check_coins');
        $this->middleware('has_profile');
        $this->middleware('email_verified');
        $this->initialize();
    }

    // **************************DASHBOARD PAGE ***************************************

    public function showDashboard(){
    	$user = auth()->user();

        return redirect()->route('user.show', $user->username);
        

        return view('pages.user.index', [
    		'title' => 'User Dashboard',
    		'nav'	=> 'user.dashboard',
    	]);
    }

    // **************************USER BALANCE *****************************************

    public function showBalance(){
        $user = auth()->user();

        $coin_request = $user->coin_purchase_history()->where('approved', 0)->where('disapproved', 0)->first();
        
        return view('pages.user.user-balance', [
            'title'         => 'Account Balance',
            'nav'           => 'user.account-balance',
            'user'          => $user,
            'coin_request'  => $coin_request,
            'settings'      => $this->settings,
        ]);
    }

    // **************************SETTING PAGE *****************************************

    public function showSettings(){
        $user = auth()->user();

        return view('pages.user.user-settings', [
            'title'     => 'Settings',
            'nav'       => 'user.settings',
            'user'      => $user,
        ]);
    }

    // **************************USER PROFILE *****************************************

    public function showMyProfile(){
        $user = auth()->user();

        return view('pages.user.my-profile', [
            'title'     => 'Profile',
            'nav'       => 'user.profile',
            'user'      => $user,
        ]);
    }

    // **************************CREATE CONVERSATION **********************************

    public function newMessage(Request $request, $username){
        $support    = $request->has('support') ? 1 : 0;
        $sender     = auth()->user();

        if(!$support){
            $recepient  = User::where('username', $username)->firstOrFail();
            $user       = $sender;

            if($recepient->id == $sender->id){
                if($request->ajax()){
                    return response()->json(['status' => 403, 'message' => 'Sorry, you cant message yourself']);
                }

                session()->flash('error', 'Sorry, you cant message yourself');
                return redirect()->back();
            }

        
            $from_conversation = Conversation::where('from_id', $sender->id)->where('to_id', $recepient->id)->first();
            $to_conversation =   Conversation::where('from_id', $recepient->id)->where('to_id', $sender->id)->first();
            
            if($from_conversation){
                $conversation = $from_conversation;
            }elseif($to_conversation){
                $conversation = $to_conversation;
            }else{
                $conversation = new Conversation;
                $conversation->to_id = $recepient->id;
                $conversation->from_id = $sender->id;
                $conversation->save();
            }

        }else{
            $from_conversation  = Conversation::where('from_id', $sender->id)->where('support', '1')->first();
            $to_conversation    = Conversation::where('to_id', $sender->id)->where('support', '1')->first();
            
            if($from_conversation){
                $conversation = $from_conversation;
            }elseif($to_conversation){
                $conversation = $to_conversation;
            }else{
                $conversation = new Conversation;
                $conversation->to_id = null;
                $conversation->from_id = $sender->id;
                $conversation->support = 1;
                $conversation->save();
            }
        }

        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Message Sent']);
        }

        return redirect()->route('user.conversation', ['id' => $conversation->id]);
    }

    // **************************SEND MESSAGE *****************************************

    public function postMessage(Request $request, $id){
        $this->validate($request, [
            'message' => 'required',
        ]);

        $user               = auth()->user();
        $recepient          = null;

        $conversation = Conversation::findOrFail($id);

        $intended = $conversation->from_id || $conversation->to_id == $user->id ? true : false;

        if(!$intended){
            if($request->ajax()){
                return response()->json(['status' => 403, 'message' => 'Forbidden']);
            }

            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        if(!$conversation->support){
            if($conversation->from_id == $user->id){
                $recepient = $conversation->to;
            }else{
                $recepient = $conversation->from;
            }
        }

        $sender     = $user;
        $user       = $sender;

        if(!$conversation->support && !$recepient){
            $message = 'Recepient not found';

            if($request->ajax()){
                $response = ['status' => 404, 'message' => $message];
                return response()->json($response);
            }
            session()->flash('error', $message);
            return redirect()->back();
        }

        if(!is_null($recepient)){
            if($recepient->id == $sender->id){

                $message = 'Sorry, you cant message yourself';

                if($request->ajax()){
                    $response = ['status' => 403, 'message' => $message];
                    return response()->json($response);
                }

                session()->flash('error', $message);
                
                return redirect()->back();
            }
        }

        $message                    = new Message;
        $message->from_id           = $user->id;
        $message->to_id             = !is_null($recepient) ? $recepient->id : null;
        $message->conversation_id   = $conversation->id;
        $message->message           = ucfirst($request->message);
        $message->support           = $conversation->support;
        $message->save();

        $message_notification                       = new MessageNotification;
        $message_notification->from_id              = $user->id;
        $message_notification->to_id                = !is_null($recepient) ? $recepient->id : null;
        $message_notification->conversation_id      = $conversation->id;
        $message_notification->message_id           = $message->id;
        $message_notification->support              = $conversation->support;
        $message_notification->save();

        $conversation->updated_at = $this->date;
        $conversation->update();

        $message = 'Message sent';

        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);

        return redirect()->back();
    }

    // **************************CONVERSATIONS ****************************************

    public function showConversations(){
        $user = auth()->user();

        $conversations = Conversation::where('from_id', $user->id)->orWhere('to_id', $user->id)->orderBy('updated_at', 'DESC')->get();

        $message_notifications = $user->message_notifications()->where('read', 0)->get();

        if(count($message_notifications)){
            foreach ($message_notifications as $r) {
                $r->read = 1;
                $r->read_at = $this->date;
                $r->update();
            }
        }
        
        return view('pages.user.conversations', [
            'title'         => 'Conversations',
            'nav'           => 'user.account-balance',
            'user'          => $user,
            'conversations' => $conversations,
        ]);
    }

    public function showConversation($id){
        $user   = auth()->user();
        $to     = false;

        $conversation = Conversation::findOrFail($id);

        $intended = $conversation->from_id || $conversation->to_id == $user->id ? true : false;

        if(!$intended){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        $conversations = Conversation::where('from_id', $user->id)->orWhere('to_id', $user->id)->orderBy('updated_at', 'DESC')->get();

        $message_notifications = $conversation->notifications()->where('read', 0)->where('to_id', $user->id)->get();

        if(count($message_notifications)){
            foreach ($message_notifications as $r) {
                $r->read = 1;
                $r->read_at = $this->date;
                $r->update();
            }
        }

        $notifications = $conversation->notifications()->where('read', 0)->where('to_id', $user->id)->get();

        if(count($notifications)){
            foreach ($notifications as $notification) {
                $notification->read = 1;
                $notification->read_at = $this->date;
                $notification->update();
            }
        }

        $messages = $conversation->messages()->orderBy('created_at', 'ASC')->get();

        if($conversation->from_id == $user->id){
            $to = $conversation->to;
        }else{
            $to = $conversation->from;
        }
        
        return view('pages.user.conversation', [
            'title'                 => 'Conversation',
            'nav'                   => 'user.account-balance',
            'user'                  => $user,
            'conversations'         => $conversations,
            'current_conversation'  => $conversation,
            'messages'              => $messages,
            'support_message'       => $conversation->support,
            'to'                    => $to,
        ]);
    }

    // **************************GET CONVERSATION VIA AJAX ****************************

    public function getAjaxConversation($id){
        $user           = auth()->user();
        $conversation   = Conversation::find($id);

        if(!$conversation){
            return response()->json(['status' => 404, 'message' => 'Conversation not found']);
        }

        $intended = $conversation->from_id || $conversation->to_id == $user->id ? true : false;

        if(!$intended){
            return response()->json(['status' => 403, 'message' => 'Forbidden']);
        }

        $messages = $conversation->messages()->where('read', 0)->where('to_id', $user->id)->get();
        $notifications = $conversation->notifications()->where('read', 0)->where('to_id', $user->id)->get();

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
                    if($message->from_id == $user->id){
                        $from = 'Me';
                    }else{
                        $from = $message->sender->name;
                    }
                }
            }
            

            $messages[] = [
                'from'      => $from,
                'mine'      => $message->from_id == $user->id ? '1' : '0',
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

    // **************************NOTIFICATIONS ****************************************

    public function showNotifications(){
        $user = auth()->user();

        $notifications = $user->notifications()->orderBy('created_at', 'DESC')->paginate(20);

        return view('pages.user.notifications', [
            'title'         => 'Notifications',
            'nav'           => 'user.notifications',
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function showNotification($id){
        $notification = Notification::findOrFail($id);
        $user = auth()->user();

        if($notification->to_id != $user->id){
            session()->flash('error', 'Forbidden');
        }

        $notification->read = 1;
        $notification->read_at = $this->date;
        $notification->update();

        return redirect()->back();
    }

    // **************************SAVE DONATED ITEM ************************************

    public function postDonateItem(Request $request){

        $this->validate($request, [
            'name'              => 'required|max:191',
            'type'              => 'required|max:191',
            'condition'         => 'required|max:191',
            'category_id'       => 'required|numeric',
            'description'       => 'required',
        ]);

        if($request->hasFile('images')){
            try{
                $this->validate($request,[
                    'images.*' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
                ]);
            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                
                return redirect()->back();
            }
        }

        $user = auth()->user();

        $donated_item                   = new DonatedItem;
        $donated_item->name             = $request->name;
        $donated_item->slug             = str_slug($request->name . '-' . rand(1,1000000));
        $donated_item->type             = $request->type;
        $donated_item->condition        = $request->condition;
        $donated_item->category_id      = $request->category_id;
        $donated_item->description      = $request->description;
        $donated_item->donor_id         = $user->id;
        $donated_item->price            = config('coins.donated_item.price');
        $donated_item->save();

        if($request->hasFile('images')){
            $images = $request->file('images');

            foreach ($images as $image) {
                if($image->isValid()){
                    try{

                        $name   = time(). rand(1,1000000) . '.' . $image->getClientOriginalExtension();
                        
                        $image_path         = $this->image_path . '/donated_items/images/' . $name;
                        $banner_path        = $this->image_path . '/donated_items/banners/'. $name;
                        $thumbnail_path     = $this->image_path . '/donated_items/thumbnails/' . $name;
                        $slide_path         = $this->image_path . '/donated_items/slides/' . $name;
                    
                        Image::make($image)->orientate()->resize(800,null, function($constraint){
                            return $constraint->aspectRatio();
                        })->save($image_path);

                        Image::make($image)->orientate()->fit(440,586)->save($banner_path);

                        Image::make($image)->orientate()->fit(769,433)->save($slide_path);

                        Image::make($image)->orientate()->resize(440, null, function($constraint){
                            return $constraint->aspectRatio();
                        })->save($thumbnail_path);

                        $donated_item_image                     = new DonatedItemImage;
                        $donated_item_image->image              = $name;
                        $donated_item_image->banner             = $name;
                        $donated_item_image->thumbnail          = $name;
                        $donated_item_image->slide              = $name;
                        $donated_item_image->donated_item_id    = $donated_item->id;
                        $donated_item_image->user_id            = $user->id;
                        $donated_item_image->save();

                    } catch(\Exception $e){
                        $this->log_error($e);

                        session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                    }
                }
            }
        }

        $timeline           = new Timeline;
        $timeline->user_id  = $user->id;
        $timeline->model_id = $donated_item->id;
        $timeline->message  = 'Donated ' . $donated_item->name . ' to the Community';
        $timeline->type     = 'item.donated';
        $timeline->save();

        $activity = $user->activity();
        $activity->donated_items += 1;
        $activity->update();


        session()->flash('success', 'Item donated to the community');

        return redirect()->route('donated-item.show', ['slug' => $donated_item->slug]);
    }

    // **************************PURCHASE DONATED ITEM ********************************

    public function purchaseDonatedItem($slug){
        $donated_item   = DonatedItem::where('slug', $slug)->firstOrFail();
        $user           = auth()->user();

        if($donated_item->donor_id == $user->id){
            session()->flash('error', 'You cannot purchase an item you donated');
            return redirect()->back();
        }

        if($donated_item->bought){
            session()->flash('error', 'Sorry, the item has been bought');
            return redirect()->back();
        }

        if($user->coins < $donated_item->price){
            session()->flash('error', 'You don not have sufficient simba coins to purchase this item');
            return redirect()->back();
        }

        $user->coins -= $donated_item->price;
        $user->update();

        $escrow                     = new Escrow;
        $escrow->user_id            = $user->id;
        $escrow->donated_item_id    = $donated_item->id;
        $escrow->amount             = $donated_item->price;
        $escrow->save();

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $user->id;
        $simba_coin_log->message               = 'Payment for Donated item purchase. (' . $donated_item->name . ')';
        $simba_coin_log->type                  = 'debit';
        $simba_coin_log->coins                 = $donated_item->price;
        $simba_coin_log->previous_balance      = $user->coins + $donated_item->price ;
        $simba_coin_log->current_balance       = $user->coins;
        $simba_coin_log->save();

        $donated_item->bought       = 1;
        $donated_item->bought_at    = $this->date;
        $donated_item->buyer_id     = $user->id;
        $donated_item->escrow_id    = $escrow->id;
        $donated_item->update();

        if($this->settings->mail_enabled->value){
            $title = "Donated Item Purchased - Action needed";

            try{
                \Mail::send('emails.donated-item-purchased-admin', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){
                $this->log_error($e);

                // session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Item bought, the admin will contact you with the details on how to collect your item(s)');

        return redirect()->back();
    }

    // **************************CANCEL PURCHASE **************************************

    public function cancelPurchasedOrder(Request $request, $slug){
        $this->validate($request, [
            'reason' => 'required|max:50000',
        ]);

        $item = DonatedItem::where('slug', $slug)->firstOrFail();
        $user = auth()->user();
        
        if($user->id != $item->buyer_id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $cancel_request = $item->cancel_requests()->where('approved',0)->where('dismissed',0)->first();

        if($cancel_request){
            session()->flash('error', 'Cancel purchase request still pending, please wait for feedback from the admin');

            return redirect()->back();
        }

        if($item->bought && !$item->disapproved && !$item->received){
            $cancel_order                   = new CancelOrder;
            $cancel_order->user_id          = $user->id;
            $cancel_order->donated_item_id  = $item->id;
            $cancel_order->reason           = $request->reason;
            $cancel_order->save();

            $notification                       = new Notification;
            $notification->from_id              = $user->id;
            $notification->to_id                = null;
            $notification->message              = 'Cancel Donated Item Purchase (' . $item->name . ')';
            $notification->notification_type    = 'item.purchase.cancel';
            $notification->model_id             = $item->id;
            $notification->system_message       = 1;
            $notification->save();

            if($this->settings->mail_enabled->value){
                $title = "Request to Cancel Donated Item Purchase - Action needed";

                try{
                    \Mail::send('emails.donated-item-cancelled-admin', ['title' => $title, 'donated_item' => $item, 'cancel_order' => $cancel_order], function ($message) use($title){
                        $message->subject($title);
                        $message->to(config('app.system_email'));
                    });

                }catch(\Exception $e){
                    $this->log_error($e);

                    // session()->flash('error', $e->getMessage());
                }
            }

            session()->flash('success', 'Cancel Request received, please wait for action from admin');

            return redirect()->back();


        }else{
            session()->flash('error', 'You cannot cancel at the moment');
            return redirect()->back();
        }
    }

    // **************************CONFIRM DELIVERY OF DONATED ITEM *********************

    public function confirmDonatedItemDelivery(Request $request, $slug){
        $this->validate($request, [
            'reason' => 'max:50000',
        ]);

        $donated_item = DonatedItem::where('slug',$slug)->firstOrFail();
        $user = auth()->user();

        if($user->id != $donated_item->buyer_id){
            session()->flash('error','403: Forbidden');
            return redirect()->back();
        }

        $donated_item->disapproved          = 0;
        $donated_item->disapproved_at       = null;
        $donated_item->disapproved_by       = null;
        $donated_item->disapproved_reason   = null;

        $donated_item->received             = 1;
        $donated_item->received_at          = $this->date;
        $donated_item->received_message     = $donated_item->name .' Was marked as received by ' . $user->name;

        $donated_item->update();

        $escrow                     = $donated_item->escrow;
        $donor                      = $donated_item->donor;

        if(!$escrow->released){
            $donor->coins               += $escrow->amount;
            $donor->accumulated_coins   += $escrow->amount;
            $donor->update();
        
            $donor->check_social_level();

            $escrow->released       = 1;
            $escrow->released_at    = $this->date;
            $escrow->released_by    = $user->id;
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
            $simba_coin_log->message               = 'Payment for Donated item sold. (' . $donated_item->name .')';
            $simba_coin_log->type                  = 'credit';
            $simba_coin_log->coins                 = $escrow->amount;
            $simba_coin_log->previous_balance      = $donor->coins - $escrow->amount ;
            $simba_coin_log->current_balance       = $donor->coins;
            $simba_coin_log->save();

            $notification                       = new Notification;
            $notification->from_id              = $user->id;
            $notification->to_id                = $donated_item->donor->id;
            $notification->system_message       = 0;
            $notification->message              = 'The Item Purchased by '. $donated_item->buyer->name .' Was marked as received. The funds have been released to your account.';
            $notification->notification_type    = 'donated-item.delivery.approved';
            $notification->model_id             = $donated_item->id;
            $notification->save();

            if($this->settings->mail_enabled->value){
                $title = config('app.name') . ' | '. $donated_item->name ." Marked as Received by the buyer";

                try{
                    \Mail::send('emails.donated-item-received-donor', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                        $message->subject($title);
                        $message->to($donated_item->donor->email);
                    });

                    \Mail::send('emails.donated-item-received-buyer', ['title' => $title, 'donated_item' => $donated_item], function ($message) use($title, $donated_item){
                        $message->subject($title);
                        $message->to($donated_item->buyer->email);
                    });

                }catch(\Exception $e){
                    $this->log_error($e);

                    // session()->flash('error', $e->getMessage());
                }
            }
        }

        session()->flash('success', 'Item Marked as Received');

        return redirect()->back();
    }

    // **************************DONATED ITEMS ********************************************

    public function updateDonatedItem(Request $request, $slug){
        $this->validate($request, [
            'name'              => 'required|max:191',
            'type'              => 'required|max:191',
            'condition'         => 'required|max:191',
            'category_id'       => 'required|numeric',
            'description'       => 'required',
        ]);

        $donated_item       = DonatedItem::where('slug', $slug)->firstOrFail();

        $user               = auth()->user();
        
        if($user->id != $donated_item->donor_id){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        if($donated_item->bought){
            session()->flash('error', 'The Item has already been bought, no more ammendment allowed');
            return redirect()->back();
        }
        
        if($donated_item->name != $request->name){
            $donated_item->slug         = str_slug($request->name . '-' . rand(1,1000000));
        }

        $donated_item->name             = $request->name;
        
        $donated_item->type             = $request->type;
        $donated_item->condition        = $request->condition;
        $donated_item->category_id      = $request->category_id;
        $donated_item->description      = $request->description;
        $donated_item->update();

        session()->flash('success', 'Item Updated');

        return redirect()->route('donated-item.show', ['slug' => $donated_item->slug]);
    }

    public function deleteDonatedItem(Request $request, $slug){
        $this->validate($request, [
            'reason' => 'required|max:800',
        ]);

        $item = DonatedItem::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        if($item->donor_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        if($item->bought){
            session()->flash('error', 'The Item has already been bought, you cannot delete it');
            return redirect()->back();
        }

        if(count($item->images)){
            foreach ($item->images as $image) {
                @unlink($this->image_path . '/donated_items/banners/' . $image->image);
                @unlink($this->image_path . '/donated_items/images/' . $image->image);
                @unlink($this->image_path . '/donated_items/slides/' . $image->image);
                @unlink($this->image_path . '/donated_items/thumbnails/' . $image->image);
            }
        }

        $timeline = $user->timeline()->where('type', 'item.donated')->where('model_id', $item->id)->first();

        if($timeline){
            $timeline->delete();
        }

        $item->deleted_by = $user->id;
        $item->deleted_reason = $request->reason;
        $item->update();

        $timeline = Timeline::where('model_id', $item->id)->where('type', 'item.donated')->where('user_id', $user->id)->first();

        if($timeline){
            $timeline->delete();
        }

        $activity                   = $user->activity($item->created_at->year);
        $activity->donated_items    -= 1;
        $activity->update();

        $item->delete();

        session()->flash('success', 'Donated item removed from community shop');

        return redirect()->route('community-shop');
    }

    public function addDonatedItemImage(Request $request, $slug){
        $donated_item = DonatedItem::where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        if($donated_item->donor_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        try{
            $this->validate($request,[
                'images.*' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
            ]);
        }catch(\Exception $e){
            $this->log_error($e);

            session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
            
            return redirect()->back();
        }

        if($request->hasFile('images')){
            $images = $request->file('images');

            foreach ($images as $image) {
                if($image->isValid()){
                    try{

                        $name   = time(). rand(1,1000000) . '.' . $image->getClientOriginalExtension();
                        
                        $image_path         = $this->image_path . '/donated_items/images/' . $name;
                        $banner_path        = $this->image_path . '/donated_items/banners/'. $name;
                        $thumbnail_path     = $this->image_path . '/donated_items/thumbnails/' . $name;
                        $slide_path         = $this->image_path . '/donated_items/slides/' . $name;
                    
                        Image::make($image)->orientate()->resize(800,null, function($constraint){
                            return $constraint->aspectRatio();
                        })->save($image_path);

                        Image::make($image)->orientate()->fit(440,586)->save($banner_path);

                        Image::make($image)->orientate()->fit(769,433)->save($slide_path);

                        Image::make($image)->orientate()->resize(200,null, function($constraint){
                            return $constraint->aspectRatio();
                        })->save($thumbnail_path);

                        $donated_item_image                     = new DonatedItemImage;
                        $donated_item_image->image              = $name;
                        $donated_item_image->banner             = $name;
                        $donated_item_image->thumbnail          = $name;
                        $donated_item_image->slide              = $name;
                        $donated_item_image->donated_item_id    = $donated_item->id;
                        $donated_item_image->user_id            = $user->id;
                        $donated_item_image->save();

                    } catch(\Exception $e){
                        $this->log_error($e);

                        session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                    }
                }
            }
        }

        else{
            session()->flash('error', 'Upload failed');
        }

        return redirect()->back();
    }

    public function deleteDonatedItemImage($slug,$id){
        $image = DonatedItemImage::findOrFail($id);

        $donated_item = $image->donated_item;

        if(!$donated_item){
            abort(404);
        }

        $user = auth()->user();

        if($image->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        if($donated_item->bought){
            session()->flash('error', 'The Item has already been bought, you can no longer delete images from it');
            return redirect()->back();
        }        

        @unlink($this->image_path . '/donated_items/banners/' . $image->image);
        @unlink($this->image_path . '/donated_items/images/' . $image->image);
        @unlink($this->image_path . '/donated_items/slides/' . $image->image);
        @unlink($this->image_path . '/donated_items/thumbnails/' . $image->image);

        $image->delete();

        session()->flash('success', 'Image Deleted');

        return redirect()->back();
    }

    // **************************SAVE GOOD DEED ***************************************

    public function postGoodDeed(Request $request){

        $this->validate($request, [
            'name'          => 'required|max:191',
            'location'      => 'required|max:191',
            'description'   => 'required|max:800',
            'contacts'      => 'max:800',
            
        ]);

        if($request->hasFile('images')){
            try{
                $this->validate($request,[
                    'images.*' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
                ]);
            }catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                
                return redirect()->back();
            }
        }

        $user = auth()->user();
        
        $good_deed                  = new GoodDeed;
        $good_deed->name            = $request->name;
        $good_deed->slug            = str_slug($request->name . '-' . rand(1,1000000));
        $good_deed->location        = $request->location;
        $good_deed->performed_at    = $request->performed_at;
        $good_deed->description     = $request->description;
        $good_deed->contacts        = $request->contacts;
        $good_deed->user_id         = $user->id;
        
        $good_deed->save();

        if($request->hasFile('images')){
            $images = $request->file('images');

            foreach ($images as $image) {
                if($image->isValid()){
                    try{

                        $name   = time(). rand(1,1000000) . '.' . $image->getClientOriginalExtension();
                        
                        $image_path         = $this->image_path . '/good_deeds/images/' . $name;
                        $thumbnail_path     = $this->image_path . '/good_deeds/thumbnails/' . $name;
                        
                        Image::make($image)->orientate()->resize(1024,null, function($constraint){
                            return $constraint->aspectRatio();
                        })->save($image_path); 

                        Image::make($image)->orientate()->fit(400,260)->save($thumbnail_path); 

                        $good_deed_image                = new GoodDeedImage;
                        $good_deed_image->image         = $name;
                        $good_deed_image->good_deed_id  = $good_deed->id;
                        $good_deed_image->user_id       = $user->id;
                        
                        $good_deed_image->save();

                    } catch(\Exception $e){
                        $this->log_error($e);

                        session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                    }
                }
            }
        }

        if($this->settings->mail_enabled->value){
            $title = 'Good Deed Reported |' . $good_deed->name;

            try{
                \Mail::send('emails.good-deed-reported-admin', ['title' => $title, 'good_deed' => $good_deed], function ($message) use($title, $good_deed){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){
                $this->log_error($e);

                // session()->flash('error', $e->getMessage());
            }
        }


        session()->flash('success', 'Good deed reported, please wait for approval by the admin');

        return redirect()->route('good-deed.show', ['slug' => $good_deed->slug]);
    }

    // **************************ABOUT ME ********************************************

    public function updateAboutMe(Request $request){
        $this->validate($request, [
            'about_me' => 'required',
        ]);

        if(str_word_count($request->about_me) < 200){
            session()->flash('error', 'Sorry, you need a minimum of 200 words for your bio');

            return redirect()->back()->withInput();
        }

        $user               = auth()->user();
        $user->about_me     = $request->about_me;
        $user->update();

        $user->check_profile_completion();

        session()->flash('success', 'Details updated');

        if(!$user->profile->about_me){
            $user->profile->about_me = 1;
            $user->profile->update();
        }

        return redirect()->back();
    }
    
    // **************************Quotes I Love ******************************************

    public function addQuotesILove(Request $request){
        
        $this->validate($request, [
            'content'  => 'max:50000|required',
        ]);

        $user = auth()->user();

        $quotes_i_love              = new QuotesILove;
        $quotes_i_love->content     = $request->content;
        $quotes_i_love->user_id     = $user->id;
        $quotes_i_love->save();

        $message = 'Quotes Added';

        if(!$user->profile->quotes_i_love){
            $user->profile->quotes_i_love = 1;
            $user->profile->update();
        }

        $user->check_profile_completion();
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateQuotesILove(Request $request, $id){
        $quotes_i_love = QuotesILove::findOrFail($id);

        $user = auth()->user();

        if($quotes_i_love->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'content'  => 'required|max:50000',
        ]);

        $quotes_i_love->content     = $request->content;
        $quotes_i_love->update();

        session()->flash('success', 'Quotes Updated');

        return redirect()->back();
    }

    public function deleteQuotesILove(Request $request, $id){
        $quotes_i_love = QuotesILove::findOrFail($id);

        $user = auth()->user();

        if($quotes_i_love->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $quotes_i_love->delete();

        if(!count($user->quotes_i_love)){
            $user->profile->quotes_i_love = 0;
            $user->profile->update();
        }

        session()->flash('success', 'Quotes Deleted');

        return redirect()->back();
    }

    // **************************My Interests ******************************************

    public function addMyInterests(Request $request){
        
        $this->validate($request, [
            'content'  => 'max:50000|required',
        ]);

        $user = auth()->user();

        $my_interests              = new MyInterest;
        $my_interests->content     = $request->content;
        $my_interests->user_id     = $user->id;
        $my_interests->save();

        $message = 'Interests Added';

        if(!$user->profile->my_interests){
            $user->profile->my_interests = 1;
            $user->profile->update();
        }

        $user->check_profile_completion();
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateMyInterests(Request $request, $id){
        $my_interests = MyInterest::findOrFail($id);

        $user = auth()->user();

        if($my_interests->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'content'  => 'required|max:50000',
        ]);

        $my_interests->content     = $request->content;
        $my_interests->update();

        session()->flash('success', 'Interests Updated');

        return redirect()->back();
    }

    public function deleteMyInterests(Request $request, $id){
        $my_interests = MyInterest::findOrFail($id);

        $user = auth()->user();

        if($my_interests->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $my_interests->delete();

        if(!count($user->interests)){
            $user->profile->my_interests = 0;
            $user->profile->update();
        }

        session()->flash('success', 'Interests Deleted');

        return redirect()->back();
    }

    // **************************Books You Should Read ******************************************

    public function addBooksYouShouldRead(Request $request){
        
        $this->validate($request, [
            'content'  => 'max:50000|required',
        ]);

        $user = auth()->user();

        $books_you_should_read              = new BooksYouShouldRead;
        $books_you_should_read->content     = $request->content;
        $books_you_should_read->user_id     = $user->id;
        $books_you_should_read->save();

        $message = 'Books Added';

        if(!$user->profile->books_you_should_read){
            $user->profile->books_you_should_read = 1;
            $user->profile->update();
        }

        $user->check_profile_completion();
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateBooksYouShouldRead(Request $request, $id){
        $books_you_should_read = BooksYouShouldRead::findOrFail($id);

        $user = auth()->user();

        if($books_you_should_read->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'content'  => 'required|max:50000',
        ]);

        $books_you_should_read->content     = $request->content;
        $books_you_should_read->update();

        session()->flash('success', 'Books Updated');

        return redirect()->back();
    }

    public function deleteBooksYouShouldRead(Request $request, $id){
        $books_you_should_read = BooksYouShouldRead::findOrFail($id);

        $user = auth()->user();

        if($books_you_should_read->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $books_you_should_read->delete();

        if(!count($user->books_you_should_read)){
            $user->profile->books_you_should_read = 0;
            $user->profile->update();
        }

        session()->flash('success', 'Books Deleted');

        return redirect()->back();
    }

    // **************************World I Desire ******************************************

    public function addWorldIDesire(Request $request){
        
        $this->validate($request, [
            'content'  => 'max:50000|required',
        ]);

        $user = auth()->user();

        $world_i_desire              = new WorldIDesire;
        $world_i_desire->content     = $request->content;
        $world_i_desire->user_id     = $user->id;
        $world_i_desire->save();

        $message = 'Message Added';

        if(!$user->profile->world_i_desire){
            $user->profile->world_i_desire = 1;
            $user->profile->update();
        }

        $user->check_profile_completion();
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateWorldIDesire(Request $request, $id){
        $world_i_desire = WorldIDesire::findOrFail($id);

        $user = auth()->user();

        if($world_i_desire->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'content'  => 'required|max:50000',
        ]);

        $world_i_desire->content     = $request->content;
        $world_i_desire->update();

        session()->flash('success', 'Message Updated');

        return redirect()->back();
    }

    public function deleteWorldIDesire(Request $request, $id){
        $world_i_desire = WorldIDesire::findOrFail($id);

        $user = auth()->user();

        if($world_i_desire->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $world_i_desire->delete();

        session()->flash('success', 'Message Deleted');

        if(!count($user->world_i_desire)){
            $user->profile->world_i_desire = 0;
            $user->profile->update();
        }

        return redirect()->back();
    }


     // **************************HOBBIES *********************************************

    public function addHobby(Request $request){
        
        $this->validate($request, [
            'content'  => 'max:50000|required',
        ]);

        $user = auth()->user();

        $hobby          = new Hobby;
        $hobby->content = $request->content;
        $hobby->user_id = $user->id;
        $hobby->save();

        $message = 'Hobby Added';

        if(!$user->profile->hobbies){
            $user->profile->hobbies = 1;
            $user->profile->update();
        }

        $user->check_profile_completion();
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateHobby(Request $request, $id){
        $hobby = Hobby::findOrFail($id);

        $user = auth()->user();

        if($hobby->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'content'  => 'required|max:50000',
        ]);

        $hobby->content = $request->content;
        $hobby->update();

        session()->flash('success', 'Hobby Updated');

        return redirect()->back();
    }

    public function deleteHobby(Request $request, $id){
        $hobby = Hobby::findOrFail($id);

        $user = auth()->user();

        if($hobby->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $hobby->delete();

        if(!count($user->hobbies)){
            $user->profile->hobbies = 0;
            $user->profile->update();
        }

        session()->flash('success', 'Hobby Deleted');

        return redirect()->back();
    }


    // **************************MEMBERSHIPS ******************************************

    public function addMembership(Request $request){
        
        $this->validate($request, [
            'name'  => 'max:191|required',
        ]);

        $user = auth()->user();

        $membership = new Membership;
        $membership->name = $request->name;
        $membership->user_id = $user->id;
        $membership->save();

        $message = 'Membership Added';

        if(!$user->profile->memberships){
            $user->profile->memberships = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateMembership(Request $request, $id){
        $membership = Membership::findOrFail($id);

        $user = auth()->user();

        if($membership->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:191',
        ]);

        $membership->name = $request->name;
        $membership->update();

        session()->flash('success', 'Membership Updated');

        return redirect()->back();
    }

    public function deleteMembership(Request $request, $id){
        $membership = Membership::findOrFail($id);

        $user = auth()->user();

        if($membership->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $membership->delete();

        session()->flash('success', 'Membership Deleted');

        return redirect()->back();
    }

    // **************************AWARDS **********************************************

    public function addAward(Request $request){
        
        $this->validate($request, [
            'name'  => 'max:191|required',
            'year'  => 'min:1900|max:' . date('Y') . '|required|numeric',
        ]);

        $user = auth()->user();

        $award = new Award;
        $award->name = $request->name;
        $award->year = $request->year;
        $award->user_id = $user->id;
        $award->save();

        $message = 'Award Added';

        if(!$user->profile->awards){
            $user->profile->awards = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateAward(Request $request, $id){
        $award = Award::findOrFail($id);

        $user = auth()->user();

        if($award->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:191',
            'year'  => 'required|numeric|min:1900|max:' . date('Y'),
        ]);

        $award->name = $request->name;
        $award->year = $request->year;
        $award->update();

        session()->flash('success', 'Award Updated');

        return redirect()->back();
    }

    public function deleteAward(Request $request, $id){
        $award = Award::findOrFail($id);

        $user = auth()->user();

        if($award->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $award->delete();

        session()->flash('success', 'Award Deleted');

        return redirect()->back();
    }

    // **************************ACHIEVEMENTS *********************************************

    public function addAchievement(Request $request){
        
        $this->validate($request, [
            'name'  => 'max:191|required',
        ]);

        $user = auth()->user();

        $achievement = new Achievement;
        $achievement->name = $request->name;
        $achievement->user_id = $user->id;
        $achievement->save();

        $message = 'Achievement Added';

        if(!$user->profile->achievements){
            $user->profile->achievements = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateAchievement(Request $request, $id){
        $achievement = Achievement::findOrFail($id);

        $user = auth()->user();

        if($achievement->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:191',
        ]);

        $achievement->name = $request->name;
        $achievement->update();

        session()->flash('success', 'Achievement Updated');

        return redirect()->back();
    }

    public function deleteAchievement(Request $request, $id){
        $achievement = Achievement::findOrFail($id);

        $user = auth()->user();

        if($achievement->user_id != $user->id){
            session()->flash('error', 'Forbidden');

            return redirect()->back();
        }

        $achievement->delete();

        session()->flash('success', 'Achievement Deleted');

        return redirect()->back();
    }

    // **************************WORK EXPERIENCE *************************************

    public function addWorkExperience(Request $request){
        $this->validate($request,[
            'from'              => 'required|max:191',
            'to'                => 'required|max:191',
            'company'           => 'required|max:191',
            'position'          => 'required|max:191',
        ]);

        $user = auth()->user();

        $work_experience = new WorkExperience;

        $work_experience->from_date      = $request->from;
        $work_experience->to_date        = $request->to;
        $work_experience->company   = $request->company;
        $work_experience->position  = $request->position;
        $work_experience->user_id   = $user->id;

        $work_experience->save();

        $message = "Work Experience added";

        if(!$user->profile->work_experience){
            $user->profile->work_experience = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateWorkExperience(Request $request, $id){
        $this->validate($request,[
            'from'              => 'required|max:191',
            'to'                => 'required|max:191',
            'company'           => 'required|max:191',
            'position'          => 'required|max:191',
        ]);

        $work_experience = WorkExperience::findOrFail($id);

        if($work_experience->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $work_experience->from_date      = $request->from;
        $work_experience->to_date        = $request->to;
        $work_experience->company   = $request->company;
        $work_experience->position  = $request->position;

        $work_experience->update();

        $message = "Work Experience Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function deleteWorkExperience(Request $request, $id){
    
        $work_experience = WorkExperience::findOrFail($id);

        if($work_experience->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $work_experience->delete();

        $message = "Work Experience Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    // **************************SKILLS **********************************************

    public function addSkill(Request $request){
        $this->validate($request,[
            'skill' => 'required|max:191',
        ]);

        $user = auth()->user();

        $skill = new Skill;

        $skill->skill   = $request->skill;
        $skill->user_id = $user->id;

        $skill->save();

        $message = "Skill added";

        if(!$user->profile->skills){
            $user->profile->skills = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateSkill(Request $request, $id){
        $this->validate($request,[
            'skill' => 'required|max:191',
        ]);

        $skill = Skill::findOrFail($id);

        if($skill->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $skill->skill = $request->skill;

        $skill->update();

        $message = "Skill Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function deleteSkill(Request $request, $id){
    
        $skill = Skill::findOrFail($id);

        if($skill->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $skill->delete();

        $message = "Skill Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    // **************************EDUCATION *******************************************

    public function addEducation(Request $request){
        $this->validate($request,[
            'school'            => 'required|max:191',
            'level'             => 'required|max:191',
            'field_of_study'    => 'required|max:191',
            'grade'             => 'max:191',
            'start_year'        => 'required|max:191',
            'end_year'          => 'required|max:191',
        ]);

        $user = auth()->user();

        $education = new Education;

        $education->school = $request->school;
        $education->level = $request->level;
        $education->field_of_study = $request->field_of_study;
        $education->grade = $request->grade;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->user_id = auth()->user()->id;

        $education->save();

        $message = "Education added";

        if(!$user->profile->education){
            $user->profile->education = 1;
            $user->profile->update();
        }
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function updateEducation(Request $request, $id){
        $this->validate($request,[
            'school'            => 'required|max:191',
            'level'             => 'required|max:191',
            'field_of_study'    => 'required|max:191',
            'grade'             => 'max:191',
            'start_year'        => 'required|max:191',
            'end_year'          => 'required|max:191',
        ]);

        $education = Education::findOrFail($id);

        if($education->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $education->school = $request->school;
        $education->level = $request->level;
        $education->field_of_study = $request->field_of_study;
        $education->grade = $request->grade;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->user_id = auth()->user()->id;

        $education->update();

        $message = "Education Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    public function deleteEducation(Request $request, $id){
    
        $education = Education::findOrFail($id);

        if($education->user_id != auth()->user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            session()->flash('error', $message);
            return redirect()->back();
        }

        $education->delete();

        $message = "Education Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        session()->flash('success', $message);
        return redirect()->back();
    }

    // **************************PURCHASE COINS *******************************************

    public function postPurchaseCoins(Request $request){
        $user = auth()->user();

        $this->validate($request, [
            'coins'             => 'required|numeric|min:1|max:' . config('coins.limit.purchase_coins'),
            'amount_paid'       => 'required|numeric',
            'transaction_code'  => 'required|max:191',
        ]);

        $coin_purchase_history                      = new CoinPurchaseHistory;
        $coin_purchase_history->coins               = $request->coins;
        $coin_purchase_history->amount_paid         = $request->amount_paid;
        $coin_purchase_history->transaction_code    = $request->transaction_code;
        $coin_purchase_history->user_id             = $user->id;
        $coin_purchase_history->save();

        session()->flash('success', 'Coin Purchase Requested');

        return redirect()->back();
    }

    
    // **************************REPORT USER **********************************************

    public function postReport(Request $request){
        $this->validate($request, [
            'section'       => 'required|max:191',
            'report_type'   => 'required|max:191',
            'model_id'      => 'required|numeric',
            'user_id'       => 'required|numeric',
            'description'   => 'required|max:800',
        ]);

        $report_type = ReportType::where('type', $request->report_type)->first();
        
        $user        = User::findOrFail($request->user_id);

        if(!$report_type){
            session()->flash('error', 'Invalid Option Selected');
            return redirect()->back();
        }

        $user_report = new UserReport;
        $user_report->report_type_id    = $report_type->id;
        $user_report->section           = $request->section;
        $user_report->model_id          = $request->model_id;
        $user_report->user_id           = $user->id;
        $user_report->description       = $request->description;
        $user_report->reported_by       = auth()->user()->id;
        $user_report->save();

        $notification                       = new Notification;
        $notification->from_id              = auth()->user()->id;
        $notification->to_id                = null;
        $notification->message              = 'User/Item Reported';
        $notification->notification_type    = 'user.reported';
        $notification->model_id             = $user_report->id;
        $notification->system_message       = 1;
        $notification->save();


        if($this->settings->mail_enabled->value){
            $title = "User\Item Reported by Member - Action needed";

            try{
                \Mail::send('emails.report-user-admin', ['title' => $title, 'user_report' => $user_report], function ($message) use($title){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){
                $this->log_error($e);
                
                // session()->flash('error', $e->getMessage());
            }
        }


        session()->flash('success', 'Report received, the admin will review and take the appropriate actions');

        return redirect()->back();
    }

    // **************************POSTS ****************************************************

    public function postNewPost(Request $request){
        $this->validate($request, [
            'title'     => 'max:191|required',
            'content'   => 'max:50000|required',
        ]);

        $user = auth()->user();

        $post           = new Post;
        $post->title    = $request->title;
        $post->slug     = str_slug($request->title) . '-' . rand(1, 10000);
        $post->content  = $request->content;
        $post->user_id  = $user->id;
        $post->save();

        $activity           = $user->activity();
        $activity->posts    += 1;
        $activity->update();

        session()->flash('success', 'Post Created');

        return redirect()->back();
    }

    public function updatePost(Request $request, $slug){
        $this->validate($request, [
            'title' => 'required|max:191',
            'content' => 'required|max:50000',
        ]);

        $user = auth()->user();

        $post = Post::where('slug', $slug)->firstOrFail();

        if($user->id != $post->user_id){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        $post->title = $request->title;
        $post->slug = str_slug($request->title) . '-' . rand(1,10000);
        $post->content = $request->content;
        $post->update();

        session()->flash('success', 'Post Updated');

        return redirect()->route('post', ['slug' => $post->slug]);
    }

    public function deletePost(Request $request, $slug){
        $user = auth()->user();

        $post = Post::where('slug', $slug)->firstOrFail();

        if($user->id != $post->user_id){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        $comments = $post->comments;

        if(count($comments)){
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        $activity           = $user->activity($post->created_at->year);
        $activity->posts   -= 1;
        $activity->update();

        $post->delete();

        session()->flash('success', 'Post Deleted');

        return redirect()->route('posts');
    }    

    // **************************POST COMMENTS ********************************************

    public function postComment(Request $request, $slug){
        $this->validate($request, [
            'content'   => 'max:5000|required',
        ]);

        $post = Post::where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        $comment           = new Comment;
        $comment->content  = $request->content;
        $comment->post_id  = $post->id;
        $comment->user_id  = $user->id;
        $comment->save();

        if($post->user_id != $user->id){
            $notification                       = new Notification;
            $notification->from_id              = $user->id;
            $notification->to_id                = $post->user_id;
            $notification->message              = $user->name . ' Commented on your post ' . $post->title;
            $notification->notification_type    = 'post.commented';
            $notification->model_id             = $post->id;
            $notification->system_message       = 0;
            $notification->save();
        }

        $activity            = $user->activity();
        $activity->comments += 1;
        $activity->update();

        session()->flash('success', 'Comment Added');

        return redirect()->back();
    }

    public function updateComment(Request $request, $slug, $id){
        $this->validate($request, [
            'content' => 'required|max:5000',
        ]);

        $user = auth()->user();

        $comment = Comment::findOrFail($id);

        if($user->id != $comment->user_id){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        $comment->content = $request->content;
        $comment->update();

        session()->flash('success', 'Comment Update');

        return redirect()->back();
    }

    public function deleteComment(Request $request, $slug, $id){
        $user = auth()->user();

        $comment = Comment::findOrFail($id);

        if($user->id != $comment->user_id){
            session()->flash('error', 'Forbidden');
            return redirect()->back();
        }

        $activity               = $user->activity($comment->created_at->year);
        $activity->comments    -= 1;
        $activity->update();

        $comment->delete();

        session()->flash('success', 'Comment Deleted');

        return redirect()->back();
    }

    // **************************REVIEW DONATED ITEM **************************************

    public function reviewDonatedItem(Request $request, $slug){
        $item = DonatedItem::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        $reviews        = $item->reviews()->orderBy('created_at', 'DESC')->get();
        $review         = $item->reviews()->orderBy('created_at', 'DESC')->first();

        if($item->buyer_id == $user->id && $item->bought && $item->received && $item->approved){
            if(!$review){
                $this->validate($request, [
                    'rating'    => 'numeric|min:1|max:5',
                    'message'   => 'required|max:50000',
                ]);

                $review                     = new DonatedItemReview;
                $review->rating             = $request->rating;
                $review->message            = $request->message;
                $review->user_id            = $user->id;
                $review->donated_item_id    = $item->id;
                $review->save();

                $coins                       = config('coins.earn.reviewing_item');
                $user->coins                += $coins;
                $user->accumulated_coins    += $coins;
                $user->update();

                $simba_coin_log                        = new SimbaCoinLog;
                $simba_coin_log->user_id               = $user->id;
                $simba_coin_log->message               = 'Reviewed Donated item. (' . $item->name . ')';
                $simba_coin_log->type                  = 'credit';
                $simba_coin_log->coins                 = $coins;
                $simba_coin_log->previous_balance      = $user->coins - $coins ;
                $simba_coin_log->current_balance       = $user->coins;
                $simba_coin_log->save();

                $notification                       = new Notification;
                $notification->from_id              = $user->id;
                $notification->to_id                = $item->donor->id;
                $notification->message              = $user->name . ' Reviewed your donated item. (' . $item->name . ')';
                $notification->notification_type    = 'item.reviewed';
                $notification->model_id             = $item->id;
                $notification->save();

                $activity                = $user->activity();
                $activity->item_reviews += 1;
                $activity->update();

                if($this->settings->mail_enabled->value){
                    $title = config('app.name') . " | Your donated item " . $item->name . "  has been reviewed";

                    try{
                        \Mail::send('emails.review-donated-item', ['title' => $title, 'review' => $review, 'item' => $item], function ($message) use($title, $review, $item){
                            $message->subject($title);
                            $message->to($item->donor->email);
                        });

                    }catch(\Exception $e){

                        $this->log_error($e);
                        
                        // session()->flash('error', $e->getMessage());
                    }
                }

                session()->flash('success', 'Item Reviewed');
            }else{
                return $this->updateDonatedItemReview($request, $review->id);
            }
        }else{
            session()->flash('error', 'Forbidden');
        }

        return redirect()->back();
    }

    public function updateDonatedItemReview(Request $request, $id){
        $this->validate($request, [
            'rating'    => 'numeric|min:1|max:5',
            'message'   => 'required|max:50000',
        ]);

        $review = DonatedItemReview::findOrFail($id);
        $user = auth()->user();

        if($user->id != $review->user_id){
            session()->flash('error','Forbidden');
            return redirect()->back();
        }

        $review->message    = $request->message;
        $review->rating     = $request->rating;
        $review->update();

        session()->flash('success','Review Updated');
        return redirect()->back();
    }

    // **************************REVIEW USER ******************************************

    public function postUserReview(Request $request, $username){
        $this->validate($request,[
            'rating'    => 'required|numeric|min:1|max:5',
            'message'   => 'required|max:50000',
        ]);

        $user = User::where('username', $username)->firstOrFail();
        
        $auth = auth()->user();

        if($user->id == $auth->id){
            session()->flash('error', 'You Cannot rate yourself');
            return redirect()->back();
        }

        $reviewed = $user->reviews()->where('rater_id', $auth->id)->first();

        if($reviewed){
            session()->flash('error', 'You have already reviewed this user');
            return redirect()->back();
        }

        $review             = new UserReview;
        $review->user_id    = $user->id;
        $review->rater_id   = $auth->id;
        $review->rating     = $request->rating;
        $review->message    = $request->message;
        $review->save();

        $user->rating       += $request->rating;
        $user->reviews      += 1;
        $user->update();

        $previous_balance   = $auth->coins;

        $auth->coins                += config('coins.earn.rating_member');
        $auth->accumulated_coins    += config('coins.earn.rating_member');
        $auth->update();

        $this->settings->available_balance->value       += config('coins.earn.rating_member');
        $this->settings->available_balance->update();

        $this->settings->coins_in_circulation->value    += config('coins.earn.rating_member');
        $this->settings->coins_in_circulation->update();

        $simba_coin_log                        = new SimbaCoinLog;
        $simba_coin_log->user_id               = $auth->id;
        $simba_coin_log->message               = 'Simba Coins earned for reviewing ' . $user->name;
        $simba_coin_log->type                  = 'credit';
        $simba_coin_log->coins                 = config('coins.earn.rating_member');;
        $simba_coin_log->previous_balance      = $previous_balance;
        $simba_coin_log->current_balance      += $auth->coins;
        $simba_coin_log->save();

        $notification                       = new Notification;
        $notification->from_id              = $auth->id;
        $notification->to_id                = $user->id;
        $notification->message              = $auth->name . ' Reviewed your profile.';
        $notification->notification_type    = 'user.reviewed';
        $notification->model_id             = $user->id;
        $notification->save();

        $activity                = $auth->activity();
        $activity->user_reviews += 1;
        $activity->update();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . " | Your profile was reviewed";

            try{
                \Mail::send('emails.review-user', ['title' => $title, 'review' => $review], function ($message) use($title, $review){
                    $message->subject($title);
                    $message->to($review->user->email);
                });

            }catch(\Exception $e){

                $this->log_error($e);
                
                // session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'User reviewed');

        return redirect()->back();
    }

    public function updateUserReview(Request $request, $id){
        $this->validate($request, [
            'rating'    => 'numeric|min:1|max:5',
            'message'   => 'required|max:50000',
        ]);

        $review = UserReview::findOrFail($id);
        $user = auth()->user();

        if($user->id != $review->rater_id){
            session()->flash('error','Forbidden');
            return redirect()->back();
        }

        $review->message    = $request->message;
        $review->rating     = $request->rating;
        $review->update();

        session()->flash('success','Review Updated');
        return redirect()->back();
    }

    // ****************************************REQUEST TO BE A MODERATOR *******************

    public function requestToBeModerator(){
        $user = auth()->user();

        if(!$user->can_be_moderator()){
            session()->flash('error', 'You need to be Hodari Social Level or higher in order to be eligible to be a moderator. You are currently ' . ucfirst(strtolower($user->social_level)) . ' Social Level.' );

            return redirect()->back();
        }

        if($user->has_pending_moderator_request()){
            session()->flash('error', 'You have already sent a request to become a moderator. Please wait for action from the admin team' );

            return redirect()->back();
        }

        $moderator_request          = new ModeratorRequest;
        $moderator_request->user_id = $user->id;
        $moderator_request->save();

        if($this->settings->mail_enabled->value){
            $title = config('app.name') . " | " . $user->name . ' is requesting to be a moderator';

            try{
                \Mail::send('emails.moderator-request-admin', ['title' => $title, 'user' => $user], function ($message) use($title){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){

                $this->log_error($e);
                
                // session()->flash('error', $e->getMessage());
            }
        }

        session()->flash('success', 'Request Sent, Please wait for feedback from the admin team');

        return redirect()->back();
    }
}
