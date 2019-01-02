@extends('layouts.email')

@section('content')
	<p>Dear {{ $user->fname }},</p>

	<p>
		Your Community Member Award ({{ $community_member_award->award_year }}) has been revoked. It will no longer show up on your profile.
	</p> <br>

	<p> <strong>Reason For revoking</strong></p> <br>

	<p class="">
		<i>{{ $community_member_award->revoked_reason }}</i>
	</p>

@endsection