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
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row">		
													@if($conversation->from_admin)
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
					<div class="card">
						<div class="card-body conversation-box h-400">
							<span class="no-conversation-selected centered">Please select a conversation to view</span>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
		

		

@endsection