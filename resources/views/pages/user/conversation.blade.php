@extends('layouts.user-plain')

@section('content')
	<div class="container">
		<div class="row mt-50">
			<div class="col-sm-4">
				
					<div class="card">
						<div class="card-body h-400 overflow-y-scroll">
							@if(count($conversations))
								<b>Conversations({{ number_format(count($conversations)) }})</b> <br> <hr>
								
								@foreach($conversations as $conversation)
									<a href="{{ route('user.conversation', ['id' => $conversation->id]) }}" title="View Conversation">
										<div class="panel  {{ $conversation->id == $current_conversation->id ? 'panel-info' : 'panel-default' }}">
											<div class="panel-body">
												<div class="row">		
													@if($conversation->support)
														<div class="col-xs-3">
															<img src="{{ simba_coin() }}" alt="" class="img-responsive img-circle">
														</div>
														
														<div class="col-xs-9">
															<strong>Admin</strong> <br>
															<small class="text-muted">{{ $conversation->updated_at->diffForHumans() }}</small>
														</div>
													@else
														@if($conversation->from_id == $user->id)
															<div class="col-xs-3">
																<img src="{{ $conversation->to->thumbnail() }}" alt="" class="img-responsive img-circle">
															</div>
															<div class="col-xs-9">
																<strong>{{ $conversation->to->name }}</strong><br>
																<small class="text-muted">{{ $conversation->updated_at->diffForHumans() }}</small>
															</div>
														@else
															<div class="col-xs-3">
																<img src="{{ $conversation->from->thumbnail() }}" alt="" class="img-responsive img-circle">	
															</div>
															
															<div class="col-xs-9">
																<strong>{{ $conversation->from->name }}</strong> <br>
																<small class="text-muted">{{ $conversation->updated_at->diffForHumans() }}</small>
															</div>
														@endif
													@endif
												</div>
											</div>
										</div>
									</a>
								@endforeach
								
							@else
								<p class="text-center mb-0">
									No Conversations
								</p>
							@endif
						</div>
					</div>
				
			</div>

			<div class="col-sm-8">
				<div class="card">
					<div class="card-body" style="padding-bottom: 0px">
						<h5 class="mb-0">
							@if($support_message)
								<img src="{{ simba_coin() }}" alt="" class="size-35 mr-10 img-circle"> 
								<strong class="">Admin</strong>
							@else
								<a href="{{ route('user.show', ['username' => $to->username]) }}">
									<img src="{{ $to->thumbnail() }}" alt="" class="size-35 mr-10 img-circle"> {{ $to->name }}	
								</a>
								
							@endif
						</h5>

						<hr>	
					</div>
					
					<div class="card-body conversation-box h-306"  style="padding-top: 0px">
						<div id="messages" style="min-height: 100%" class="front-messages">
							@if(count($messages))
								@foreach($messages as $message)
									
									@if($message->from_admin)
										<div class="msg-left msg">
									        <p class="mb-0">
									        	<small><b>Admin</b></small> <br>
									        	<small>{{ $message->message }}</small> <br>
									        	<small class="pull-right text-muted">
									        		{{ $message->created_at->diffForHumans() }}
									        	</small>
									        </p>
									    </div>
									@else
										@if($message->from_id == $user->id)
											<div class="msg-right msg">
										    	<p class="mb-0">
										    		<small><b>Me</b></small> <br>
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
										        	<small class="text-muted">
										        		{{ $message->created_at->diffForHumans() }}
										        	</small>
										    	</p>

										    </div>
										@endif
									@endif

								@endforeach
							@else
								<span class="no-conversation-selected centered">Write your first message</span>
							@endif
						</div>
					</div>
				</div>



				<div class="card">
					<div class="card-body row">
						<div class="col-sm-12">
							<form action="{{ route('user.message.new', ['id' => $current_conversation->id]) }}" method="POST" id = "compose-message-form-">
								@csrf
								<div class="form-group">
									<textarea name="message" id="" cols="30" rows="5" class="form-control" required="" placeholder="Type message here"></textarea>
								</div>

								<input type="hidden" id="conversation_url" value="{{ route('user.conversation.ajax', ['id' => $current_conversation->id]) }}">

								<button class="btn btn-success pull-right" type="submit">Send <i class="fa fa-send"></i></button>
							</form>	
						</div>
						
					</div>
				</div>


			</div>


		</div>
	</div>
		

		

@endsection