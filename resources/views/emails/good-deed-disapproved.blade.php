@extends('layouts.email')

@section('content')
	<p>{{ $deed->user->fname }},</p>

	<p>Your good deed <strong>{{ $deed->name }}</strong> was not approved.</p>

	<p><strong>Reason: </strong></p>

	<p>
		<i>{{ $deed->disapproved_reason }}</i>
	</p>

	<p>
		<a href="{{ route('good-deed.show', ['slug' => $deed->slug]) }}">View Deed</a>
	</p>

	
@endsection