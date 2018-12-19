@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">

	            

	            @if(!$report->approved && !$report->dismissed)
					<p class="text-right">
						<a href="" data-toggle="modal" data-target="#approve-misconduct-{{ $report->id }}" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Confirm Misconduct</a>

						<a href="" data-toggle="modal" data-target="#dismiss-misconduct-{{ $report->id }}" class="btn btn-xs btn-warning"><i class="fa fa-times"></i> Dismiss Misconduct</a>
					</p>
					
					@include('pages.admin.modals.approve-misconduct')
					@include('pages.admin.modals.dismiss-misconduct')

					<hr>
	            @endif

	            <div class="row">
	            	<div class="col-sm-12">
            			<h3 class="box-title full-width">
		            		{{ $title }}

		            		<a href="{{ route('admin.users.reported', 'all') }}" class="btn btn-xs btn-info pull-right"><i class="fa fa-arrow-left"></i> BACK</a>
	            		</h3>
	            	</div>
	            </div>
	            
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-striped">
							
							<tbody>

								<tr>
									<th>Status</th>
									<td>{{ $report->status() }}</td>
								</tr>

								<tr>
									<th>Date</th>
									<td>{{ simple_datetime($report->created_at) }}</td>
								</tr>

								<tr>
									<th>Victim</th>
									<td><a href="{{ route('admin.user', ['id' => $report->user->id]) }}">{{ $report->user->name }}</a></td>
								</tr>

								<tr>
									<th>Reported By</th>
									<td><a href="{{ route('admin.user', ['id' => $report->reporter->id]) }}">{{ $report->reporter->name }}</a></td>
								</tr>

								<tr>
									<th>Reason</th>
									<td>{{ $report->report_type->description }}</td>
								</tr>

								<tr>
									<th>Details</th>
									<td>{{ $report->description }}</td>
								</tr>

								@if($report->approved)
									<tr>
										<th>Approved By</th>
										<td>
											<a href="{{ route('admin.user', ['id' => $report->approver->id]) }}">{{ $report->approver->name }}</a>

										</td>
									</tr>

									<tr>
										<th>Approved At</th>
										<td>{{ simple_datetime($report->approved_at) }}</td>
									</tr>
								@endif

								@if($report->dismissed)
									<tr>
										<th>Dismissed By</th>

										<td>
											<a href="{{ route('admin.user', ['id' => $report->dismisser->id]) }}">{{ $report->dismisser->name }}</a>
											
										</td>
									</tr>
									

									<tr>
										<th>Dismissed At</th>
										<td>{{ simple_datetime($report->dismissed_at) }}</td>
									</tr>

									<tr>
										<th>Reason to dismiss</th>
										<td>{{ $report->dismissed_reason }}</td>
									</tr>
								@endif

								@if($report->section == 'user')
									<tr>
										<th>View Reported User</th>
										<td><a href="{{ route('admin.user', ['id' => $report->user_model->id]) }}">{{ $report->user_model->name }}</a></td>
									</tr>

								@elseif($report->section == 'item')
									<tr>
										<th>View Reported Item</th>
										<td><a href="{{ route('admin.donated-item', ['id' => $report->item_model->id]) }}">{{ $report->item_model->name }}</a></td>
									</tr>
								@elseif($report->section == 'post')
									<tr>
										<th>View Reported Post</th>
										<td></td>
									</tr>
								@elseif($report->section == 'comment')
									<tr>
										<th>View Reported Comment</th>
										<td></td>
									</tr>
								@endif

								
								
							</tbody>
						</table>
						
					</div>
					
				</div>
	        </div>
	        
	    </div>

	</div>
	
@endsection