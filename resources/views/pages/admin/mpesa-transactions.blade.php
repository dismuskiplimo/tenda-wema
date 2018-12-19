@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }}
	            </h3>
	
				@if($transactions->total())
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Date</th>
										<th>Transaction Code</th>
										<th>Phone Number</th>
										<th>Amount</th>
										<th>Coins</th>
										<th>Transaction Date</th>
										<th>User</th>
										
									</tr>
								</thead>

								<tbody>
									@foreach($transactions as $transaction)
										
										<tr>
											<td>{{ simple_datetime($transaction->created_at) }}</td>
											<td>{{ $transaction->MpesaReceiptNumber }}</td>
											<td>{{ $transaction->PhoneNumber }}</td>
											<td>{{ $transaction->Amount }}</td>
											<td>{{ number_format($transaction->coins) }} Simba Coins</td>
											<td>{{ mpesa_date($transaction->TransactionDate) }}</td>
											<td><a href="{{ route('admin.user', ['id' => $transaction->user->id]) }}">{{ $transaction->user->name }}</a></td>
												
										</tr>

									@endforeach
								</tbody>
							</table>
							
						</div>
						
					</div>

					{{ $transactions->links() }}
					
				@else
					<i>No mpesa transactions</i>
				@endif
	            
	        </div>
	        
	    </div>

	</div>
	
@endsection