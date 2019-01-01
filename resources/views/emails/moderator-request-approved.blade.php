@extends('layouts.email')

@section('content')
	<p>Dear {{ $moderator_request->user->fname }},</p>

	<p>
		Your request to be a moderator has been approved. You have now a moderator.
	</p>

@endsection