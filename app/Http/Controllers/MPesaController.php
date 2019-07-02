<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, Session, Config, Mail;

use Carbon\Carbon;

use App\{Paypal_Transaction, Transaction, MpesaTransaction, Setting, Currency, Notification, MpesaRequest, AppLog, SimbaCoinLog, User, MpesaRaw, MpesaResponse, ErrorLog, PaymentValidation};

use \PayPal\Rest\ApiContext;

use \PayPal\Auth\OAuthTokenCredential;

use \PayPal\Api\{Payer, Item, ItemList, Details, Amount, RedirectUrls, PaymentExecution};

use \PayPal\Api\Transaction as PaypalTransaction;

use \PayPal\Api\Payment as PaypalPayment;

use \PayPal\Service\AdaptiveAccountsService;

use \PayPal\Types\AA\{AccountIdentifierType, GetVerifiedStatusRequest};

class MPesaController extends Controller
{
    protected $mpesa_mode,
    		  $mpesa_shortcode,
              $mpesa_passkey,
              $mpesa_consumer_key,
              $mpesa_consumer_secret,
              $mpesa_callback_url,
              $mpesa_currency,
              
              $mpesa_auth_url,
              $mpesa_request_url,
              $mpesa_query_url,
              $mpesa_access_token;

    protected $mpesa_errors = [
        '0' => 'Success',
        '1' => 'Insufficient Funds',
        '2' => 'Less Than Minimum Transaction Value',
        '3' => 'More Than Maximum Transaction Value',
        '4' => 'Would Exceed Daily Transfer Limit',
        '5' => 'Would Exceed Minimum Balance',
        '6' => 'Unresolved Primary Party',
        '7' => 'Unresolved Receiver Party',
        '8' => 'Would Exceed Maxiumum Balance',
        '11' => 'Debit Account Invalid',
        '12' => 'Credit Account Invalid',
        '13' => 'Unresolved Debit Account',
        '14' => 'Unresolved Credit Account',
        '15' => 'Duplicate Detected',
        '17' => 'Internal Failure',
        '20' => 'Unresolved Initiator',
        '26' => 'Traffic blocking condition in place',
    ];

    protected $mpesa_http_errors = [
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '406' => 'Not Acceptable – You requested a format that isn’t json',
        '429' => 'Too Many Requests – You’re requesting too many kittens! Slow down!',
        '500' => 'Internal Server Error – We had a problem with our server. Try again later.',
        '503' => 'Service Unavailable – We’re temporarily offline for maintenance. Please try again later.',
        
    ];

    public function __construct(){
        
        $this->initialize();

        $this->mpesa_currency = $this->settings->system_currency->value;

        if($this->settings->mpesa_db_preferred->value){
        	$this->mpesa_mode = $this->settings->mpesa_mode->value;
        
	        if($this->mpesa_mode == 'live'){
	            $this->mpesa_shortcode 			= $this->settings->mpesa_shortcode_live->value;
	            $this->mpesa_passkey 			= $this->settings->mpesa_passkey_live->value;
	            $this->mpesa_consumer_key 		= $this->settings->mpesa_consumer_key_live->value;
	            $this->mpesa_consumer_secret 	= $this->settings->mpesa_consumer_secret_live->value;
	            $this->mpesa_callback_url 		= $this->settings->mpesa_callback_url_live->value;

	            $this->mpesa_auth_url 			= 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
	            $this->mpesa_request_url 		= 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	            $this->mpesa_query_url 			= 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';
	        }elseif($this->mpesa_mode == 'sandbox'){
	            $this->mpesa_shortcode 			= $this->settings->mpesa_shortcode_sandbox->value;
	            $this->mpesa_passkey 			= $this->settings->mpesa_passkey_sandbox->value;
	            $this->mpesa_consumer_key 		= $this->settings->mpesa_consumer_key_sandbox->value;
	            $this->mpesa_consumer_secret 	= $this->settings->mpesa_consumer_secret_sandbox->value;
	            $this->mpesa_callback_url 		= $this->settings->mpesa_callback_url_sandbox->value;

	            $this->mpesa_auth_url 			= 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
	            $this->mpesa_request_url 		= 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	            $this->mpesa_query_url 			= 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
	        }  
        }else{
        	$this->mpesa_mode = env('MPESA_MODE');
        
	        if($this->mpesa_mode == 'live'){
	            $this->mpesa_shortcode 			= env('MPESA_SHORTCODE_LIVE');
	            $this->mpesa_passkey 			= env('MPESA_PASSKEY_LIVE');
	            $this->mpesa_consumer_key 		= env('MPESA_CONSUMER_KEY_LIVE');
	            $this->mpesa_consumer_secret 	= env('MPESA_CONSUMER_SECRET_LIVE');
	            $this->mpesa_callback_url 		= env('MPESA_CALLBACK_URL_LIVE');

	            $this->mpesa_auth_url 			= 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
	            $this->mpesa_request_url 		= 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	            $this->mpesa_query_url 			= 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';

	        }elseif($this->mpesa_mode == 'sandbox'){
	            $this->mpesa_shortcode 			= env('MPESA_SHORTCODE_SANDBOX');
	            $this->mpesa_passkey 			= env('MPESA_PASSKEY_SANDBOX');
	            $this->mpesa_consumer_key 		= env('MPESA_CONSUMER_KEY_SANDBOX');
	            $this->mpesa_consumer_secret 	= env('MPESA_CONSUMER_SECRET_SANDBOX');
	            $this->mpesa_callback_url 		= env('MPESA_CALLBACK_URL_SANDBOX');

	            $this->mpesa_auth_url 			= 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
	            $this->mpesa_request_url 		= 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	            $this->mpesa_query_url 			= 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
	        }  
        }

        
    }

