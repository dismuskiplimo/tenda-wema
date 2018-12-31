@extends('layouts.email')

@section('content')
	<p>Dear {{ $user_report->user->fname }},</p>

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
		{{  $user_report->reporter->name }} has reported you <strong>{{ $desc }}</strong>  on <strong>{{ simple_datetime($user_report->created_at) }}</strong> as <strong>{{ $user_report->report_type->description }}</strong>.   
	</p>

	<p><strong>Reason :</strong></p>

	<p>
		<i>
			{{ $user_report->description }}
		</i>
	</p>

	<p>
		The Admin Team has confirmed the misconduct. This your {{ ordinal_suffix($instance + 1) }} instance and have been penalised <strong>{{ $coins }} Simba Coins.</strong>
	</p>

@endsection