@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} <a href="{{ route('admin.messages', ['type' => 'all']) }}" class="btn btn-xs btn-info pull-right"><i class="fa fa-chevron-left"></i> BACK TO CONVERSATIONS</a></h3>
	            
	            <div class="conversation-box h-306">
	            	<div id="messages" style="min-height: 100%" class="admin-messages">
						@if(count($conversation->messages))
							@foreach($conversation->messages as $message)
								
								@if($message->from_admin)
									<div class="msg-right msg">
								        <p class="mb-0">
								        	<small><b>Admin</b></small> <br>
								        	<small>{{ $message->message }}</small> <br>
								        	<small class="pull-right">
								        		{{ $message->created_at->diffForHumans() }}
								        	</small>
								        </p>
								    </div>
								@else
									
									<div class="msg-left msg">
								    	<p class="mb-0">
								    		<small><b>{{ $message->sender->name }}</b></small> <br>
								        	<small>{{ $message->message }}</small> <br>
								        	<small class="pull-right">
								        		{{ $message->created_at->diffForHumans() }}
								        	</small>
								    	</p>
								    </div>
									
								@endif

							@endforeach
						@else
							<span class="no-conversation-selected centered">Write your first message</span>
						@endif
	            	</div>
	            </div>
	        </div>

	        <div class="white-box">
				<div class="row">
					<div class="col-sm-12">
						<form action="{{ route('admin.message.view', ['id' => $conversation->id]) }}" method="POST" id = "compose-message-form">
							@csrf
							<div class="form-group">
								<textarea name="message" id="" cols="30" rows="5" class="form-control" required="" placeholder="Type message here"></textarea>
							</div>

							<input type="hidden" id="conversation_url" value="{{ route('admin.message.ajax', ['id' => $conversation->id]) }}">

							<button class="btn btn-success pull-right" type="submit">Send <i class="fa fa-send"></i></button>
						</form>	
					</div>
					
				</div>
			</div> 
	        
	    </div>

	    
	</div>


	

	
@endsection