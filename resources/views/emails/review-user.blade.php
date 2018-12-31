@extends('layouts.email')

@section('content')
	<p>Dear {{ $review->user->fname }},</p>

	<p>{{ $review->rater->name }} reviewed your profile.</p>

	<p>
		<i>Rating: {{ $review->rating }} Stars</i> <br>
		<strong>{{ $review->message }}</strong>
	</p>

	<p>
		<a href="{{ route('user.reviews.show', ['slug' => $review->user->slug]) }}">Click here to view</a>
	</p>

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection