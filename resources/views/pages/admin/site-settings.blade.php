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