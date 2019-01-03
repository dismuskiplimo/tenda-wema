@extends('layouts.email')

@section('content')
	<p>{{ $review->user->fname }},</p>

	<p>{{ $review->rater->name }} reviewed your profile.</p>

	<p>
		<i>Rating: {{ $review->rating }} Stars</i> <br>
		<strong>{{ $review->message }}</strong>
	</p>

	<p>
		<a href="{{ route('user.reviews.show', ['username' => $review->user->username]) }}">View Review</a>
	</p>

@endsection