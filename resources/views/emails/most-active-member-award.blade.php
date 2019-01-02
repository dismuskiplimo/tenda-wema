@extends('layouts.email')

@section('content')
	<p>Dear {{ $user->fname }},</p>

	<p>
		You received The Most Active Member Award ({{ $most_active_member_award->award_year }}). You will retain this badge until <strong>{{ simple_datetime($most_active_member_award->valid_until) }}</strong>.
	</p> <br>

	<p>The Badge below will appear on your profile to let others know of your status</p> <br>

	<p class="text-center">
		<img src="{{ $message->embed(most_active_member_award_badge('absolute')) }}" alt="" style="max-width: 250px; height:auto; ">
	</p>

@endsection