@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }} 
	            	<a href="{{ url()->previous() }}" class="btn btn-info btn-xs pull-right">
	            		<i class="fa fa-arrow-left"></i> BACK
	            	</a>
	            </h3>
	
				@if($simba_coin_logs->total())
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Date</th>
										<th>Simba Coins</th>
										<th>Message</th>
										<th>Previous Balance</th>
										<th>New Balance</th>									
									</tr>
								</thead>

								<tbody>
									@foreach($simba_coin_logs as $log)
										
										<tr>
											<td>{{ simple_datetime($log->created_at) }}</td>
											<td>
												@php
													if($log->type == 'credit'){
														$class = 'text-success';	
													}else{
														$class = 'text-danger';
													}
												@endphp

												<span class="{{ $class }}">
													{{ $log->type == 'credit' ? '+' : '-' }} {{ number_format($log->coins) }}
												</span>
											</td>
											<td>{{ $log->message }}</td>
											
											<td>{{ $log->previous_balance }}</td>
											<td>{{ $log->current_balance }}</td>
											
										</tr>

									@endforeach
								</tbody>
							</table>
									
						</div>

					</div>

					{{ $simba_coin_logs->links() }}
					
				@else
					<i>No simba coin logs</i>
				@endif
		        
	        </div> 
	        
	    </div>

	</div>

@endsection