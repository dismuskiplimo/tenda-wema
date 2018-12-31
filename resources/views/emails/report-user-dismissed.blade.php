@extends('layouts.email')

@section('content')
	<p>Dear {{ $user_report->reporter->fname }},</p>

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
		You reported {{ $desc }} on <strong>{{ simple_datetime($user_report->created_at) }}</strong> <strong></strong> -  <strong>{{ $user_report->report_type->description }}</strong>.   
	</p>

	<p><strong>Reason :</strong></p>

	<p>
		<i>
			{{ $user_report->description }}
		</i>
	</p>

	<p>
		The Admin Team has reviewed and confirmed that there was no misconduct.</strong>
	</p>

	<p>
		<strong>Reason for dismissing</strong>	
	</p>

	<p>{{ $user_report->dismissed_reason }}</p>

@endsection