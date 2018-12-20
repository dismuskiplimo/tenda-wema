@extends('layouts.user')

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
			<div class="col-sm-10 col-sm-offset-1 py-50">
				@if($notifications->total())
					@foreach($notifications as $notification)
						<div class="panel {{ $notification->read ? '' : 'panel-primary' }} mb-20">
							<a href="{{ route('user.notification', ['id' => $notification->id]) }}">
								<div class="panel-body">
									<p class="nobottommargin">
										{{ $notification->message }} <br>
										<small class="pull-right">{{ simple_datetime($notification->created_at) }}</small>
									</p>
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