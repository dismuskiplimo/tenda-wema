<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{DonatedItem, User, Category, GoodDeed, Country, Donation, ContactUs, Post, Comment, ErrorLog};

use Mail;

class FrontController extends Controller
{
    public function __construct(){
        $this->middleware('check_coins');
        $this->initialize();
    }

    public function showHomePage(){
    	return view('pages.user.homepage',[
    		'title' 	=> 'Home',
    		'nav' 		=> 'home',
    	]);
    }

    public function showDonateItemPage(){
    	$categories = Category::orderBy('name', 'ASC')->get();

        return view('pages.user.donate-item',[
    		'title' 	    => 'Donate Item',
    		'nav' 		    => 'donate-item',
            'categories'    => $categories,
    	]);
    }

    public function showEmailNotVerified(){
        if(!auth()->check()){
            return redirect()->route('auth.login');
        }

        else{
            $user = auth()->user();

            if(!$user->is_email_verified()){
                return view('pages.user.email-not-verified',[
                    'title'         => 'Email not verified',
                    'nav'           => 'email-not-verified',
                    'user'          => $user,
                ]);
            }else{
                return redirect()->route('user.dashboard');
            }
        }
    }

    public function showReportGoodDeedPage(){
    	return view('pages.user.report-good-deed',[
    		'title' 	=> 'Report a Good Deed',
    		'nav' 		=> 'report-goog-deed',
    	]);
    }

    public function showRegisteredMembersPage(Request $request){
        $users = User::where('usertype', 'USER')->orderBy('name', 'ASC')->paginate(40);

        return view('pages.user.registered-users',[
            'title'     => 'Registered Members',
            'nav'       => 'registered-users',
            'users'     => $users,
        ]);
    }

    public function showPostsPage(){
        $posts = Post::orderBy('created_at', 'DESC')->paginate(20);

        return view('pages.user.posts',[
            'title'     => 'Posts',
            'nav'       => 'posts',
            'posts'     => $posts,
        ]);
    }

    public function showPostPage($slug){
        $post = Post::where('slug', $slug)->firstOrFail();

        $mine = false;

        if(auth()->check()){
            if(auth()->user()->id == $post->user_id){
                $mine = true;
            }
        }

        $comments = $post->comments()->orderBy('created_at', 'ASC')->get();

        return view('pages.user.post',[
            'title'     => $post->title,
            'nav'       => 'post',
            'post'      => $post,
            'comments'  => $comments,
            'mine'      => $mine,
        ]);
    }

    public function showTermsAndConditions(){
        return view('pages.user.terms-and-conditions',[
            'title'     => 'Terms and Conditions',
            'nav'       => 'terms-and-conditions',
        ]);
    }

    public function showSearchPage(Request $request){
        $donated_items  = null;
        $users          = null;
        $empty          = true;
        $total          = 0;

        if($request->has('q') && !empty($request->q)){
            $empty = false;

            $where_like = '%' . $request->q . '%';

            $users = User::where('usertype', 'USER')->where('is_admin', 0)->where('closed', 0)->where('name', 'like', $where_like)->orderBy('name', 'ASC')->paginate(50);
            
            $donated_items = DonatedItem::where('name', 'like', $where_like)->where('disputed', 0)->where('disapproved', 0)->orderBy('name', 'ASC')->paginate(50);

            $total = $users->total() + $donated_items->total();

        }

        return view('pages.user.search',[
            'title'         => 'Search',
            'nav'           => 'search',
            'users'         => $users,
            'donated_items' => $donated_items,
            'empty'         => $empty,
            'request'       => $request,
            'total'         => $total,
        ]);
    }

    public function showSupportCause(){
        $countries = Country::orderBy('name','ASC')->get();

        return view('pages.user.support-the-cause',[
            'title'     => 'Support The Cause',
            'nav'       => 'support-the-cause',
            'countries' => $countries,
        ]);
    }

