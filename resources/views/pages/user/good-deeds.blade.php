@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }} ({{ number_format($deeds->total()) }})</h1>
			<span>Caring has the gift of making the ordinary special - <i>George R. Bach</i></span>
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
						<p class="">
							<a href="{{ route('report-a-good-deed') }}" class="button button-green button-3d"><i class="fa fa-smile-o"></i> REPORT A GOOD DEED</a>

							<a href="{{ route('posts') }}" class="button button-black  button-3d pull-right"><i class="fa fa-comment"></i> DISCUSSION FORUM</a>
						</p>

						<hr>
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

								<h5 class="nobottommargin">{{ $deed->name }}</h5>
								<p class="nobottommargin">{{ words($deed->description,30) }}</p>
								<p class="mb-10 text-right">
									<small>{{ simple_datetime($deed->created_at) }}</small>
								</p>

								<p class="nobottommargin text-right">
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