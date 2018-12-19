@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} ({{ number_format($contacts->total()) }})</h3>

	            @if($contacts->total())
		            <table class="table">
		            	<thead>
		            		<tr>
		            			<th>Name</th>
		            			<th>Subject</th>
		            			<th>Email</th>
		            			<th>Phone</th>
		            			<th>Message</th>
		            			
		            			<th></th>
		            		</tr>

		            	</thead>

		            	<tbody>
		            		
		            		@foreach($contacts as $contact)
								<tr{!! $contact->read ? '' : ' class="bg-muted"' !!}>
									<td>{{ $contact->name }}</td>
									<td>{{ $contact->subject }}</td>
									<td>{{ $contact->email }}</td>
									<td>{{ $contact->phone }}</td>
									<td>{{ characters($contact->message, 20) }}</td>
									
									<td><a class = "btn btn-xs" href="{{ route('admin.contact-form', ['id' => $contact->id]) }}"><i class="fa fa-eye"></i></a></td>
								</tr>
		            		@endforeach
		            		
		            	</tbody>
		            </table>
		            	{{ $contacts->links() }}
		            @else
						<p>No messages from contact form</p>
		            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection