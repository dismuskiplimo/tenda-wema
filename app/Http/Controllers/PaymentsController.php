<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, Session, Config, Mail;

use Carbon\Carbon;

use App\{Paypal_Transaction, Transaction, MpesaTransaction, Setting, Currency, Notification, MpesaRequest, AppLog, SimbaCoinLog, User, MpesaRaw, ErrorLog};

use \PayPal\Rest\ApiContext;

use \PayPal\Auth\OAuthTokenCredential;

use \PayPal\Api\{Payer, Item, ItemList, Details, Amount, RedirectUrls, PaymentExecution};

use \PayPal\Api\Transaction as PaypalTransaction;

use \PayPal\Api\Payment as PaypalPayment;

use \PayPal\Service\AdaptiveAccountsService;

use \PayPal\Types\AA\{AccountIdentifierType, GetVerifiedStatusRequest};

class PaymentsController extends Controller
{
	protected $paypal_client_id,
              $paypal_secret,
              $paypal_currency,
              $paypal_mode,
              $paypal_config,
              $app_name,
              $mpesa_consumer_key,
              $mpesa_consumer_secret,
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

    public function __construct(){
    	

    	$this->initialize();

    	//paypal

    	$mode = $this->settings->paypal_mode->value;

        $this->app_name = config('app.name');
        
        $this->paypal_currency = $this->settings->paypal_currency->value;

        if($mode == 'sandbox'){
            $this->paypal_client_id 	= $this->settings->paypal_client_id_sandbox->value;
            $this->paypal_secret 		= $this->settings->paypal_secret_sandbox->value;
            $this->paypal_mode 		    = $mode;
        }elseif($mode == 'live'){
            $this->paypal_client_id 	= $this->settings->paypal_client_id_live->value;
            $this->paypal_secret 		= $this->settings->paypal_secret_live->value;
            $this->paypal_mode 		    = $mode;
        }else{
            $this->paypal_mode = 'test';
        }

        $this->paypal_config = [
            'mode' => $this->paypal_mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        ];

        //MPESA

        $mode = $this->settings->mpesa_mode->value;
        
        if($mode == 'live'){
        	$this->mpesa_consumer_key = $this->settings->mpesa_consumer_key_live->value;
        	$this->mpesa_consumer_secret = $this->settings->mpesa_consumer_secret_live->value;
        	$this->mpesa_auth_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        	$this->mpesa_request_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        	$this->mpesa_query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        }elseif($mode == 'sandbox'){
        	$this->mpesa_consumer_key = $this->settings->mpesa_consumer_key_sandbox->value;
        	$this->mpesa_consumer_secret = $this->settings->mpesa_consumer_secret_sandbox->value;
        	$this->mpesa_auth_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        	$this->mpesa_request_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        	$this->mpesa_query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        }
    }

