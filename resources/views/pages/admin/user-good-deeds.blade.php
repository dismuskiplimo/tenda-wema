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
	
				@if($good_deeds->total())
					<div class="row">
						@foreach($good_deeds as $deed)
						
							<div class="col-sm-12 mb-20">
								<p>
									Deed : <strong>{{ $deed->name }}</strong> <br>
									Location : {{ $deed->location }} <br>
									Peformed at : {{ simple_datetime($deed->peformed_at) }} <br>
									Description : {{ $deed->description }} <br>	
									Contacts : {{ $deed->contacts }}	
								</p>
								
							</div>

							<hr>

						@endforeach
						
						{{ $good_deeds->links() }}

					</div>
					
				@else
					<i>No good deeds reported</i>
				@endif
		            
	        </div> 
	        
	    </div>
    
	</div>

@endsection