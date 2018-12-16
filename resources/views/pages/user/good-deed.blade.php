@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $deed->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('good-deeds') }}">Good Deeds</a></li>
				<li class="active">{{ $deed->name }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 py-50">
				<div class="card">
					<div class="card-body">

						<div class="row">
							<div class="col-sm-6">
								<h4 class="mb-5 text-muted">GOOD DEED </h4> 
								<h4> {{ $deed->name }} <br> 
									
									<small class="text-muted">{{ simple_datetime($deed->created_at) }}</small>
								</h4>

								<h4 class="mb-0 text-muted">LOCATION</h4>
								<p>{{ $deed->location }}</p>

								<h4 class="mb-0 text-muted">DESCRIPTION</h4>
								{!! clean(nl2br($deed->description)) !!}
								
								@if($mine)
									<h4 class="mb-0 text-muted">CONTACTS</h4>
									{!! clean(nl2br($deed->contacts)) !!}
								@endif
							</div>

							<div class="col-sm-6">
								@php
									if($deed->disapproved){
										$color = 'red';
										$text = 'NOT APPROVED';
									}else{
										$color = $deed->approved ? 'green' : 'orange';
										$text = $deed->approved ? 'APPROVED' : 'PENDING APPROVAL';
									}
									

									

								@endphp

								<h4 class="mb-10">DONE BY <span class="pull-right" style ="color:{{ $color }}">{{ $text }}</span> </h4>
								<p>
									<a href="{{ route('user.show', ['username' => $deed->user ? $deed->user->username : '']) }}">
										<img src="{{ $deed->user ? $deed->user->profile_thumbnail() : '' }}" alt="{{ $deed->user ? $deed->user->name : '' }}" class="size-30 mr-10 img-circle"> 

										<i class="mt-10">
											{{ $deed->user ? $deed->user->name : '' }}	
										</i>
										
									</a>
								</p>
								
								<h4 class="mb-5">EVIDENCE ({{ count($deed->images) }})</h4>
								@if(count($deed->images))
									<div class="row">
										@php
											$count = 0;
										@endphp

										@foreach($deed->images()->orderBy('created_at', 'DESC')->get() as $image)
											@php
												$count++;
											@endphp
											<div class="col-sm-4">
												<a data-fancybox="gallery" href="{{ $image->image() }}">
													<img src="{{ $image->thumbnail() }}" alt="{{ $image->user ? $image->user->name : '' }}" class="img-responsive img-rounded">
												</a>
											</div>

											@if($count % 3 == 0)
												</div>
												<div class="row mb-20">
											@endif
										@endforeach	
									</div>
									
								@else
									<p class="text-muted mb-0">No evidence attached</p>
								@endif
							</div>
						</div>

					</div>
				</div>
				
			</div>
		</div>
	</div>
		

@endsection