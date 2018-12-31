@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }}</h3>

	            <div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#site-settings" aria-controls="site-settings" role="tab" data-toggle="tab">Site Settings</a></li>
		    <li role="presentation"><a href="#email-settings" aria-controls="email-settings" role="tab" data-toggle="tab">Email Settings</a></li>
		    <li role="presentation"><a href="#mpesa-settings" aria-controls="mpesa-settings" role="tab" data-toggle="tab">MPESA Settings</a></li>

		    <li role="presentation"><a href="#paypal-settings" aria-controls="paypal-settings" role="tab" data-toggle="tab">PayPal Settings</a></li>
		    
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade in active" id="site-settings">
		    	<form action="{{ route('admin.site-settings') }}" method="POST">
		    		@csrf

		    		<div class="form-group">
		    			<label for="">Simba Coin Value (KES)</label>
		    			<input type="number"  name="coin_value" class="form-control" value="{{ $settings->coin_value->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Exchange Rate ({{ $settings->system_currency->value }} to {{ $settings->paypal_currency->value }})</label>
		    			<input type="number"  name="exchange_rate" class="form-control" value="{{ $settings->exchange_rate->value }}">
		    		</div>	    		

		    		<button class="btn btn-info" type="submit">UPDATE SITE SETTINGS</button>

		    	</form>
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="email-settings">
		    	<form action="{{ route('admin.site-settings') }}" method="POST">
		    		@csrf

		    		<div class="form-group">
		    			<label for="">Email Enabled</label>

		    			<select name="mail_enabled" class="form-control">
		    				<option value="1" {{ $settings->mail_enabled->value == 1 ? 'selected' : '' }}>YES</option>
		    				<option value="0" {{ $settings->mail_enabled->value == 0 ? 'selected' : '' }}>NO</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">Settings to be used?</label>

		    			<select name="mail_db_preferred" class="form-control">
		    				<option value="1" {{ $settings->mail_db_preferred->value == 1 ? 'selected' : '' }}>LOAD DB SETTINGS</option>
		    				<option value="0" {{ $settings->mail_db_preferred->value == 0 ? 'selected' : '' }}>USE .ENV SETTINGS</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">Email Driver</label>

		    			<select name="mail_driver" class="form-control">
		    				<option value="smtp" {{ $settings->mail_driver->value == 'smtp' ? 'selected' : '' }}>SMTP</option>
		    				<option value="sparkpost" {{ $settings->mail_driver->value == 'sparkpost' ? 'selected' : '' }}>SPARKPOST</option>
		    				<option value="mailgun" {{ $settings->mail_driver->value == 'mailgun' ? 'selected' : '' }}>NO, MAILGUN</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">Email Host</label>
		    			<input type="text"  name="mail_host" class="form-control" value="{{ $settings->mail_host->value }}">
		    		</div>	

		    		<div class="form-group">
		    			<label for="">Email Port</label>
		    			<input type="number"  name="mail_port" class="form-control" value="{{ $settings->mail_port->value }}">
		    		</div>	

		    		<div class="form-group">
		    			<label for="">Email Username</label>
		    			<input type="text"  name="mail_username" class="form-control" value="{{ $settings->mail_username->value }}">
		    		</div>	

		    		<div class="form-group">
		    			<label for="">Email Password</label>
		    			<input type="text"  name="mail_password" class="form-control" value="{{ $settings->mail_password->value }}">
		    		</div>	

		    		<div class="form-group">
		    			<label for="">Email Encryption</label>

		    			<select name="mail_driver" class="form-control">
		    				<option value="" {{ $settings->mail_encryption->value == null ? 'selected' : '' }}>NONE</option>
		    				<option value="tls" {{ $settings->mail_encryption->value == 'tls' ? 'selected' : '' }}>TLS</option>
		    				<option value="ssl" {{ $settings->mail_encryption->value == 'ssl' ? 'selected' : '' }}>SSL</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">Email From Address</label>
		    			<input type="email"  name="mail_from_address" class="form-control" value="{{ $settings->mail_from_address->value }}">
		    		</div>	

		    		<div class="form-group">
		    			<label for="">Email From Name</label>
		    			<input type="text"  name="mail_from_name" class="form-control" value="{{ $settings->mail_from_name->value }}">
		    		</div>

		    		<h4>SPARKPOST SETTINGS</h4>	

		    		<div class="form-group">
		    			<label for="">Sparkpost Secret</label>
		    			<input type="text"  name="sparkpost_secret" class="form-control" value="{{ $settings->sparkpost_secret->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Sparkpost Endpoint</label>
		    			<input type="text"  name="sparkpost_endpoint" class="form-control" value="{{ $settings->sparkpost_endpoint->value }}">
		    		</div>	

		    		<h4>MAILGUN SETTINGS</h4>

		    		<div class="form-group">
		    			<label for="">Mailgun Secret</label>
		    			<input type="text"  name="mailgun_secret" class="form-control" value="{{ $settings->mailgun_secret->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Mailgun Domain</label>
		    			<input type="text"  name="mailgun_domain" class="form-control" value="{{ $settings->mailgun_domain->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Mailgun Endpoint</label>
		    			<input type="text"  name="mailgun_endpoint" class="form-control" value="{{ $settings->mailgun_endpoint->value }}">
		    		</div>

		    		<button class="btn btn-info" type="submit">UPDATE EMAIL SETTINGS</button>

		    	</form>
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="mpesa-settings">
		    	<form action="{{ route('admin.site-settings') }}" method="POST">
		    		@csrf

		    		<div class="form-group">
		    			<label for="">MPESA Enabled</label>

		    			<select name="mpesa_enabled" class="form-control">
		    				<option value="1" {{ $settings->mpesa_enabled->value == 1 ? 'selected' : '' }}>YES</option>
		    				<option value="0" {{ $settings->mpesa_enabled->value == 0 ? 'selected' : '' }}>NO</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">Currency</label>
		    			<select name="system_currency" id="" class="form-control">
		    				@foreach($currencies as $currency)
								<option value="{{ $currency->code }}" {{ $currency->code == $settings->system_currency->value ? 'selected' : '' }}>{{ $currency->code }}</option>
		    				@endforeach
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Mode</label>

		    			<select name="mpesa_mode" class="form-control">
		    				<option value="sandbox" {{ $settings->mpesa_mode->value == 'sandbox' ? 'selected' : '' }}>SANDBOX</option>
		    				<option value="live" {{ $settings->mpesa_mode->value == 'live' ? 'selected' : '' }}>LIVE</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Shortcode</label>
		    			<input type="text"  name="mpesa_shortcode" class="form-control" value="{{ $settings->mpesa_shortcode->value }}" >
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Passkey</label>
		    			<input type="text"  name="mpesa_passkey" class="form-control" value="{{ $settings->mpesa_passkey->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Callback Url (if any)</label>
		    			<input type="text"  name="mpesa_callback_url" class="form-control" value="{{ $settings->mpesa_callback_url->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Consumer Key (Sandbox)</label>
		    			<input type="text"  name="mpesa_consumer_key_sandbox" class="form-control" value="{{ $settings->mpesa_consumer_key_sandbox->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Consumer Secret (Sandbox)</label>
		    			<input type="text"  name="mpesa_consumer_secret_sandbox" class="form-control" value="{{ $settings->mpesa_consumer_secret_sandbox->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Consumer Key (Live)</label>
		    			<input type="text"  name="mpesa_consumer_key_live" class="form-control" value="{{ $settings->mpesa_consumer_key_live->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">MPESA Consumer Secret (Live)</label>
		    			<input type="text"  name="mpesa_consumer_secret_live" class="form-control" value="{{ $settings->mpesa_consumer_secret_live->value }}">
		    		</div>
		    		

		    		<button class="btn btn-info" type="submit">UPDATE MPESA SETTINGS</button>
		    	</form>
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="paypal-settings">
				<form action="{{ route('admin.site-settings') }}" method="POST">
		    		@csrf

		    		<div class="form-group">
		    			<label for="">PayPal Enabled</label>

		    			<select name="paypal_enabled" class="form-control">
		    				<option value="1" {{ $settings->paypal_enabled->value == 1 ? 'selected' : '' }}>YES</option>
		    				<option value="0" {{ $settings->paypal_enabled->value == 0 ? 'selected' : '' }}>NO</option>
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">PayPal Currency</label>
		    			<select name="paypal_currency" id="" class="form-control">
		    				@foreach($currencies as $currency)
								<option value="{{ $currency->code }}" {{ $currency->code == $settings->paypal_currency->value ? 'selected' : '' }}>{{ $currency->code }}</option>
		    				@endforeach
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">PayPal Mode</label>

		    			<select name="paypal_mode" class="form-control">
		    				<option value="sandbox" {{ $settings->paypal_mode->value == 'sandbox' ? 'selected' : '' }}>SANDBOX</option>

		    				<option value="live" {{ $settings->paypal_mode->value == 'test' ? 'selected' : '' }}>TEST</option>
		    				
		    				<option value="live" {{ $settings->paypal_mode->value == 'live' ? 'selected' : '' }}>LIVE</option>
		    				
		    			</select>
		    			
		    		</div>

		    		<div class="form-group">
		    			<label for="">PayPal Client Id (Sandbox)</label>
		    			<input type="text"  name="paypal_client_id_sandbox" class="form-control" value="{{ $settings->paypal_client_id_sandbox->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Paypal Secret (Sandbox)</label>
		    			<input type="text"  name="paypal_secret_sandbox" class="form-control" value="{{ $settings->paypal_secret_sandbox->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">PayPal Client Id (Live)</label>
		    			<input type="text"  name="paypal_client_id_live" class="form-control" value="{{ $settings->paypal_client_id_live->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">PayPal Secret (Live)</label>
		    			<input type="text"  name="paypal_secret_live" class="form-control" value="{{ $settings->paypal_secret_live->value }}">
		    		</div>
		    		

		    		<button class="btn btn-info" type="submit">UPDATE PAYPAL SETTINGS</button>
		    	</form>
		    </div>
		    
		  </div>

		</div>
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection