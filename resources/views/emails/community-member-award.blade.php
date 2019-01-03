@extends('layouts.email')

@section('content')
	<p>{{ $user->fname }},</p>

	<p>
		You received The Community Member Award ({{ $community_member_award->award_year }}). You will retain this badge until <strong>{{ simple_datetime($community_member_award->valid_until) }}</strong>.
	</p> <br>

	<p>The Badge below will appear on your profile to let others know of your status</p> <br>

	<p class="text-center">
		<img src="{{ $message->embed(community_member_award_badge('absolute')) }}" alt="" style="max-width: 250px; height:auto; ">
	</p>

@endsection