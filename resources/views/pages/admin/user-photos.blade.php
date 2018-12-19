@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }} 
	            	<a href="{{ url()->previous() }}" class="btn btn-info btn-xs margin-right">
	            		<i class="fa fa-arrow-left"></i> BACK
	            	</a>
	            </h3>

				@if($photos->total())
					<div class="row">
						
					@foreach($photos as $photo)
					
						<div class="col-sm-4 mb-20">
							<div class="thumbnail">
								<a data-fancybox="gallery" href="{{ $photo->photo() }}">
									<img src="{{ $photo->thumbnail() }}" alt="" class="img-responsive">
								</a>
							</div>
							
						</div>

					@endforeach
					
				</div>

				{{ $photos->links() }}

					
				@else
					<i>No photos</i>
				@endif
		        
	        </div> 
	        
	    </div>

	    
	</div>

@endsection