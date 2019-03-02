@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
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
					<div class="row">
				
						@foreach($deeds as $deed)
							
							@if(count($deed->images))
								
									<div class="col-sm-12"><h4>GALLERY</h4></div>
									
									@foreach($deed->images()->orderBy('created_at', 'DESC')->get() as $image)
										
										<div class="col-sm-4 mb-20">
											<a data-fancybox="gallery" data-caption="{{$deed->user->name}} : {{ $deed->name }}" href="{{ $image->image() }}">
												<img src="{{ $image->thumbnail() }}" alt="{{ $image->user ? $image->user->name : '' }}" class="img-responsive">
											</a>
										</div>

										
									@endforeach	
								
								
							
							@endif
							
						@endforeach

					</div>

					{{ $deeds->links() }}
				@else
					<h3 class="text-center">No Good Deeds Reported</h3>
				@endif
				
			</div>
		</div>
	</div>
		

@endsection