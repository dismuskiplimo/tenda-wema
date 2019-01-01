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
				<h3>{{ $title }} ({{ $user_reports->total() }})</h3>

				@if($user_reports->total())
					
						

						<table class="table table-hover">
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
								@foreach($user_reports as $report)
									
									<tr>
										<td>{{ simple_datetime($report->created_at) }}</td>
										<td><a href="{{ route('user.show', ['username' => $report->user->username]) }}">{{ $report->user->name }}</a></td>
										<td><a href="{{ route('user.show', ['username' => $report->reporter->username]) }}">{{ $report->reporter->name }}</a></td>
										<td>{{ $report->report_type->description }}</td>

										<td>{{ $report->status() }}</td>
										
										<td><a href="{{ route('user.moderator.misconduct-reported', ['id' => $report->id]) }}" class="btn btn-xs"><i class="fa fa-eye"></i></a></td>
											
									</tr>

								@endforeach
							</tbody>
						</table>
					

					{{ $user_reports->links() }}
				@else
					<p>No misconducts pending review</p>
				@endif
			</div>
		</div>
	</div>
		

		

@endsection