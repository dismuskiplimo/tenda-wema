@extends('layouts.email')

@section('content')
	<p>Dear Admin,</p>

	@php
		if($user_report->section == 'user'){
			$desc = $user_report->user_model->fname;
		}

		elseif($user_report->section == 'item'){
			$desc = $user_report->item_model->name;
		}

		elseif($user_report->section == 'post'){
			$desc = $user_report->post_model->content;
		}

		elseif($user_report->section == 'comment'){
			$desc = $user_report->comment_model->content;
		}

		else{
			$desc = 'unknown';
		}
	@endphp

	<p>
		{{  $user_report->reporter->name }} has reported {{ $user_report->section }} <strong>{{ $desc }}</strong> on <strong>{{ simple_datetime($user_report->created_at) }}</strong> as  <strong>{{ $user_report->report_type->description }}</strong>. <br> <br> <strong>Reason:</strong>
	</p>

	<p>
		<i> {{ $user_report->description }} </i>
	</p>

	<p>
		Your attention is required to verify and approve or dismiss the report.
	</p>

	<p><a href="{{ route('admin.users.reported-single', ['id' => $user_report->id]) }}">Click here to view</a></p>

@endsection