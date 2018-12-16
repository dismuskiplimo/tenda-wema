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
				<h4>
					REVIEWS ({{ number_format($reviews->total()) }})

					@if($logged_in)
						@if(!$me)
							@if(!$reviewed)
								<a href="" class="button button-black pull-right mtn-10" data-toggle="modal" data-target="#review-user-modal">REVIEW {{ $user->name }}</a>
							@else
								<button type="button" class="button button-black pull-right mtn-10" disabled="">YOU HAVE ALREADY REVIEWED THIS USER</button>
							@endif
							
						@endif
						
					@else
						<a href="" class="button button-black pull-right mtn-10" data-toggle="modal" data-target="#login-modal">LOG IN TO REVIEW</a>
					@endif
				</h4>

				@if($reviews->total())
					@foreach($reviews as $review)
						<div class="card">
							<div class="card-body">
								<h5>
									<a href="{{ route('user.show', ['username' => $review->user ? $review->user->username : '']) }}">
										<img src="{{ $review->user ? $review->user->profile_thumbnail() : '' }}" class="img-circle size-40 mr-10" alt=""> {{ $review->user ? $review->user->name : '' }}
									</a>

									@for($count = 0; $count < $review->rating; $count++ )
										<i class="fa fa-star text-warning"></i>
									@endfor

									<small class="text-muted">{{ simple_datetime($review->created_at) }}</small>
									
								</h5>

								
								{!! clean(nl2br($review->message)) !!}

								

								
							</div>
						</div>
					@endforeach

					{{ $reviews->links() }}
				@else
					No reviews yet
				@endif
			</div>
		</div>
	</div>
		

@if(!$reviewed)
	@include('pages.user.modals.review-user')
@endif

@if(!$logged_in)
	@include('pages.user.modals.login')
@endif
		

@endsection