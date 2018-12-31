@extends('layouts.email')

@section('content')
	<p>Dear {{ $review->user->fname }},</p>

	<p>{{ $review->rater->name }} reviewed your profile.</p>

	<p>
		<i>Rating: {{ $review->rating }} Stars</i> <br>
		<strong>{{ $review->message }}</strong>
	</p>

	<p>
		<a href="{{ route('user.reviews.show', ['username' => $review->user->username]) }}">Click here to view</a>
	</p>

@endsection