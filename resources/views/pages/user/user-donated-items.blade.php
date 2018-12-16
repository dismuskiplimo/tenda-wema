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
				<h4>DONATED ITEMS ({{ number_format($donated_items->total()) }})</h4>
				
				@if($donated_items->total())
					<div class="row">
						@foreach($donated_items as $item)

						@php
							$banner = item_banner();

							if($item->images){
								$donated_item_image = $item->images()->first();

								if($donated_item_image){
									$banner 		= $donated_item_image->banner();
								}
								
							}
						@endphp

						<div class="col-sm-4">
							<div class="card">
								<div class="card-body">
									<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">
										<img src="{{ $banner }}" alt="{{ $item->name }}" class="img-responsive">
									</a>

									<h4 class="mt-10 mb-0">
										<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">{{characters($item->name, 20)}}</a>	
									</h4>

									<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
								</div>
							</div>
						</div>

						@endforeach
					</div>

					<div class="row">
						{{ $donated_items->links() }}
					</div>
				@else
					<p class="text-muted">No Items Donated</p>
				@endif

			</div>
		</div>
	</div>
		

		

@endsection