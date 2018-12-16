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
					PHOTOS

					@if($me)
						<a href="" class="button button-black pull-right mtn-10" data-toggle="modal" data-target="#add-user-photo-modal"><i class="fa fa-plus"></i> UPLOAD PHOTO</a>	
					@endif

				</h4>

				<div class="row mb-20">
					@if($photos->total())
						@php
							$count = 0;
						@endphp

						@foreach($photos as $photo)
							@php
								$count++;
							@endphp

							<div class="col-sm-4">
								<a data-fancybox="gallery" href="{{ $photo->photo() }}">
									<img src="{{ $photo->thumbnail() }}" alt="{{ $photo->user ? $photo->user->name : '' }}" class="img-responsive img-rounded">
								</a>

								@if($me)
									<span class="delete-user-photo" title="Delete Photo">
										<form action="{{ route('user.photos.delete', ['id' => $photo->id]) }}" method="POST">
											@csrf
											<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
										</form>
										
									</span>
								@endif
								
							</div>

							@if($count % 3 == 0)
								</div>
								<div class="row mb-20">
							@endif

						@endforeach

						{{ $photos->links() }}
					@else
						<div class="col-sm-12">
							<p class="text-muted">No photos</p>
						</div>
						
					@endif
				</div>
			</div>
		</div>
	</div>

	@if($me)
		@include('pages.user.modals.add-user-photo')
	@endif
		

		

@endsection