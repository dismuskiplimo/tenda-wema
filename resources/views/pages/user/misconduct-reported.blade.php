@extends('layouts.user-plain')

@section('content')
	
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1">
				

	            

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
            			<h3 class="">
		            		{{ $title }}
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
									<td><a href="{{ route('user.show', ['username' => $report->user->username]) }}">{{ $report->user->name }}</a></td>
								</tr>

								<tr>
									<th>Reported By</th>
									<td><a href="{{ route('user.show', ['username' => $report->reporter->username]) }}">{{ $report->reporter->name }}</a></td>
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
											{{ $report->approver->name }}

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
											{{ $report->dismisser->name }}
											
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
										<td><a target="_blank" href="{{ route('user.show', ['username' => $report->user_model->username]) }}">{{ $report->user_model->name }}</a></td>
									</tr>

								@elseif($report->section == 'item')
									<tr>
										<th>View Reported Item</th>
										<td><a target="_blank" href="{{ route('donated-item.show', ['slug' => $report->item_model->slug]) }}">{{ $report->item_model->name }}</a></td>
									</tr>
								@elseif($report->section == 'post')
									<tr>
										<th>View Reported Post</th>
										<td>
											<a target="_blank" href="{{ route('post', ['slug' => $report->post_model->slug ]) }}">
												
												<strong>{{ $report->post_model->title }}</strong> <br>

												{!! clean(nl2br($report->post_model->content)) !!}
											</a>
										</td>
									</tr>
								@elseif($report->section == 'comment')
									<tr>
										<th>View Reported Comment</th>
										<td>
											<a href="{{ route('post', ['slug' => $report->comment_model->post->slug]) }}#comment-{{ $report->comment_model->id }}">
													{!! clean(nl2br($report->comment_model->content)) !!}
											</a>
										</td>
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