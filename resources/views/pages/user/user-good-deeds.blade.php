@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $user->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('registered-members') }}">Registered Members</a></li>
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
				<h4>GOOD DEEDS ({{ $good_deeds->total() }})</h4>

				@if($good_deeds->total())
					@foreach($good_deeds as $deed)
						<div class="card">
							<div class="card-body">
								<h5>{{ $deed->name }}</h5>
								<p class="mb-0">
									{{ words($deed->description,50) }}
								</p>
								<p class="text-right text-muted mb-5">
									<small>
										{{ simple_datetime($deed->created_at) }}	
									</small> <br>

									
								</p>

								<p class="text-right mb-0">
									<a href="{{ route('good-deed.show', ['slug' => $deed->slug]) }}" class="btn btn-info">See more</a>
								</p>
							</div>
						</div>
					@endforeach

					{{ $good_deeds->links() }}
					
				@else
					<p class="text-muted">No good deeds</p>
				@endif
			</div>
		</div>
	</div>
		

		

@endsection