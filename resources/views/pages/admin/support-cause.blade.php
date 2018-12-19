@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <div class="row">
	            	<div class="col-sm-12">
	            		<h3 class="box-title">
	            			{{ $title }}

	            			<a href="{{ route('admin.support-causes') }}" class="btn btn-sm btn-info pull-right"><i class="fa fa-arrow-left"></i> BACK</a>
	            		</h3>

	            		@if($donation->received == 0 && $donation->dismissed == 0)
							<p>
								<a href="" data-toggle="modal" data-target="#receive-donation-request-{{ $donation->id }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i> MARK AS RECEIVED</a>

								<a href="" data-toggle="modal" data-target="#dismiss-donation-request-{{ $donation->id }}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DISMISS DONATION REQUEST</a>	
							</p>

							@include('pages.admin.modals.receive-donation-request')
							@include('pages.admin.modals.dismiss-donation-request')
							
	            		@endif

	            		
	            	</div>

	            </div>
	            
 
	            <table class="table table-striped">
	            	<tr>
	            		<th>Name</th>
	            		<td>{{ $donation->fname . ' ' . $donation->lname }}</td>
	            	</tr>

	            	<tr>
	            		<th>Organization</th>
	            		<td>{{ $donation->organization }}</td>
	            	</tr>

	            	<tr>
	            		<th>Amount</th>
	            		<td>KES {{ number_format($donation->amount) }}</td>
	            	</tr>

	            	<tr>
	            		<th>Donating as</th>
	            		<td>{{ $donation->donating_as }}</td>
	            	</tr>

	            	<tr>
	            		<th>Preferred Method</th>
	            		<td>{{ $donation->method }}</td>
	            	</tr>

	            	<tr>
	            		<th>Country</th>
	            		<td>{{ $donation->country }}</td>
	            	</tr>

	            	<tr>
	            		<th>Phone</th>
	            		<td>{{ $donation->phone }}</td>
	            	</tr>

	            	<tr>
	            		<th>Email</th>
	            		<td>{{ $donation->email }}</td>
	            	</tr>

	            	<tr>
	            		<th>Status</th>
	            		<td>{{ $donation->status() }}</td>
	            	</tr>

	            	@if($donation->approved)
						<tr>
		            		<th>Received By</th>
		            		<td>{{ $donation->receiver->name }}</td>
		            	</tr>

						<tr>
		            		<th>Date Received</th>
		            		<td>{{ simple_datetime($donation->received_at) }}</td>
		            	</tr>

		            	
	            	@endif

	            	@if($donation->dismissed)
						<tr>
		            		<th>Dismissed By</th>
		            		<td>{{ $donation->dismisser->name }}</td>
		            	</tr>

						<tr>
		            		<th>Date Dismissed</th>
		            		<td>{{ simple_datetime($donation->dismissed_at) }}</td>
		            	</tr>

		            	<tr>
		            		<th>Reason Dismissed</th>
		            		<td>{{ $donation->dismissed_reason }}</td>
		            	</tr>
	            	@endif
	            	
	            </table>
     
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection