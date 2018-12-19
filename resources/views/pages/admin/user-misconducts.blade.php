@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }}
	            </h3>
	
				@if($reports->total())
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Date</th>
										<th>Victim</th>
										<th>Reported By</th>
										<th>Reason</th>
										<th>Status</th>
										<th></th>
										
									</tr>
								</thead>

								<tbody>
									@foreach($reports as $report)
										
										<tr>
											<td>{{ simple_datetime($report->created_at) }}</td>
											<td><a href="{{ route('admin.user', ['id' => $report->user->id]) }}">{{ $report->user->name }}</a></td>
											<td><a href="{{ route('admin.user', ['id' => $report->reporter->id]) }}">{{ $report->reporter->name }}</a></td>
											<td>{{ $report->report_type->description }}</td>

											<td>{{ $report->status() }}</td>
											
											<td><a href="{{ route('admin.users.reported-single', ['id' => $report->id]) }}" class="btn btn-xs"><i class="fa fa-eye"></i></a></td>
												
										</tr>

									@endforeach
								</tbody>
							</table>
							
						</div>
						
					</div>

					{{ $reports->links() }}
					
				@else
					<i>No {{ $title }}</i>
				@endif
	            
	        </div>
	        
	    </div>

	</div>
	
@endsection