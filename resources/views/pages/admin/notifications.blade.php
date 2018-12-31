@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title mb-0">
	            	{{ $title }} ({{ number_format($notifications->total()) }})
					<small class="pull-right"><a href="{{ route('admin.notifications.mark-all-as-read') }}">Mark all as read</a></small>
	            </h3>            
	        </div> 

	        <div class="row">
	        	<div class="col-sm-12">
	        		@if($notifications->total())
							@foreach($notifications as $notification)
								<div class="card {{ $notification->read ? 'panel-default' : 'panel-info' }} mb-10">
									<div class="" style="padding: 10px">
										<p>{{ $notification->message }}</p>

										<small class="pull-right text-muted">{{ simple_datetime($notification->created_at) }} <a href="{{ route('admin.notifications.mark-single-as-read', ['id' => $notification->id]) }}"> | MARK AS READ</a></small>
									</div>
								</div>
							@endforeach

							{{ $notifications->links() }}
	        		@else
						<p>No notifications</p>
	        		@endif
	        	</div>
	        </div>
	        
	    </div>

	    
	</div>


	

	
@endsection