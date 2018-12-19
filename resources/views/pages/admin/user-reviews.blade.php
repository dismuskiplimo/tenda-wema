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

				@if($reviews->total())
					<div class="row">
						
						@foreach($reviews as $review)
						
							<div class="col-sm-12">
								<p>
									<a href="{{ route('admin.user', ['id' => $review->rater->id]) }}"><strong>{{ $review->rater->name }}</strong></a>, 
									
									@for($i = 0; $i < $review->rating; $i++)
										<i class="fa fa-star text-warning"></i>
									@endfor
									, <small class="text-muted">{{ simple_datetime($review->created_at) }}</small>
																			
								</p>

								<p>{{ $review->message }}</p>

								<hr>
							</div>	

						@endforeach
						
					</div>

					{{ $reviews->links() }}

					
				@else
					<i>No reviews</i>
				@endif

	        </div> 
	        
	    </div>
	    
	</div>

@endsection