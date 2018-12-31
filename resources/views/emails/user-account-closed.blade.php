@extends('layouts.email')

@section('content')
	<p>Dear {{ $user->fname }},</p>

	<p>
		Your {{ config('app.name') }} account was closed. You can no longer log in to your account. All your remaining Simba Coins were returned to the community.
	</p>

	<p><strong>Reason for closure</strong></p>

	<p>
		<i>{{ $user->closed_reason }}</i>
	</p>

@endsection