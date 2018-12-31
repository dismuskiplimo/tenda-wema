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
		    			<label for="">Simba Coin Value</label>
		    			<input type="text"  name="coin_value" class="form-control" value="{{ $settings->coin_value->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Exchange Rate</label>
		    			<input type="text"  name="exchange_rate" class="form-control" value="{{ $settings->exchange_rate->value }}">
		    		</div>

		    		<div class="form-group">
		    			<label for="">Currency</label>
		    			<select name="system_currency" id="" class="form-control" required="">
		    				@foreach($currencies as $currency)
								<option value="{{ $currency->code }}" {{ $currency->code == $settings->system_currency->value ? 'selected' : '' }}>{{ $currency->code }}</option>
		    				@endforeach
		    			</select>
		    			
		    		</div>

		    		<button class="btn btn-info" type="submit">UPDATE SITE SETTINGS</button>

		    	</form>
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="email-settings">
		    	
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="mpesa-settings">
		    	
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="paypal-settings">

		    </div>
		    
		  </div>

		</div>
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection