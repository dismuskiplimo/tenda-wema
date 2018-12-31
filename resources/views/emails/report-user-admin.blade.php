@extends('layouts.email')

@section('content')
	<p>Dear Admin,</p>

	@php
		if($user_report->section == 'user'){
			$desc = $user_report->ser_model->fname;
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
		{{  $user_report->reporter->name }} has reported a(n) {{ $user_report->section }} &lt; <strong>{{ $desc }}</strong> &gt; on <strong>{{ simple_datetime($user_report->created_at) }}</strong> as being {{ $user_report->report_type->description }}. Reason being &lt; {{ $user_report->description }} &gt;
	</p>

	<p>
		Your attention is required to verify and approve or dismiss the report.
	</p>

	<p><a href="{{ route('admin.users.reported-single', ['id' => $user_report->id]) }}">Click here to view</a></p>

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection