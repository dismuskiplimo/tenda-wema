@extends('layouts.email')

@section('content')
	<p>Dear {{ $transaction->user->fname }},</p>

	<p>
		You have sent <strong>{{ $transaction->currency . ' ' . number_format($transaction->amount) }}</strong> via MPESA and received <strong>{{ number_format($transaction->coins) }}</strong> Simba Coins to your wallet. Below are the details:
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
            <th>Phone Number</th>
            <td>{{ $mpesa_transaction->PhoneNumber }}</td>
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

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection