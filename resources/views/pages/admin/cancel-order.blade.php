@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            @if(!$cancel_request->approved && !$cancel_request->dismissed)
					<div class="text-right">
						<a href="" data-toggle="modal" data-target="#approve-cancel-order-{{ $cancel_request->id }}" class="btn btn-info btn-xs"><i class="fa fa-check"></i> CANCEL ORDER</a>
						<a href="" data-toggle="modal" data-target="#dismiss-cancel-order-{{ $cancel_request->id }}" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> DISMISS REQUEST</a>
					</div>

					@include('pages.admin.modals.approve-cancel-order')
					@include('pages.admin.modals.dismiss-cancel-order')

	            @endif

	            <h3 class="box-title">{{ $title }} ({{ $cancel_request->status() }})</h3>
	           
	            <table class="table">

	            	<tbody>

	            		<tr>
	            			<th>Date</th>
	            			<td>{{ simple_datetime($cancel_request->created_at) }}</td>
	            		</tr>

	            		<tr>
	            			<th>Status</th>
	            			<td>{{ $cancel_request->status() }}</td>
	            		</tr>

	            		<tr>
	            			<th>User</th>
	            			<td>
	            				<a href="{{ route('admin.user', ['id' => $cancel_request->user->id]) }}">{{ $cancel_request->user->name }}</a>
	            			</td>
	            		</tr>

	            		<tr>
	            			<th>Donated Item</th>
	            			<td>
	            				<a href="{{ route('admin.donated-item', ['id' => $cancel_request->donated_item->id]) }}">{{ $cancel_request->donated_item->name }}</a>
	            			</td>
	            		</tr>

	            		<tr>
	            			<th>Reason for Cancellation</th>
	            			<td>{!! clean($cancel_request->reason) !!}</td>
	            		</tr>

	            		@if($cancel_request->dismissed)
							<tr>
		            			<th>Request Dismissed</th>
		            			<td>{!! $cancel_request->dismissed ? '<span class = "text-success">YES</span>' : 'NO' !!}</td>
		            		</tr>

		            		<tr>
		            			<th>Dismissed At</th>
		            			<td>{{ simple_datetime($cancel_request->dismissed_at) }}</td>
		            		</tr>

		            		<tr>
		            			<th>Dismissed By</th>
		            			<td><a href="{{ route('admin.user', ['id' => $cancel_request->dismisser->id]) }}">{{ $cancel_request->dismisser->name }}</a></td>
		            		</tr>

		            		<tr>
		            			<th>Reason for dismissal</th>
		            			<td>{!! clean($cancel_request->dismissed_reason) !!}</td>
		            		</tr>
	            		@endif

	            		@if($cancel_request->approved)
							<tr>
		            			<th>Purchase Cancelled</th>
		            			<td>{!! $cancel_request->approved ? '<span class = "text-success">YES</span>' : 'NO' !!}</td>
		            		</tr>

		            		<tr>
		            			<th>Cancelled At</th>
		            			<td>{{ simple_datetime($cancel_request->approved_at) }}</td>
		            		</tr>

		            		<tr>
		            			<th>Cancelled By</th>
		            			<td><a href="{{ route('admin.user', ['id' => $cancel_request->approver->id]) }}">{{ $cancel_request->approver->name }}</a></td>
		            		</tr>

		            		
	            		@endif




	            		<tr>
	            			<th></th>
	            			<td>
	            				<div class="btn-group">
	            					<a href="{{ route('admin.message.new', ['id' => $item->donor->id]) }}" class="btn btn-info" target="_blank">
										<i class="fa fa-send"></i> MESSAGE SELLER
									</a>

									@if($item->buyer)
										<a href="{{ route('admin.message.new', ['id' => $item->buyer->id]) }}" class="btn btn-primary" target="_blank">
											<i class="fa fa-send"></i> MESSAGE BUYER
										</a>
									@endif
	            				</div>
	            				

	            			</td>
	            		</tr>

	            		
	            	            		
	            		
	            	</tbody>
	            </table>
		            	
		            
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection