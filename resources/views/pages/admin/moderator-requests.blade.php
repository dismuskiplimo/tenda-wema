@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} ({{ number_format($moderator_requests->total()) }})</h3>

	            @if($moderator_requests->total())
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>User</th>
								<th>Approve</th>
								<th>Dismiss</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($moderator_requests as $moderator_request)
								<tr>
									<td>{{ simple_datetime($moderator_request->created_at) }}</td>
									
									<td>
										<a href="{{ route('admin.user', ['id' => $moderator_request->user->id]) }}">{{ $moderator_request->user->name }}
										</a>

									</td>
									
									<td>
										<a href="" data-toggle = "modal" data-target = "#approve-moderator-request-{{ $moderator_request->id }}" class="btn btn-success btn-xs">
											<i class="fa fa-check"></i> APPROVE
										</a>

										@include('pages.admin.modals.approve-moderator-request')
									</td>

									<td>
										<a href="" data-toggle = "modal" data-target = "#dismiss-moderator-request-{{ $moderator_request->id }}" class="btn btn-danger btn-xs">
											<i class="fa fa-times"></i> DISMISS
										</a>

										@include('pages.admin.modals.dismiss-moderator-request')
									</td>

									<td>
										<a class="btn" href="{{ route('admin.user', ['id' => $moderator_request->user->id]) }}"> <i class="fa fa-eye"></i>
										</a>

									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $moderator_requests->links() }}
	            @else
					<p>No {{ $title }}</p>
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection