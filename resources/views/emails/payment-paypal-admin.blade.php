@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{ $transaction->user->name}} has sent <strong>{{ $transaction->currency . ' ' . number_format($transaction->amount) }}</strong> via PayPal and received <strong>{{ number_format($transaction->coins) }}</strong> Simba Coins. Details Below:
	</p> <br>
	
	<table class="table table-striped">
		<tr>
            <th>Date</th>
            <td>{{ simple_datetime($transaction->created_at) }}</td>
        </tr>

        <tr>
    		<th>Transaction Code</th>
    		<td>{{ $transaction->transaction_code }}</td>
    	</tr>

    	<tr>
    		<th>Amount</th>
    		<td>{{ $transaction->currency . ' ' . number_format($transaction->amount) }}</td>
    	</tr>

    	<tr>
    		<th>Simba Coins Received</th>
    		<td>{{ $transaction->coins }} Simba Coins</td>
    	</tr>

    	<tr>
    		<th>Medium</th>
    		<td>{{ $transaction->medium }}</td>
    	</tr>

    	<tr>
    		<th>Descritpion</th>
    		<td>{{ $transaction->description }}</td>
    	</tr>

    	

    </table>

@endsection