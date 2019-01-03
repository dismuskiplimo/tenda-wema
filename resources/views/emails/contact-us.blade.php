@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{ $contact_us->name}} has sent a message through the contact form. Details Below:
	</p> <br>
	
	<table class="table table-striped">
		<tr>
            <th>Date</th>
            <td>{{ simple_datetime($contact_us->created_at) }}</td>
        </tr>

        <tr>
    		<th>Name</th>
    		<td>{{ $contact_us->name }}</td>
    	</tr>

    	<tr>
    		<th>Email</th>
    		<td>{{ $contact_us->email }}</td>
    	</tr>

    	<tr>
    		<th>Phone</th>
    		<td>{{ $contact_us->phone }}</td>
    	</tr>

    	<tr>
    		<th>Subject</th>
    		<td>{{ $contact_us->subject }}</td>
    	</tr>

    	<tr>
    		<th>Message</th>
    		<td>{{ $contact_us->message }}</td>
    	</tr>

    	

    </table>

@endsection