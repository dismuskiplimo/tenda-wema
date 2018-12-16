@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }} ({{ number_format($deeds->total()) }})</h1>
			<span>Good Deeds</span>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 py-50">
				<div class="row">
					<div class="col-sm-12">
						<p class="text-right">
							<a href="{{ route('report-a-good-deed') }}" class="btn btn-info"><i class="fa fa-smile-o"></i> REPORT A GOOD DEED</a>
						</p>
					</div>
				</div>
				@if($deeds->total())
					@foreach($deeds as $deed)
						<div class="card">
							<div class="card-body">
								<h4 class="mb-10">
									
									<a href="{{ route('user.show', ['username' => $deed->user ? $deed->user->username : '']) }}">
										<img src="{{ $deed->user ? $deed->user->thumbnail() : '' }}" alt="{{ $deed->user ? $deed->user->thumbnail() : '' }}" class="size-30 mr-10 img-circle">
										{{ $deed->user->name }}
									</a>
								</h4>

								<h5 class="mb-0">{{ $deed->name }}</h5>
								<p class="mb-0">{{ words($deed->description,30) }}</p>
								<p class="mb-10 text-right">
									<small>{{ simple_datetime($deed->created_at) }}</small>
								</p>

								<p class="mb-0 text-right">
									<a href="{{ route('good-deed.show', ['slug' => $deed->slug]) }}" class="btn btn-sm btn-info">See More</a>
								</p>
								
							</div>
						</div>
					@endforeach

					{{ $deeds->links() }}
				@else
					<h3 class="text-center">No Good Deeds Reported</h3>
				@endif
				
			</div>
		</div>
	</div>
		

@endsection