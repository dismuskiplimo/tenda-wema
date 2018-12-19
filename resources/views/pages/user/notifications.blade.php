@extends('layouts.user-plain')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li>Account</li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 mt-50">
				@if($notifications->total())
					@foreach($notifications as $notification)
						<div class="panel mb-20">
							<a href="">
								<div class="panel-body">
									<p class="mb-0">{{ $notification->message }}</p>
								</div>	
							</a>
						</div>
					@endforeach
				@else
					<p class="text-center">No Notifications</p>
				@endif	
			</div>
		</div>
	</div>
		

		

@endsection