@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="">
	            <div class="row">
	            	<div class="col-sm-8">
	            		<div class="white-box">

	            			<h3 class="box-title">{{ $title }}</h3>
				            <p class="text-right">
				            	@if($donated_item->bought)
				            		@if(!$donated_item->approved)
										<a href="" data-toggle="modal" data-target="#purchase-approve-{{ $donated_item->id }}" class="btn btn-xs btn-success"><i class="fa fa-check"></i> APPROVE PURCHASE</a>	
										<a href="" data-toggle="modal" data-target="#purchase-disapprove-{{ $donated_item->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> DISAPPROVE PURCHASE</a>	

										<div class="text-left">
											@include('pages.admin.modals.approve-purchase')
											@include('pages.admin.modals.disapprove-purchase')
										</div>
				            		@else
										
										
										@if(!$donated_item->received)
											<a href="" data-toggle="modal" data-target="#item-receive-{{ $donated_item->id }}" class="btn btn-xs btn-success"><i class="fa fa-check"></i> MARK AS RECEIVED</a>
											
											
											
										@endif

										@if(!$donated_item->disputed)
											<a href="" data-toggle="modal" data-target="#item-dispute-{{ $donated_item->id }}" class="btn btn-xs btn-warning"><i class="fa fa-bullhorn"></i> DISPUTE</a>

											
											
										@endif

										<div class="text-left">
											@include('pages.admin.modals.receive-item')
											@include('pages.admin.modals.dispute-item')
										</div>
										
									@endif						
				            	@else
									@if(!$donated_item->deleted_at)
										<a href="" data-toggle="modal" data-target="#item-remove-form-market-{{ $donated_item->id }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> REMOVE FROM MARKET</a>

										<div class="text-left">
											@include('pages.admin.modals.remove-item-from-market')
										</div>
									@endif
									
				            	@endif
				            </p>

            				<hr>
							
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

							<h4>Description</h4>

							<p class="">{!! nl2br(clean($item->description)) !!}</p>
							
						</div>
	            	</div>

	            	<div class="col-sm-4">
	            		<div class="white-box">
							<h4 class="box-title">
								Status
							</h4>

							<h3>{{ $item->status() }}</h3>
						</div>

	            		<div class="white-box">
							<div class="">
								<h3> <img src="{{ simba_coin() }}" alt="" class="size-30"> {{ $item->price }} <small>Simba Coins</small></h3>
								<h4>{{ $item->name }}</h4>
							</div>
						</div>

						<div class="white-box">
							<div class="box-title">SELLER</div>
							<hr>

							<div class="">
								

								<div class="row">
									<div class="col-sm-3">
										<img src="{{ $item->donor ? $item->donor->profile_thumbnail() : profile_thumbnail() }}" alt="{{ $item->donor ? $item->donor->name : '' }}" class="img-responsive img-circle">
									</div>

									<div class="col-sm-9">
										<p class="mt-10 mb-0">
											{{ $item->donor ? characters($item->donor->name, 30) : '' }} <br>
											<a href="{{ route('admin.user', ['id' => $item->donor->id]) }}">View Profile</a>
										</p>
									</div>	
								</div>
								
							</div>
						</div>

						@if($item->bought)
							<div class="white-box">
								<div class="box-title">BUYER</div>
								<hr>

								<div class="">
									

									<div class="row">
										<div class="col-sm-3">
											<img src="{{ $item->buyer ? $item->buyer->profile_thumbnail() : profile_thumbnail() }}" alt="{{ $item->buyer ? $item->buyer->name : '' }}" class="img-responsive img-circle">
										</div>

										<div class="col-sm-9">
											<p class="mt-10 mb-0">
												{{ $item->buyer ? characters($item->buyer->name, 30) : '' }} <br>
												<a href="{{ route('admin.user', ['id' => $item->buyer->id]) }}">View Profile</a>
											</p>
										</div>	
									</div>
									
								</div>
							</div>
						@endif

						<div class="white-box">
							<div class="box-title">Donated Item Details</div>
							<div class="">
								
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
								
								
							</div>
						</div>

						<a href="{{ route('admin.message.new', ['id' => $item->donor->id]) }}" class="btn btn-block btn-info btn-lg mb-10" target="_blank">
							<i class="fa fa-send"></i> MESSAGE SELLER
						</a>

						@if($item->bought)

							<a href="{{ route('admin.message.new', ['id' => $item->buyer->id]) }}" class="btn btn-block btn-primary btn-lg" target="_blank">
								<i class="fa fa-send"></i> MESSAGE BUYER
							</a>

						@endif


	            	</div>
	            </div>
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection