@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} ({{ number_format($cancel_requests->total()) }})</h3>

	            @if($cancel_requests->total())
		            <table class="table">
		            	<thead>
		            		<tr>
		            			<th>Date</th>
		            			<th>User</th>
		            			<th>Donated Item</th>
		            			<th>Status</th>
		        		            			
		            			<th></th>
		            		</tr>

		            	</thead>

		            	<tbody>
		            		
		            		@foreach($cancel_requests as $cancel_request)
								<tr{!! $cancel_request->status() == 'PENDING REVIEW' ? ' class="bg-muted"' : '' !!}>
									<td>{{ simple_datetime($cancel_request->created_at) }}</td>
									<td><a href="{{ route('admin.user', ['id' => $cancel_request->user->id]) }}">{{ $cancel_request->user->name }}</a></td>
									<td><a href="{{ route('admin.donated-item', ['id' => $cancel_request->donated_item->id]) }}">{{ $cancel_request->donated_item->name }}</a></td>
									<td>{{ $cancel_request->status() }}</td>
									
									<td><a class = "btn btn-xs" href="{{ route('admin.order-cancellation', ['id' => $cancel_request->id]) }}"><i class="fa fa-eye"></i></a></td>
								</tr>
		            		@endforeach
		            		
		            	</tbody>
		            </table>
		            	{{ $cancel_requests->links() }}
		            @else
						<p>Nothing here</p>
		            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection