@extends('layouts.user')

@section('content')
	<!-- Page Title
	============================================= -->
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $item->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('community-shop') }}">Community Shop</a></li>
				<li class="active">{{ $item->name }}</li>
			</ol>
		</div>

	</section><!-- #page-title end -->

	<div class="container">
		<div class="row content-wrap">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-body">
						@if($item->images->count())
							<div id="item-carousel" class="carousel slide" data-ride="carousel">
								<!-- Indicators -->
								<ol class="carousel-indicators">
									

									@for($cnt = 0; $cnt < count($item->images); $cnt++)
										
										<li data-target="#item-carousel" data-slide-to="{{ $cnt }}" class="{{ $cnt == 0 ? 'active' : '' }}"></li>
										
									@endfor
									
									
								</ol>

								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									@php
										$cnt = 0;
									@endphp

									@foreach($item->images()->orderBy('created_at', 'DESC')->get() as $image)
										<div class="item{{ $cnt == 0 ? ' active' : '' }}">
											<img src="{{ $image->slide() }}" alt="{{ $item->name }}">
										</div>

										@php
											$cnt++;
										@endphp
									@endforeach

								</div>

								<!-- Controls -->
								<a class="left carousel-control" href="#item-carousel" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left fa fa-arrow-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								
								<a class="right carousel-control" href="#item-carousel" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right fa fa-arrow-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						@else
							<img src="{{ item_slide() }}" alt="" class="img-responsive">
						@endif

						<br>

						<h4 class="nobottommargin">Description</h4>

						<p class="nobottommargin">{!! clean($item->description) !!}</p>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<h4 class="nobottommargin">
									Item Review

									@if($logged_in && $item->buyer_id == $user->id && $item->bought && $item->received && $item->approved)
										@if(!$review)
											<a href="" data-toggle="modal" data-target="#review-item-modal" class="btn btn-success btn-xs nobottommargin pull-right"><i class="fa fa-star"></i> REVIEW ITEM</a>

											@include('pages.user.modals.review-item')
										@else
											<a href="" data-toggle="modal" data-target="#edit-review-item-modal-{{ $review->id }}" class="btn btn-warning btn-xs nobottommargin pull-right"><i class="fa fa-edit"></i> EDIT REVIEW</a>

											@include('pages.user.modals.edit-review-item')
										@endif
									@endif
									

									
								</h4>

								<hr class="mt-5 mb-5">
	
							</div>
						</div>
						

						@if($review)
							<div>
								<p class="nobottommargin">
									
									<strong>
										<a href="{{ route('user.show', ['username' => $review->user->username]) }}">
											<img src="{{ $review->user->thumbnail() }}" alt="" class="size-20 mtn-4">

											{{ $review->user->name }}
										</a>,  
									</strong>

									

									<small class="text-muted">{{ simple_datetime($review->created_at) }}</small> 
									
									@for($i = 0; $i < $review->rating; $i++)
										<i class="fa fa-star text-warning"></i>
									@endfor

									<br>

									
								</p>

								<p class="nobottommargin mt-10">
									{{ $review->message }}
								</p>	
							</div>
						@else
							<p class="nobottommargin">Item not reviewed yet</p>
						@endif
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				@if($logged_in && $item->buyer_id == $user->id)
					@if($item->bought && !$item->disapproved && !$item->received)
						<div class="row">

							<div class="col-sm-12 mb-20">
								<p class="nobottommargin">
									@if($item->approved)

										<a href="" data-toggle="modal" data-target="#confirm-item-received-{{ $item->id }}" class="btn btn-block btn-success mb-20">
											ITEM RECEIVED ?
										</a>

									@endif

									@if(!$user->order_cancellations()->where('approved', 0)->where('dismissed', 0)->where('donated_item_id', $item->id)->first())
										<a href="" data-toggle="modal" data-target="#cancel-purchase-{{ $item->id }}" class="btn btn-block btn-default">
											CANCEL PURCHASE
										</a>
									@endif
									
									
								</p>
									
								@include('pages.user.modals.confirm-item-received')
								@include('pages.user.modals.cancel-purchase')	
							</div>
							
						</div>
					@endif
					
				@endif

				<div class="card">
					<div class="card-body">
						<h3> <img src="{{ simba_coin() }}" alt="" class="size-30"> {{ number_format($item->price) }} <small>Simba Coins</small></h3>
						<h4 class="mb-0 mtn-25">{{ $item->name }}</h4>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<h5 class="">Donor info</h5>



						<div class="row">
							<div class="col-xs-3">
								<img src="{{ $item->donor ? $item->donor->profile_thumbnail() : profile_thumbnail() }}" alt="{{ $item->donor ? $item->donor->name : '' }}" class="img-responsive img-circle">
							</div>

							<div class="col-xs-9">
								<p class="mt-10 mb-0">
									{{ $item->donor ? characters($item->donor->name, 30) : '' }} <br>
									<a href="{{ route('user.show', ['username' => $item->donor->username]) }}">View Profile</a>
								</p>
							</div>	
						</div>
						
					</div>
				</div>

				@if($mine)
					@if($item->bought)
						<div class="card">
							<div class="card-body">
								<h5 class="">Buyer info</h5>

								

								<div class="row">
									<div class="col-xs-3">
										<img src="{{ $item->buyer ? $item->buyer->profile_thumbnail() : profile_thumbnail() }}" alt="{{ $item->buyer ? $item->buyer->name : '' }}" class="img-responsive img-circle">
									</div>

									<div class="col-xs-9">
										<p class="mt-10 mb-0">
											{{ $item->buyer ? characters($item->buyer->name, 30) : '' }} <br>
											<a href="{{ route('user.show', ['username' => $item->buyer->username]) }}">View Profile</a>
										</p>
									</div>	
								</div>
								
							</div>
						</div>
					@endif
				@endif

				<div class="card">
					<div class="card-body">
						<h5>Donated Item Details</h5>
						<table class="" style="width:100%">
							<tr>
								<th>Posted</th>
								<td>{{ simple_datetime($item->created_at) }}</td>
							</tr>

							<tr>
								<th>Category</th>
								<td>{{ $item->category->name }}</td>
							</tr>

							<tr>
								<th>Condition</th>
								<td>{{ ucfirst(strtolower($item->condition)) }}</td>
							</tr>
						</table> 
						
						@if(auth()->check())
							<br>

							@if(!$item->bought && !$mine)
								<a href="" data-toggle = "modal" data-target = "#report-item" class="btn btn-danger"> <i class="fa fa-bullhorn"></i> Report Item</a>
							@endif
						@else
							
						@endif
						
						
					</div>
				</div>
				
				<div class="">
					@if(!$item->bought && $item->approved)
						@if(auth()->check())
							@if(!$mine)
								@if($item->price > $user->coins)
									@if($coin_request)
										<a href="#" class="btn btn-primary btn-block">
											COIN PURCHASE REQUESTED,  <br> PLEASE WAIT FOR FEEDBACK FROM ADMIN
										</a>
									@else
										<a href="" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#purchase-coins">
											<img src="{{ simba_coin() }}" alt="" class="size-30"> 
											PURCHASE EXTRA COINS
										</a>
									@endif
								@else
									@if($item->disputed)
										<button class="btn btn-disabled btn-block btn-lg" disabled="">DISPUTED</button>
									@else
										<a href="" data-toggle="modal" data-target="#purchase-item-{{ $item->id }}" class="btn btn-primary btn-block btn-lg">PURCHASE</a>

										@include('pages.user.modals.purchase-item')
									@endif


								@endif
							@else
								@if(!$item->disputed)
									{{-- <div class="btn-group btn-group-justified">
										<a href="" data-toggle="modal" data-target="#edit-donated-item-{{ $item->id }}" class="btn btn-info"><i class="fa fa-edit"></i> EDIT</a>

										<a href="" data-toggle="modal" data-target="#delete-donated-item-{{ $item->id }}" class="btn btn-danger"><i class="fa fa-trash"></i> REMOVE FROM SHOP</a>
									</div> <br>

									<div class="btn-group btn-group-justified">
										<a href="" data-toggle="modal" data-target="#add-donated-item-image" class="btn btn-success"><i class="fa fa-plus"></i> ADD IMAGE</a>

										<a href="" data-toggle="modal" data-target="#delete-donated-item-image" class="btn btn-warning"><i class="fa fa-trash"></i> DELETE IMAGE</a>
									</div>
									

									@include('pages.user.modals.edit-donated-item')
									@include('pages.user.modals.delete-donated-item')
									@include('pages.user.modals.add-donated-item-image')
									@include('pages.user.modals.delete-donated-item-image') --}}
								@else
									<button class="btn btn-disabled btn-block btn-lg" disabled="">DISPUTED</button>
								@endif
								
							@endif
							
						@else
							<a href="" data-toggle="modal" data-target = "#login-modal" class="btn btn-info btn-block btn-lg">LOG IN TO PURCHASE</a>

							@include('pages.user.modals.login')
						@endif
					@elseif($item->bought && $item->approved)
						@if($item->disputed)
							<button class="btn btn-disabled btn-block btn-lg" disabled="">DISPUTED</button>
						@else
							@if(auth()->check() && $item->buyer_id == $user->id)
								<button class="btn btn-disabled btn-block btn-lg" disabled="">PURCHASED BY ME</button>
							@elseif($item->approved)
							
								<button class="btn btn-disabled btn-block btn-lg" disabled="">SOLD</button>

							@endif
						@endif

					@elseif(!$item->bought && !$item->approved && !$item->dismissed)
						<button class="btn btn-disabled btn-block btn-lg" disabled="">PENDING APPROVAL BY ADMIN</button>
					@elseif(!$item->bought && !$item->approved && $item->dismissed)
						<button class="btn btn-disabled btn-block btn-lg" disabled="">REJECTED BY ADMIN</button>
					@endif

				</div>
				
				
			</div>
		</div>
	</div>
		

@if(!auth()->check())
	@include('pages.user.modals.login')
@else
	@include('pages.user.modals.buy-coins')

	@if(!$item->bought && !$mine)
		@include('pages.user.modals.report-item')
	@endif
@endif

@endsection