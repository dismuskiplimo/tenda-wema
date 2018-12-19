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

	            			<a href="{{ route('admin.contact-forms') }}" class="btn btn-sm btn-info pull-right"><i class="fa fa-arrow-left"></i> BACK</a>
	            		</h3>

	            			            		
	            	</div>

	            </div>
	            
 
	            <table class="table table-striped">
	            	<tr>
	            		<th>Date</th>
	            		<td>{{ simple_datetime($contact->created_at) }}</td>
	            	</tr>

	            	<tr>
	            		<th>Name</th>
	            		<td>{{ $contact->name }}</td>
	            	</tr>

	            	<tr>
	            		<th>Email</th>
	            		<td>{{ $contact->email }}</td>
	            	</tr>

	            	<tr>
	            		<th>Phone</th>
	            		<td>{{ $contact->phone }}</td>
	            	</tr>

	            	<tr>
	            		<th>Subject</th>
	            		<td>{{ $contact->subject }}</td>
	            	</tr>

	            	<tr>
	            		<th>Message</th>
	            		<td>{!! clean(nl2br($contact->message)) !!}</td>
	            	</tr>

	            	
	            	
	            </table>
     
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection