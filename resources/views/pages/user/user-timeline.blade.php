@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $user->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li>Users</li>
				<li class="active">{{ $user->name }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row my-50">
			<div class="col-sm-3">
				@include('includes.user.profile-sidebar')
			</div>

			<div class="col-sm-9">
				<h4>TIMELINE</h4>
				@if($timeline->total())
					@foreach($timeline as $event)
						<div class="card">
							<div class="card-body">
								@if($event->type == 'user.register')
									<strong>{{ $event->message }}</strong>
								@elseif($event->type == 'item.donated')
									<div class="row">
										@php
											$item = $event->donated_item;

											$thumbnail = item_thumbnail();

											if($item->images){
												$donated_item_image = $item->images()->first();

												if($donated_item_image){
													$thumbnail 		= $donated_item_image->thumbnail();
												}
									
											}
										@endphp

										<div class="col-sm-4">
											<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">
												<img src="{{ $thumbnail }}" alt="{{ $item->name }}" class="img-responsive">	
											</a>	
											
										</div>

										<div class="col-sm-8">
											<h4>Donated Item</h4>
											<h5 class="mt-10 mb-0">
												<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">{{characters($item->name, 20)}}</a>	
											</h5>

											<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
										</div>
									</div>
								@elseif($event->type == 'social_level.upgraded')
									<p>
										<img src="{{ social_badge($event->extra) }}" alt="{{ $event->extra }} badge" class="size-20 mr-10p">
										{{ $event->message }}
									</p>
								@endif

								<p class="text-right mb-0">
									<small class="text-muted">
										{{ simple_datetime($event->created_at) }}
									</small>
								</p>

								
							</div>
						</div>
					@endforeach

					{{ $timeline->links() }}
				@else
					<p class="text-muted">No activity</p>
				@endif
			</div>
		</div>
	</div>
		

		

@endsection