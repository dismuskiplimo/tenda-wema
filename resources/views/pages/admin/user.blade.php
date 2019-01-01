@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">
	            	{{ $title }}, 

					@if(!$user->is_admin())
						@if($stars)
							@for($i = 0; $i < $stars; $i++)
								<i class="fa fa-star text-warning"></i>
							@endfor

							<small><i>(Rated by {{ number_format($user->reviews) }} Users)</i></small>
						@else
							<small class="text-muted"><i>User not reviewed yet</i></small>
						@endif
					@endif
	            </h3>

	            @if(!$user->closed && !$me)
		            <p class="text-right mb-0">
		          		@if($user->has_pending_moderator_request())
							<a href="" data-toggle = "modal" data-target = "#approve-moderator-request-{{ $moderator_request->id }}" class="btn btn-success btn-xs">
								<i class="fa fa-check"></i> APPROVE TO BE A MODERATOR
							</a> | 

							<a href="" data-toggle = "modal" data-target = "#dismiss-moderator-request-{{ $moderator_request->id }}" class="btn btn-danger btn-xs">
								<i class="fa fa-times"></i> DISMISS REQUEST TO BE MODERATOR
							</a> | 

						@endif

		          		@if(!$user->verified)
							<a href="" data-toggle="modal" data-target="#verify-user-{{ $user->id }}" class="btn btn-xs btn-success">
			          			<i class="fa fa-certificate"></i> Verify User
			          		</a>
		          		@endif

		          		<a href="" data-toggle="modal" data-target="#close-account-{{ $user->id }}" class="btn btn-xs btn-danger">
		          			<i class="fa fa-times"></i> Close Account
		          		</a>
		            </p>

		            @include('pages.admin.modals.close-account')

		            @if(!$user->verified && !$me)
						@include('pages.admin.modals.verify-user')
	          		@endif
	            @endif

	            <hr>

	            <div class="row">
	            	<div class="col-sm-3 text-center">
	            		<img src="{{ $user->image() }}" alt="" class="size-150 mb-50">

	            		<p><strong>{{ $user->name }}</strong></p>

						<p>
		            		@if(!$user->is_admin())
								@if($stars)
									@for($i = 0; $i < $stars; $i++)
										<i class="fa fa-star text-warning"></i>
									@endfor

									<br><small><i>(Rated by {{ number_format($user->reviews) }} Users)</i></small>
								@else
									<small class="text-muted"><i>User not reviewed yet</i></small>
								@endif
							@endif

						</p>

						<img src="{{ $user->badge() }}" alt="" class="size-100 mt-20">

						<p>{{ $user->social_level }}</p>


	            	</div>

	            	<div class="col-sm-9">
	            		<table class="table table-condensed table-striped">
	            			<tr>
	            				<th>Name</th>
	            				<td>{{ $user->name }}</td>
	            			</tr>

	            			<tr>
	            				<th>Username</th>
	            				<td>{{ $user->username }}</td>
	            			</tr>

	            			<tr>
	            				<th>Email</th>
	            				<td>{{ $user->email }}</td>
	            			</tr>
							
							<tr>
	            				<th>Social Level</th>
	            				<td>{{ $user->social_level }}</td>
	            			</tr>

	            			<tr>
	            				<th>Social Level Attained At</th>
	            				<td>{{ simple_datetime($user->social_level_attained_at) }}</td>
	            			</tr>
	            			
	            			<tr>
	            				<th>Usertype</th>
	            				<td>{{ $user->usertype }}</td>
	            			</tr>

	            			<tr>
	            				<th>Moderator</th>
	            				<td>{!! $user->moderator ? '<span class = "text-success">YES</span>' : '<span class ="text-danger">NO</span>' !!}</td>
	            			</tr>

	            			<tr>
	            				<th>Date of Birth</th>
	            				<td>{{ simple_date($user->dob) }}</td>
	            			</tr>

	            			<tr>
	            				<th>Last Seen</th>
	            				<td>{{ simple_datetime($user->last_seen) }}</td>
	            			</tr>

	            			<tr>
	            				<th>Account Closed</th>
	            				<td>{!! $user->closed ? '<span class = "text-danger">YES</span>' : '<span class ="text-success">NO</span>' !!}</td>
	            			</tr>

	            			<tr>
	            				<th>User Verified</th>
	            				<td>{!! $user->verified ? '<span class ="text-success">YES</span>' : '<span class ="text-danger">NO</span>' !!}</td>
	            			</tr>

	            			<tr>
	            				<th>Account Suspended</th>
	            				<td>{!! $user->suspended ? '<span class ="text-danger">YES</span>' : '<span class ="text-success">NO</span>' !!}</td>
	            			</tr>

	            			

	            			<tr>
	            				<th>About User</th>
	            				<td>{!! clean($user->about_me) !!}</td>
	            			</tr>

	            			<tr>
	            				<th>Email Verified</th>
	            				<td>{!! $user->email_verified ? '<span class ="text-success">YES</span>' : '<span class ="text-danger">NO</span>' !!}</td>
	            			</tr>

	            			<tr>
	            				<th>Simba Coins Balance</th>
	            				<td>{{ number_format($user->coins) }}</td>
	            			</tr>

	            			<tr>
	            				<th>Accomulated Simba Coins</th>
	            				<td>{{ number_format($user->accumulated_coins) }}</td>
	            			</tr>

	            			

	            			
	            		</table>
	            	</div>
	            </div>  
	        </div> 

	        @if(!$user->is_admin())
				{{-- Photos --}}
				<div class="white-box">
		        	@php
		        		$photos_count = $user->photos()->count();
		        	@endphp

		        	<h3 class="box-title">Photos ({{ number_format($photos_count) }})</h3>
					
					@if($photos_count)
						<div class="row">
							

							@foreach($user->photos()->orderBy('created_at', 'DESC')->limit(6)->get() as $photo)
							
								<div class="col-sm-4 mb-20">
									<div class="thumbnail">
										<a data-fancybox="gallery" href="{{ $photo->photo() }}">
											<img src="{{ $photo->thumbnail() }}" alt="" class="img-responsive">
										</a>
									</div>
									
								</div>

								

							@endforeach
							
							<div class="col-sm-12">
								<hr>
								<p class="text-right">
									<a href="{{ route('admin.user.photos', ['id' => $user->id]) }}">See all photos for {{ $user->name }}</a>
								</p>	
							</div>

							
						</div>

						
					@else
						<i>No photos</i>
					@endif
		        </div>

				{{-- Reviews --}}
				<div class="white-box">
		        	@php
		        		$review_count = $user->reviews()->count();
		        	@endphp

		        	<h3 class="box-title">User Reviews ({{ number_format($review_count) }})</h3>
					
					@if($review_count)
						<div class="row">
							

							@foreach($user->reviews()->orderBy('created_at', 'DESC')->limit(6)->get() as $review)
							
								<div class="col-sm-12">
									<p>
										<a href="{{ route('admin.user', ['id' => $review->rater->id]) }}"><strong>{{ $review->rater->name }}</strong></a>, 
										
										@for($i = 0; $i < $review->rating; $i++)
											<i class="fa fa-star text-warning"></i>
										@endfor
										, <small class="text-muted">{{ simple_datetime($review->created_at) }}</small>
																				
									</p>

									<p>{{ $review->message }}</p>

									<hr>
								</div>

								

							@endforeach
							
							<div class="col-sm-12">
								
								<p class="text-right">
									<a href="{{ route('admin.user.reviews', ['id' => $user->id]) }}">See all reviews for {{ $user->name }}</a>
								</p>	
							</div>

							
						</div>

						
					@else
						<i>No reviews</i>
					@endif
		        </div>
				
		        {{-- Donated Items --}}
		        <div class="white-box">
		        	<h3 class="box-title">Items Donated by {{ $user->name }} ({{ number_format(count($user->donated_items)) }})</h3>
					
					@if(count($user->donated_items))
						<div class="row">
							@foreach($user->donated_items()->orderBy('created_at', 'DESC')->limit(6)->get() as $item)
							
								@php
									$banner = item_banner();

									if($item->images){
										$donated_item_image = $item->images()->first();

										if($donated_item_image){
											$banner 		= $donated_item_image->banner();
										}
										
									}
								@endphp

								<div class="col-sm-4 mb-20">
									<div class="">
										<div class="">
											<div class="row">
												<div class="col-sm-4">
													<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">
														<img src="{{ $banner }}" alt="{{ $item->name }}" class="img-responsive">
													</a>
												</div>

												<div class="col-sm-8">
													<h4 class="mt-10">
														<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">{{characters($item->name, 20)}}</a>	
													</h4>

													<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
												</div>
											</div>
											

											
										</div>
									</div>
								</div>

							@endforeach
							
							<div class="col-sm-12">
								<hr>
								<p class="text-right">
									<a href="{{ route('admin.user.donated-items', ['id' => $user->id]) }}">See all items donated by {{ $user->name }}</a>
								</p>	
							</div>

							
						</div>

						
					@else
						<i>No items donated</i>
					@endif
		        </div>

		        {{-- Bought Items --}}
		        <div class="white-box">
		        	<h3 class="box-title">Items Bought by {{ $user->name }} ({{ number_format(count($user->bought_items)) }})</h3>
					
					@if(count($user->bought_items))
						<div class="row">
							@foreach($user->bought_items()->orderBy('created_at', 'DESC')->limit(6)->get() as $item)
							
								@php
									$banner = item_banner();

									if($item->images){
										$donated_item_image = $item->images()->first();

										if($donated_item_image){
											$banner 		= $donated_item_image->banner();
										}
										
									}
								@endphp

								<div class="col-sm-4 mb-20">
									<div class="">
										<div class="">
											<div class="row">
												<div class="col-sm-4">
													<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">
														<img src="{{ $banner }}" alt="{{ $item->name }}" class="img-responsive">
													</a>
												</div>

												<div class="col-sm-8">
													<h4 class="mt-10">
														<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">{{characters($item->name, 20)}}</a>	
													</h4>

													<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
												</div>
											</div>
											

											
										</div>
									</div>
								</div>

							@endforeach
							
							<div class="col-sm-12">
								<hr>
								<p class="text-right">
									<a href="{{ route('admin.user.bought-items', ['id' => $user->id]) }}">See all items bought by {{ $user->name }}</a>
								</p>	
							</div>

							
						</div>

						
					@else
						<i>No items bought</i>
					@endif
		        </div>

		        {{-- Good Deeds --}}
		        <div class="white-box">
		        	<h3 class="box-title">Good Deeds by {{ $user->name }} ({{ number_format(count($user->good_deeds)) }})</h3>
					
					@if(count($user->good_deeds))
						<div class="row">
							@foreach($user->good_deeds()->where('approved', 1)->orderBy('created_at', 'DESC')->limit(6)->get() as $deed)
							
								<div class="col-sm-12 mb-20">
									<p>
										Deed : <strong>{{ $deed->name }}</strong> <br>
										Location : {{ $deed->location }} <br>
										Peformed at : {{ simple_datetime($deed->peformed_at) }} <br>
										Description : {{ $deed->description }} <br>	
										Contacts : {{ $deed->contacts }}	
									</p>
									
								</div>

								<hr>

							@endforeach
							
							<div class="col-sm-12">
								<hr>
								<p class="text-right">
									<a href="{{ route('admin.user.good-deeds', ['id' => $user->id]) }}">See all good deeds by {{ $user->name }}</a>
								</p>	
							</div>

							
						</div>
						
					@else
						<i>No good deeds reported</i>
					@endif
		        </div>

		        {{-- Simba Coin Log --}}
		        <div class="white-box">
		        	<h3 class="box-title">Simba Coin Log ({{ number_format(count($user->simba_coin_logs)) }})</h3>
					
					@if(count($user->simba_coin_logs))
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Simba Coins</th>
											<th>Message</th>
											<th>Previous Balance</th>
											<th>New Balance</th>
											
											
										</tr>
									</thead>

									<tbody>
										@foreach($user->simba_coin_logs()->orderBy('created_at', 'DESC')->limit(25)->get() as $log)
											
											<tr>
												<td>{{ simple_datetime($log->created_at) }}</td>
												<td>
													@php
														if($log->type == 'credit'){
															$class = 'text-success';	
														}else{
															$class = 'text-danger';
														}
													@endphp

													<span class="{{ $class }}">
														{{ $log->type == 'credit' ? '+' : '-' }} {{ number_format($log->coins) }}
													</span>
												</td>
												<td>{{ $log->message }}</td>
												
												<td>{{ $log->previous_balance }}</td>
												<td>{{ $log->current_balance }}</td>
												
											</tr>

										@endforeach
									</tbody>
								</table>
								
								
								<div class="col-sm-12">
									<hr>
									<p class="text-right">
										<a href="{{ route('admin.user.simba-coin-logs', ['id' => $user->id]) }}">See whole simba coin log</a>
									</p>	
								</div>
							</div>

							
						</div>
						
					@else
						<i>No simba coin logs</i>
					@endif
		        </div>

		        {{-- Transactions --}}
		        <div class="white-box">
		        	<h3 class="box-title">Transactions ({{ number_format(count($user->transactions)) }})</h3>
					
					@if(count($user->transactions))
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Transaction Code</th>
											<th>Amount</th>
											<th>Coins</th>
											<th>Medium</th>
											<th>Status</th>
											
										</tr>
									</thead>

									<tbody>
										@foreach($user->transactions()->orderBy('created_at', 'DESC')->limit(25)->get() as $transaction)
											
											<tr>
												<td>{{ simple_datetime($transaction->created_at) }}</td>
												<td>{{ $transaction->transaction_code }}</td>
												<td>{{ $transaction->currency }} {{ number_format($transaction->amount) }}</td>
												<td>{{ number_format($transaction->coins) }} Simba Coins</td>
												<td>{{ $transaction->medium }}</td>
												<td>{{ $transaction->status }}</td>
												
											</tr>

										@endforeach
									</tbody>
								</table>
								
								
								<div class="col-sm-12">
									<hr>
									<p class="text-right">
										<a href="{{ route('admin.user.transactions', ['id' => $user->id]) }}">See all transactions by {{ $user->name }}</a>
									</p>	
								</div>
							</div>

							
						</div>
						
					@else
						<i>No transactions</i>
					@endif
		        </div>

	        @endif
	        
	    </div>

	    
	</div>

	@if($user->has_pending_moderator_request())
		@include('pages.admin.modals.approve-moderator-request')

		@include('pages.admin.modals.dismiss-moderator-request')
	@endif


	

	
@endsection