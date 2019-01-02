@extends('layouts.email')

@section('content')
	<p>Dear {{ $user->fname }},</p>

	<p>
		Your Most Active Member Award ({{ $most_active_member_award->award_year }}) has been revoked. It will no longer show up on your profile.
	</p> <br>

	<p><strong>Reason for revoking award</strong></p> <br>

	<p>
		<i>{{ $most_active_member_award->revoked_reason }}</i>
	</p>

@endsection