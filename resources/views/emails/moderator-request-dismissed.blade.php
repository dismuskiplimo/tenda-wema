@extends('layouts.email')

@section('content')
	<p>Dear {{ $moderator_request->user->fname }},</p>

	<p>
		Your request to be a moderator has been dismissed.
	</p>

	<p>
		<strong>Reason for dismissing the request</strong>
	</p>

	<p>
		<i>
			{{ $moderator_request->dismissed_reason }}
		</i>
	</p>

@endsection