    public function postSupportCause(Request $request){
        $this->validate($request,[
            'fname'         => 'required|max:191',
            'lname'         => 'required|max:191',
            'country'       => 'required|max:191',
            'organization'  => 'max:191',
            'phone'         => 'required|max:191',
            'email'         => 'required|max:191|email',
            'donating_as'   => 'required|max:191',
            'method'        => 'required|max:191',
        ]);

        if($request->has('amount') && !empty($request->amount)){
            $this->validate($request, [
                'amount'        => 'numeric|min:1000',
            ]);
        }else{
            $request->amount = 0;
        }

        $donation                   = new Donation;
        $donation->fname            = $request->fname;
        $donation->lname            = $request->lname;
        $donation->amount           = $request->amount;
        $donation->country          = $request->country;
        $donation->organization     = $request->organization;
        $donation->phone            = $request->phone;
        $donation->email            = $request->email;
        $donation->donating_as      = $request->donating_as;
        $donation->method           = $request->method;
        $donation->save();

        session()->flash('success', 'Request received, please wait for follow up from '  . config('app.name') );

        if($this->settings->mail_enabled->value){
            $title = 'Support the Cause Request';

            try{
                \Mail::send('emails.support-the-cause', ['title' => $title, 'donation' => $donation], function ($message) use($donation, $title){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){
                $this->log_error($e);

                // session()->flash('error', $e->getMessage());
            }
        }

        return redirect()->back();
    }

    public function showContactUsPage(){
        
        return view('pages.user.contact-us',[
            'title'     => 'Contact Us',
            'nav'       => 'contact-us',
        ]);
    }

    public function postContactUs(Request $request){
        $this->validate($request,[
            'name'          => 'required|max:191',
            'email'         => 'required|max:191|email',
            'subject'       => 'required|max:191',
            'message'       => 'max:50000',
            
        ]);

        $contact_us             = new ContactUs;
        $contact_us->name       = $request->name;
        $contact_us->email      = $request->email;
        $contact_us->phone      = $request->phone;
        $contact_us->subject    = $request->subject;
        $contact_us->message    = $request->message;
        $contact_us->save();

        session()->flash('success', 'Message Sent, '  . config('app.name') .  ' will reply in due time');

        if($this->settings->mail_enabled->value){
            $title = 'Contact Message from ' . config('app.name');

            try{
                \Mail::send('emails.contact-us', ['title' => $title, 'contact_us' => $contact_us], function ($message) use($contact_us, $title){
                    $message->subject($title);
                    $message->to(config('app.system_email'));
                });

            }catch(\Exception $e){
                $this->log_error($e);
                
                // session()->flash('error', $e->getMessage());
            }
        }

        return redirect()->back();
    }

    public function showHowItWorksPage(){
        
        return view('pages.user.how-it-works',[
            'title'     => 'How It Works',
            'nav'       => 'how-it-works',
        ]);
    }

    public function showAboutUsPage(){
        
        return view('pages.user.about-us',[
            'title'     => 'About Us',
            'nav'       => 'about-us',
        ]);
    }

    public function showPrivacyPolicyPage(){
        
        return view('pages.user.privacy-policy',[
            'title'     => 'Privacy Policy',
            'nav'       => 'privacy-policy',
        ]);
    }

    public function showCommunityShopPage(){
    	$donated_items = DonatedItem::where('bought', 0)->where('disputed', 0)->orderBy('created_at','DESC')->paginate($this->pagination);

        return view('pages.user.community-shop',[
    		'title' 	      => 'Community Shop',
    		'nav' 		      => 'community-shop',
            'donated_items'   => $donated_items,
    	]);
    }

    public function showDonatedItem($slug){
        $item           = DonatedItem::where('slug', $slug)->firstOrFail();
        $mine           = false;
        $categories     = null;
        $user           = false;
        $coin_request   = false;
        $logged_in      = false;

        $reviews        = $item->reviews()->orderBy('created_at', 'DESC')->get();
        $review         = $item->reviews()->orderBy('created_at', 'DESC')->first();

        if(auth()->check()){
            $logged_in = true;
            $user = auth()->user();
            $coin_request = $user->coin_purchase_history()->where('approved', 0)->where('disapproved', 0)->first();

            if(auth()->user()->id == $item->donor_id){
                $mine = true;
                $categories = Category::orderBy('name', 'ASC')->get();
            }
        }

        return view('pages.user.donated-item',[
            'title'           => $item->name,
            'nav'             => 'donated-item',
            'item'            => $item,
            'reviews'         => $reviews,
            'review'          => $review,
            'mine'            => $mine,
            'logged_in'       => $logged_in,
            'user'            => $user,
            'categories'      => $categories,
            'coin_request'    => $coin_request,
            'settings'        => $this->settings,
        ]);
    }

    public function showGoodDeed($slug){
        $deed = GoodDeed::where('slug', $slug)->firstOrFail();

        $mine = false;

        if(auth()->check()){
            if(auth()->user()->id == $deed->user_id){
                $mine = true;
            }
        }

        return view('pages.user.good-deed',[
            'title'           => $deed->name,
            'nav'             => 'good-deed',
            'deed'            => $deed,
            'mine'            => $mine,
        ]);
    }

    public function showGoodDeeds(){
        $deeds = GoodDeed::where('approved', 1)->orderBy('created_at', 'DESC')->paginate(15);

        return view('pages.user.good-deeds',[
            'title'           => 'Good Deeds',
            'nav'             => 'good-deeds',
            'deeds'            => $deeds,
        ]);
    }

    public function showUserTimeline($username){
        $user = User::where('username', $username)->firstOrFail();

        if(auth()->check()){
            if(auth()->user()->id != $user->id){
                $user->views += 1;
                $user->update();
            }
        }

        $timeline = $user->timeline()->orderBy('created_at', 'DESC')->paginate(15);

        return view('pages.user.user-timeline',[
            'title'           => $user->name . ' | Timeline',
            'nav'             => 'user-timeline',
            'user'            => $user,
            'timeline'        => $timeline,
        ]);
    }

    public function showUserGoodDeeds($username){
        $user = User::where('username', $username)->firstOrFail();

        $me = false;
        $logged_in = auth()->check();

        if($logged_in){
            $auth = auth()->user();

            if($auth->id == $user->id){
                $me = true;
            }

        }

        if($me){
            $good_deeds = $user->good_deeds()->orderBy('created_at', 'DESC')->paginate(15);
        }

        else{
            $good_deeds = $user->good_deeds()->where('approved', 1)->orderBy('created_at', 'DESC')->paginate(15);
        }

        

        return view('pages.user.user-good-deeds',[
            'title'           => $user->name . ' | Good Deeds',
            'nav'             => 'user-good-deeds',
            'user'            => $user,
            'good_deeds'      => $good_deeds,
            'me'              => $me,
        ]);
    }

    public function showUserAbout($username){
        $user = User::where('username', $username)->firstOrFail();

        $me = false;

        if(auth()->check()){
            if(auth()->user()->id == $user->id){
                $me = true;
            }
        }

        return view('pages.user.user-about',[
            'title'           => $user->name . ' | About ',
            'nav'             => 'user-about',
            'user'            => $user,
            'me'              => $me,
        ]);
    }

    public function showUserDonatedItems($username){
        $user = User::where('username', $username)->firstOrFail();

        $donated_items = $user->donated_items()->orderBy('created_at', 'DESC')->paginate(15);

        return view('pages.user.user-donated-items',[
            'title'           => $user->name . ' | Donated Items',
            'nav'             => 'user-donated-items',
            'user'            => $user,
            'donated_items'   => $donated_items,

        ]);
    }

    public function showUserItemsBought($username){
        $user = User::where('username', $username)->firstOrFail();

        $donated_items = $user->bought_items()->orderBy('created_at', 'DESC')->paginate(15);

        return view('pages.user.user-items-bought',[
            'title'           => $user->name . ' | Bought Items',
            'nav'             => 'user-donated-items-bought',
            'user'            => $user,
            'donated_items'   => $donated_items,

        ]);
    }

    public function showUserPhotos($username){
        $user = User::where('username', $username)->firstOrFail();

        $photos = $user->photos()->orderBy('created_at', 'DESC')->paginate(15);

        $me = false;

        if(auth()->check()){
            if(auth()->user()->id == $user->id){
                $me = true;
            }
        }

        return view('pages.user.user-photos',[
            'title'           => $user->name . ' | Photos',
            'nav'             => 'user-photos',
            'user'            => $user,
            'me'              => $me,
            'photos'          => $photos,
        ]);
    }

    public function showUserReviews($username){
        $user = User::where('username', $username)->firstOrFail();
        $reviews = $user->reviews()->orderBy('created_at', 'DESC')->paginate(20);

        $me = false;
        $reviewed = false;
        $logged_in = auth()->check();

        if($logged_in){
            $auth = auth()->user();

            if($auth->id == $user->id){
                $me = true;
            }

            $reviewed = $user->reviews()->where('rater_id', $auth->id)->first();
        }

        return view('pages.user.user-reviews',[
            'title'           => $user->name . ' | Reviews',
            'nav'             => 'user-reviews',
            'user'            => $user,
            'reviews'         => $reviews,

            'logged_in'       => $logged_in,
            'reviewed'        => $reviewed,
            'me'              => $me,
        ]);
    }

    public function showDashboard(){
    	if(auth()->check()){
    		$user = auth()->user();

    		if($user->is_admin()){
    			return redirect()->route('admin.dashboard');
    		}elseif($user->is_user()){
    			return redirect()->route('user.dashboard');
    		}else{
    			return redirect()->route('front.logout');
    		}
    	}else{
    		return redirect()->route('login');
    	}
    }

    public function showClosedAccount(){
        return $this->logout();
    }

    public function logout(){
    	if(auth()->check()){
    		auth()->logout();
    	}

    	session()->flash('success', 'Logged out');

    	return redirect()->route('login');
    }
}
