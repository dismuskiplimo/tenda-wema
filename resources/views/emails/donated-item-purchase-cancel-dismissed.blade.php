@extends('layouts.email')

@section('content')
	<p>Dear {{ $cancel_request->user->fname }},</p>

	<p>
		Your request to cancel donated item purchase <strong>{{ $cancel_request->donated_item->name }}</strong> was dismissed.
	</p>

	<p><strong>Resaon for dismissing</strong></p>

	<p>
		<i>
			{{ $cancel_request->dismissed_reason }}
		</i>
	</p>

@endsection