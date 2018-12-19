@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }} 
	            	<a href="{{ url()->previous() }}" class="btn btn-info btn-xs margin-right">
	            		<i class="fa fa-arrow-left"></i> BACK
	            	</a>
	            </h3>
	
				@if($transactions->total())
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Date</th>
										<th>Transaction Code</th>
										<th>Amount</th>
										<th>Coins</th>
										<th>Medium</th>
										<th>Status</th>	
									</tr>
								</thead>

								<tbody>
									@foreach($transactions as $transaction)
										
										<tr>
											<td>{{ simple_datetime($transaction->created_at) }}</td>
											<td>{{ $transaction->transaction_code }}</td>
											<td>{{ $transaction->currency }} {{ number_format($transaction->amount) }}</td>
											<td>{{ number_format($transaction->coins) }} Simba Coins</td>
											<td>{{ $transaction->medium }}</td>
											<td>{{ $transaction->status }}</td>		
											<td>{{ $transaction->description }}</td>		
										</tr>

									@endforeach
								</tbody>
							</table>
							
						</div>
						
					</div>

					{{ $transactions->total() }}
					
				@else
					<i>No transactions</i>
				@endif
	            
	        </div>
	        
	    </div>

	</div>
	
@endsection