    public function makePaypalPayment(Request $request, $type){
    	$this->validate($request, [
            'amount' => 'required|numeric|min:1',
        ]);

        if(!$this->settings->paypal_enabled->value){
            session()->flash('error', 'Paypal gateway as been disabled');

            return redirect()->back();
        }

        $user           = auth()->user();

        $coins          = ceil($request->amount);

        $amount_to_pay  = ($coins / $this->settings->coin_value->value);

        if($this->paypal_mode == 'test'){

            $user->coins += $coins;
            $user->update();

            $transaction                    = new Transaction;
            $transaction->user_id           = $user->id;
            $transaction->coins             = $coins;
            $transaction->transaction_code  = 'MXDDSDSW'; 
            $transaction->amount            = $amount_to_pay;
            $transaction->medium            = 'PAYPAL TEST';
            $transaction->status            = 'COMPLETE';
            $transaction->currency          = $this->settings->paypal_currency->value;
            $transaction->type              = 'INCOMING';
            $transaction->description       = number_format($coins) . ' Simba Coin(s) Purchase Via PayPal Test';
            $transaction->completed_at      = $this->date;
            $transaction->save();

            $notification                       = new Notification;
            $notification->to_id                = null;
            $notification->from_id              = $user->id;
            $notification->model_id             = null;
            $notification->notification_type    = 'coins.purchased';
            $notification->system_message       = 1;
            $notification->message              = ucfirst($coins . ' Simba Coins Purchased Via PayPal Test By ' . $user->name);
            $notification->save();

            $this->settings->available_balance->value += $coins;
            $this->settings->available_balance->update();

            $this->settings->coins_in_circulation->value += $coins;
            $this->settings->coins_in_circulation->update();

            $simba_coin_log                        = new SimbaCoinLog;
            $simba_coin_log->user_id               = $user->id;
            $simba_coin_log->message               = $coins . ' Simba Coins Purchased From Paypal';
            $simba_coin_log->type                  = 'credit';
            $simba_coin_log->coins                 = $coins;
            $simba_coin_log->previous_balance      = $user->coins - $coins ;
            $simba_coin_log->current_balance       = $user->coins;
            $simba_coin_log->save();


            session()->flash('success', $this->settings->paypal_currency->value . ' ' . number_format($amount_to_pay) . ' Has been received from ' . $user->name);

            return redirect()->back();
        }else{
            $credential = new OAuthTokenCredential($this->paypal_client_id, $this->paypal_secret);
            $paypal = new ApiContext($credential);
            
            $paypal->setConfig($this->paypal_config);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName(number_format($coins) . ' Simba Coin(s) purchse')
                 ->setCurrency($this->settings->paypal_currency->value)
                 ->setQuantity(1)
                 ->setPrice($amount_to_pay);

            $itemList = new ItemList();
            $itemList->setItems([$item]);

            $details = new Details();
            $details->setSubTotal($amount_to_pay);

            $amount = new Amount();
            $amount->setCurrency($this->settings->paypal_currency->value)
                   ->setTotal($amount_to_pay)
                   ->setDetails($details);

            $transaction = new PaypalTransaction();
            $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription(number_format($coins) . ' Simba Coin(s) purchse')
                        ->setInvoiceNumber(time());           

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(url(route('paypal.verify',['success'=>'true', 'amount' => $amount_to_pay, 'type' => $type, 'coins' => $coins])))
                         ->setCancelUrl(url(route('paypal.verify',['success'=>'true', 'type' => $type])));

            $payment = new PaypalPayment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls)
                    ->setTransactions([$transaction]);


            try{
                $payment->create($paypal);
            }catch(Exception $e){
                $this->log_error($e);

                session()->flash('error', $e->getMessage());

                return redirect()->back();
            }

            $approvalUrl = $payment->getApprovalLink();

            return redirect($approvalUrl);
        }    
    }

    public function verifyPaypalPayment(Request $request, $type){
        
        $credential = new OAuthTokenCredential($this->paypal_client_id,$this->paypal_secret);

        $paypal = new ApiContext($credential);

        $paypal->setConfig($this->paypal_config);

        $user = auth()->user();

        $medium = $this->settings->paypal_mode->value == 'live' ? 'Paypal' : 'Paypal Sandbox';
        

        if($request->has('success') && (bool)$request->success == true){
            if($request->has('paymentId') && $request->has('PayerID') && $request->has('token') && $request->has('amount') && $request->has('coins')){

                $success = (bool)$request->success;
                $paymentId = $request->paymentId;
                $payerId = $request->PayerID;
                $token = $request->token;
                $amount = (float)$request->amount;

                $amount_to_pay = $amount;
                $coins         = $request->coins;

                $payment = PaypalPayment::get($paymentId, $paypal);
                
                $execute = new PaymentExecution();
                $execute->setPayerId($payerId);

                try{
                    $result = $payment->execute($execute, $paypal);
                }catch(\PayPal\Exception\PayPalConnectionException $e){
                    $this->log_error($e);

                    session()->flash('error','There was an error processing your payment, the token has already been used');
                    
                    return redirect()->route('user.balance');
                }

                $paypal_transaction             = new PayPal_Transaction;
                $paypal_transaction->user_id    = $user->id;
                $paypal_transaction->payment_id = $paymentId;
                $paypal_transaction->payer_id   = $payerId;
                $paypal_transaction->token      = $token;
                $paypal_transaction->amount     = $amount;
                $paypal_transaction->coins      = $coins;
                $paypal_transaction->currency   = $this->settings->paypal_currency->value;
                $paypal_transaction->save();

                $transaction                    = new Transaction;
                $transaction->user_id           = $user->id;
                $transaction->coins             = $coins;
                $transaction->transaction_code  = $token; 
                $transaction->amount            = $amount_to_pay;
                $transaction->medium            = $this->paypal_mode == "sandbox" ? 'PAYPAL SANDBOX' : 'PAYPAL';
                $transaction->status            = 'COMPLETE';
                $transaction->currency          = $this->settings->paypal_currency->value;
                $transaction->type              = 'INCOMING';
                $transaction->description       = number_format($coins) . ' Simba Coin(s) Purchase';
                $transaction->completed_at      = $this->date;
                $transaction->save();

                $paypal_transaction->transaction_id = $transaction->id;
                $paypal_transaction->update();

                $user->coins += $coins;
                $user->update();

                $simba_coin_log                        = new SimbaCoinLog;
                $simba_coin_log->user_id               = $user->id;
                $simba_coin_log->message               = $coins . ' Simba Coins Purchased From ' . $medium;
                $simba_coin_log->type                  = 'credit';
                $simba_coin_log->coins                 = $coins;
                $simba_coin_log->previous_balance      = $user->coins - $coins ;
                $simba_coin_log->current_balance       = $user->coins;
                $simba_coin_log->save();

                $this->settings->available_balance->value += $coins;
                $this->settings->available_balance->update();

                $this->settings->coins_in_circulation->value += $coins;
                $this->settings->coins_in_circulation->update();

                $notification                       = new Notification;
                $notification->to_id                = null;
                $notification->from_id              = $user->id;
                $notification->model_id             = null;
                $notification->notification_type    = 'coins.purchased';
                $notification->system_message       = 1;
                $notification->message              = ucfirst($coins . ' Simba Coins Purchased By ' . $user->name);
                $notification->save();

                $notification                       = new Notification;
                $notification->to_id                = $user->id;
                $notification->from_id              = null;
                $notification->model_id             = $paypal_transaction->id;
                $notification->notification_type    = 'coins.purchased';
                $notification->system_message       = 1;
                $notification->from_admin           = 1;
                $notification->message              = ucfirst($coins . ' Simba Coins Purchase Via ' . $medium);
                $notification->save();

                if($this->settings->mail_enabled->value){

                    try{
                        $title = 'PayPal Payment Received from ' . $user->name;

                        \Mail::send('emails.payment-paypal-admin', ['title' => $title, 'transaction' => $transaction], function ($message) use($transaction, $title){
                            $message->subject($title);
                            $message->to(config('app.system_email'));
                        });

                        
                        $title = config('app.name') .' | PayPal Payment Received.';

                        \Mail::send('emails.payment-paypal-user', ['title' => $title, 'transaction' => $transaction], function ($message) use($transaction, $title){
                            $message->subject($title);
                            $message->to($transaction->user->email);
                        });

                    }catch(\Exception $e){
                        $this->log_error($e);

                        // session()->flash('error', $e->getMessage());
                    }
                }

                session()->flash('success', $this->settings->paypal_currency->value . ' ' . number_format($amount_to_pay, 2) . ' Has been received for ' . number_format($coins) . ' Simba Coin(s) Purchase');

            }else{
                session()->flash('error','There was an error processing your payment, no money was deducted however');
            }
        }else{
            session()->flash('error','There was an error processing your payment, no money was deducted however');
        }

        return redirect()->route('user.balance');        
    }

    public function requestMpesaAccessToken(){
        $url = $this->mpesa_auth_url;

        try {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode( $this->mpesa_consumer_key . ':' . $this->mpesa_consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            list($header, $body) = explode("\r\n\r\n", $response, 2);

            $fields = json_decode($body);
            
            $this->mpesa_access_token = $fields->access_token;
        } catch (\Exception $e) {

            $this->log_error($e);
        }
    }

    public function makeMpesaPayment(Request $request, $type){

        $user = auth()->user();
        
        $this->validate($request,[
            'phone'     => 'numeric|required',
            'amount'    => 'numeric|required|min:1',
        ]);

        if(!$this->settings->mpesa_enabled->value){
            session()->flash('error', 'Paypal gateway as been disabled');

            return redirect()->back();
        }

        if($this->settings->mpesa_mode->value == 'sandbox'){
            $amount = 1;
            $coins  = 10;
        }else{
            $coins   = (int)ceil($request->amount);

            $amount  = ($coins * $this->settings->coin_value->value);
        }
        
        $phone = $request->phone;

        $this->requestMpesaAccessToken();
        
        if($this->mpesa_access_token){
            $url = $this->mpesa_request_url;

            
            $shortcode = $this->settings->mpesa_shortcode->value;
            $passkey = $this->settings->mpesa_passkey->value;
            $timestamp = $this->date->format('YmdHis');
            
            if($this->settings->mpesa_callback_url->value){
                $callback = $this->settings->mpesa_callback_url->value . route('mpesa.save', ['id' => $user->id, 'type' => $type, 'coins' => $coins], false);
            }else{
                $callback = url(route('mpesa.save', ['id' => $user->id, 'type' => $type, 'coins' => $coins]));
            }       
            
            $password = base64_encode($shortcode.$passkey.$timestamp);

            try{
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer ' . $this->mpesa_access_token ));

                $curl_post_data = [
                  'BusinessShortCode' => $shortcode,
                  'Password' => $password,
                  'Timestamp' => $timestamp,
                  'TransactionType' => 'CustomerPayBillOnline',
                  'Amount' => $amount,
                  'PartyA' => $phone,
                  'PartyB' => $shortcode,
                  'PhoneNumber' => $phone,
                  'CallBackURL' => $callback,
                  'AccountReference' => 'simbacoin',
                  'TransactionDesc' => 'Simba Coin Purchase', 
                ];

                $data_string = json_encode($curl_post_data);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

                $curl_response = curl_exec($curl);
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
                    return redirect()->back();
                }
                
            }
                
        }else{
            session()->flash('error', 'Error, Please try again');
            
            return redirect()->back();
        }     
    }

    public function saveMpesaRequest(Request $request, $id , $type){
        $user   = User::find($id);

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
            
            return response()->json(['code' => 1]);   
        }

        $coins  = $request->coins;

        $medium = $this->settings->mpesa_mode->value == 'live' ? 'MPESA' : 'MPESA Sandbox';

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
                    $transaction->currency          = $this->settings->system_currency->value;
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
                    
                    $message = 'MPESA ' . $this->settings->system_currency . ' '. number_format($transaction->amount) .' received from ' . $user->id;
                    
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
    }
}