    public function requestMpesaAccessToken(){
        $url = $this->mpesa_auth_url;



        try {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode( $this->mpesa_consumer_key . ':' . $this->mpesa_consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$credentials]); 
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            curl_close($curl);

            list($header, $body) = explode("\r\n\r\n", $response, 2);

            $fields = json_decode($body);
            
            $this->mpesa_access_token = $fields->access_token;

        } catch (\Exception $e) {

            $this->log_error($e);
        }
    }

    public function requestMpesaPayment(Request $request){

        $type = $request->type;

        $user = auth()->user();
        
        $this->validate($request,[
            'phone'     => 'numeric|required',
            'amount'    => 'numeric|required|min:1',
        ]);

        if(!$this->settings->mpesa_enabled->value){
            session()->flash('error', 'MPESA gateway as been disabled');

            return redirect()->back();
        }

        if($this->mpesa_mode == 'sandbox'){
            $amount = 1;
            $coins  = 10;
        }else{
            $coins   = (int)ceil($request->amount);

            $amount  = ($coins * $this->settings->coin_value->value);
        }
        
        $phone = $request->phone;

        $this->requestMpesaAccessToken();
        
        if($this->mpesa_access_token){
            $url 		= $this->mpesa_request_url;
            $shortcode 	= $this->mpesa_shortcode;
            $passkey 	= $this->mpesa_passkey;
            $timestamp 	= $this->date->format('YmdHis');

            $token = $this->generateToken($user->id);

            $route_params = ['user_id' => $user->id, 'type' => $type, 'coins' => $coins, 'token' => $token];
            
            if(!empty($this->mpesa_callback_url)){
                $callback = $this->mpesa_callback_url . route('mpesa.save', $route_params, false);
            }else{
                $callback = url(route('mpesa.save', $route_params));
            }       
            
            $password = base64_encode($shortcode.$passkey.$timestamp);

            try{
                $account_reference = 'simbacoin';

                $transaction_desc = 'Simba Coin Purchase';

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer ' . $this->mpesa_access_token ));

                $curl_post_data = [
                  'BusinessShortCode' 	=> $shortcode,
                  'Password' 			=> $password,
                  'Timestamp' 			=> $timestamp,
                  'TransactionType' 	=> 'CustomerPayBillOnline',
                  'Amount' 				=> $amount,
                  'PartyA' 				=> $phone,
                  'PartyB' 				=> $shortcode,
                  'PhoneNumber' 		=> $phone,
                  'CallBackURL' 		=> $callback,
                  'AccountReference' 	=> $account_reference,
                  'TransactionDesc' 	=> $transaction_desc, 
                ];

                $data_string = json_encode($curl_post_data);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

                $curl_response = curl_exec($curl);

                $info = curl_getinfo($curl);

                curl_close($curl);
            }

            catch(\Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());
            }

            $response = json_decode($curl_response);

            if(isset($response->errorCode) && !empty($response->errorCode)){
                session()->flash('error', $response->errorMessage);
                return redirect()->back();   
            }else{
            
                if(isset($response->ResponseCode) && $response->ResponseCode == 0){
                    session()->flash('success', $response->CustomerMessage . ', please input your MPESA PIN and press Ok');
                
                    return redirect()->route('user.balance');
                    
                }elseif(isset($response->ResponseCode) && $response->ResponseCode != 0){
                    session()->flash('error', $response->ResponseDescription);
                    return redirect()->back();
                }else{
                    session()->flash('error', 'Invalid Response, Please try again');
                    
                    return redirect()->back();
                }
                
            }
                
        }else{
            session()->flash('error', 'Error, Invalid Token, Please try again');
            
            return redirect()->back();
        }     
    }

    public function saveMpesaRequest(Request $request){
        $mpesa_response 			= new MpesaResponse;
        $mpesa_response->message 	= $request;
        $mpesa_response->save();

        $user_id    				= $request->user_id;
        $type       				= $request->type;
        $token      				= $request->token;

        $user       				= User::find($user_id);

        if($this->verifyToken($token, $user_id)){

            $this->expireToken($token, $user_id);

            try{
                list($h, $b) = explode("\r\n\r\n", $request, 2);
            }catch(\Exception $e){
                $b = $request;
            }

            $raw = new MpesaRaw;
            $raw->contents = $b;
            $raw->save();

            if(!$user){           
                $log = new AppLog;
                $log->message = $request;
                $log->save();

                return response("0"); 
            }

            $coins  = $request->coins;

            if($this->settings->mpesa_db_preferred->value){
				$medium = $this->settings->mpesa_mode->value == 'live' ? 'MPESA' : 'MPESA Sandbox';
            }else{
            	$medium = env('MPESA_MODE') == 'live' ? 'MPESA' : 'MPESA Sandbox';
            }

            try {
                list($header, $body) = explode("\r\n\r\n", $request, 2);

                $fields = json_decode($body);

                $response = $fields->Body->stkCallback;  

                $mpesa_request                      = new MpesaRequest;
                $mpesa_request->user_id             = $user->id;  
                
                $mpesa_request->MerchantRequestID   = $response->MerchantRequestID; 
                $mpesa_request->CheckoutRequestID   = $response->CheckoutRequestID; 
                $mpesa_request->ResultDesc          = $response->ResultDesc;    
                $mpesa_request->ResultCode          = $response->ResultCode;    
                $mpesa_request->save();     
                

                if($response->ResultCode == 0){

                    $items = $response->CallbackMetadata->Item;

                    $details = [];

                    foreach ($items as $item) {
                        $details[$item->Name] = isset($item->Value) ? $item->Value : null;
                    }

                    if($mpesa_request->ResultCode == 0){
                        $transaction                    = new Transaction;
                        $transaction->user_id           = $user->id;
                        $transaction->coins             = $coins;
                        $transaction->transaction_code  = $details['MpesaReceiptNumber'];; 
                        $transaction->amount            = (float)$details['Amount'];
                        $transaction->medium            = $medium;
                        $transaction->status            = 'COMPLETE';
                        $transaction->currency          = $this->mpesa_currency;
                        $transaction->type              = 'INCOMING';
                        $transaction->description       = number_format($coins) . ' Simba Coin(s) Purchase via ' . $medium;
                        $transaction->completed_at      = $this->date;
                        $transaction->save();

                        $mpesa_transaction                      = new MpesaTransaction;
                        $mpesa_transaction->Amount              = $details['Amount'];
                        $mpesa_transaction->MpesaReceiptNumber  = $details['MpesaReceiptNumber'];
                        $mpesa_transaction->Balance             = $details['Balance'];
                        $mpesa_transaction->TransactionDate     = $details['TransactionDate'];
                        $mpesa_transaction->PhoneNumber         = $details['PhoneNumber'];
                        $mpesa_transaction->user_id             = $user->id;
                        $mpesa_transaction->coins               = $coins;
                        $mpesa_transaction->mpesa_request_id    = $mpesa_request->id;
                        $mpesa_transaction->transaction_id      = $transaction->id;
                        $mpesa_transaction->save();

                        $user->coins += $coins;
                        $user->update();

                        $this->settings->available_balance->value += $coins;
                        $this->settings->available_balance->update();

                        $this->settings->coins_in_circulation->value += $coins;
                        $this->settings->coins_in_circulation->update();

                        $simba_coin_log                        = new SimbaCoinLog;
                        $simba_coin_log->user_id               = $user->id;
                        $simba_coin_log->message               = $coins . ' Simba Coins Purchased using ' . $medium;
                        $simba_coin_log->type                  = 'credit';
                        $simba_coin_log->coins                 = $coins;
                        $simba_coin_log->previous_balance      = $user->coins - $coins ;
                        $simba_coin_log->current_balance       = $user->coins;
                        $simba_coin_log->save();
                        
                        $message = 'MPESA ' . $this->mpesa_currency . ' '. number_format($transaction->amount) .' received from ' . $user->id;
                        
                        $notification                       = new Notification;
                        $notification->to_id                = null;
                        $notification->from_id              = $user->id;
                        $notification->model_id             = null;
                        $notification->notification_type    = 'coins.purchased';
                        $notification->system_message       = 1;
                        $notification->message              = ucfirst($coins . ' Simba Coins Purchased By ' . $user->name . ' via ' . $medium);
                        $notification->save();

                        $notification                       = new Notification;
                        $notification->to_id                = $user->id;
                        $notification->from_id              = null;
                        $notification->from_admin           = 0;
                        $notification->model_id             = null;
                        $notification->notification_type    = 'coins.purchased';
                        $notification->system_message       = 1;
                        $notification->message              = ucfirst($coins . ' Simba Coins Purchase via ' . $medium);
                        $notification->save();


                        if($this->settings->mail_enabled->value){

                            try{
                                $title = 'MPESA Payment Received from ' . $user->name;

                                \Mail::send('emails.payment-mpesa-admin', ['title' => $title, 'transaction' => $transaction, 'mpesa_transaction' => $mpesa_transaction], function ($message) use($transaction, $title){
                                    $message->subject($title);
                                    $message->to(config('app.system_email'));
                                });

                                
                                $title = config('app.name') .' | MPESA Payment Received.';

                                \Mail::send('emails.payment-mpesa-user', ['title' => $title, 'transaction' => $transaction, 'mpesa_transaction' => $mpesa_transaction], function ($message) use($transaction, $title){
                                    $message->subject($title);
                                    $message->to($transaction->user->email);
                                });

                            }catch(\Exception $e){
                                $this->log_error($e);

                                // session()->flash('error', $e->getMessage());
                            }
                        }

                        return response("0");
                    }   

                    
                }else{
                    $message = 'MPESA Payment not received for Simba Coin Purchase. Reason : ' . $response['ResultDesc'];

                    $notification                       = new Notification;
                    $notification->to_id                = $user->id;
                    $notification->from_id              = null;
                    $notification->from_admin           = 0;
                    $notification->model_id             = null;
                    $notification->notification_type    = 'coins.purchase.failed.mpesa';
                    $notification->system_message       = 1;
                    $notification->message              = ucfirst($message);
                    $notification->save();

                    $log = new AppLog;
                    $log->message = $message;
                    $log->save();
                }           
            } catch(\Exception $e) {
                $this->log_error($e);
            }

            return response("0");
        }

        else{
            return response("0");
        }
    }

    public function mpesaCallback(Request $request){
        
        return response("0");
    }

    public function generateToken($user_id){
        $payment_validation = new PaymentValidation;
        $payment_validation->user_id = $user_id;
        $payment_validation->token = generateRandomString(100);
        $payment_validation->save();

        return $payment_validation->token;
    }

    public function verifyToken($token, $user_id){
        $payment_validation = PaymentValidation::where('user_id', $user_id)->where('token', $token)->where('used', 0)->first();

        return $payment_validation;
    }

    public function expireToken($token, $user_id){
        $payment_validation = PaymentValidation::where('user_id', $user_id)->where('token', $token)->first();
        if($payment_validation){
            $payment_validation->used = 1;
            $payment_validation->used_at = $this->date;
            $payment_validation->update();
        } 
    }
}
