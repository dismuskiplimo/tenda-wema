@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} ({{ number_format($donations->total()) }})</h3>

	            @if($donations->total())
		            <table class="table table-striped">
		            	<thead>
		            		<tr>
		            			<th>Name</th>
		            			<th>Amount</th>
		            			<th>Preferred Method</th>
		            			<th>Country</th>
		            			<th>Phone</th>
		            			<th>Email</th>
		            			<th>Status</th>
		            			<th></th>
		            		</tr>

		            	</thead>

		            	<tbody>
		            		
		            		@foreach($donations as $donation)
								<tr>
									<td>{{ $donation->fname . ' ' . $donation->lname }}</td>
									<td>KES {{ number_format($donation->amount) }}</td>
									<td>{{ $donation->method }}</td>
									<td>{{ $donation->country }}</td>
									<td>{{ $donation->phone }}</td>
									<td>{{ $donation->email }}</td>
									<td>{{ $donation->status() }}</td>
									<td><a class = "btn btn-xs" href="{{ route('admin.support-cause', ['id' => $donation->id]) }}"><i class="fa fa-eye"></i></a></td>
								</tr>
		            		@endforeach
		            		
		            	</tbody>
		            </table>
		            	{{ $donations->links() }}
		            @else
						<p>No Support cause requests</p>
		            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection