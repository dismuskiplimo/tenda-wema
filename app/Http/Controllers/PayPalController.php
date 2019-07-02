<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, Session, Config, Mail;

use Carbon\Carbon;

use App\{Paypal_Transaction, Transaction, Setting, Currency, Notification, AppLog, SimbaCoinLog, User, ErrorLog, PaymentValidation};

use \PayPal\Rest\ApiContext;

use \PayPal\Auth\OAuthTokenCredential;

use \PayPal\Api\{Payer, Item, ItemList, Details, Amount, RedirectUrls, PaymentExecution};

use \PayPal\Api\Transaction as PaypalTransaction;

use \PayPal\Api\Payment as PaypalPayment;

use \PayPal\Service\AdaptiveAccountsService;

use \PayPal\Types\AA\{AccountIdentifierType, GetVerifiedStatusRequest};

class PayPalController extends Controller
{
    protected $paypal_client_id,
              $paypal_secret,
              $paypal_currency,
              $paypal_mode,
              $paypal_config,
              $app_name,

    public function __construct(){

        $this->initialize();

        $mode = $this->settings->paypal_mode->value;

        $this->app_name = config('app.name');
        
        $this->paypal_currency = $this->settings->paypal_currency->value;

        if($mode == 'sandbox'){
            $this->paypal_client_id     = $this->settings->paypal_client_id_sandbox->value;
            $this->paypal_secret        = $this->settings->paypal_secret_sandbox->value;
            $this->paypal_mode          = $mode;
        }elseif($mode == 'live'){
            $this->paypal_client_id     = $this->settings->paypal_client_id_live->value;
            $this->paypal_secret        = $this->settings->paypal_secret_live->value;
            $this->paypal_mode          = $mode;
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

        
    }

    public function requestPaypalPayment(Request $request){
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

        $token          = $this->generateToken($user->id);

        $type           = $request->type;

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

    public function verifyPaypalPayment(Request $request){
        
        $credential = new OAuthTokenCredential($this->paypal_client_id,$this->paypal_secret);

        $paypal = new ApiContext($credential);

        $paypal->setConfig($this->paypal_config);

        $user       = auth()->user();

        $type       = $request->type;

        $medium     = $this->settings->paypal_mode->value == 'live' ? 'Paypal' : 'Paypal Sandbox';
        
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
