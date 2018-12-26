@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }} ({{ number_format($users->total()) }})</h1>
			<span>Members registered with {{ config('app.name') }}</span>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1">
				@if($users->total())
					@foreach($users as $user)
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div style="width:50px; float: left">
											<a href="{{ route('user.show', ['username' => $user->username]) }}">
												<img class="size-50" src="{{ $user->thumbnail() }}" alt="{{ $user->name }}">
											</a>
											
										</div>

										<div style="width:calc(100% - 70px); float: left; padding-left: 20px;">
											<a href="{{ route('user.show', ['username' => $user->username]) }}">
												<h4>{{ $user->name }}, {!! $user->stars() !!}</h4>
											</a>
											<p class="nobottommargin">{{ characters($user->about_me,200) }}</p>
										</div>		
									</div>
								</div>
								
							</div>
						</div>
					@endforeach

					{{ $users->links() }}
				@else
					<p class="nobottommargin">No registered members</p>
				@endif

				
			</div>
		</div>
	</div>
		

		

@endsection