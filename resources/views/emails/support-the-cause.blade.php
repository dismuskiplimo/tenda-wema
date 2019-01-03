@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{ $donation->fname .' '. $donation->lname}} is requesting to support the cause. Below are the details.
	</p> <br>
	
	<table class="table table-striped">
		<tr>
            <th>Date</th>
            <td>{{ simple_datetime($donation->created_at) }}</td>
        </tr>

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

    </table>

@endsection