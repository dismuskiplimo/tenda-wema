@extends('layouts.email')

@section('content')
	<p>{{ $item->donor->fname }},</p>

	<p>{{ $review->user->name }} reviewed your donated item <strong>{{ $item->name }}</strong>.</p>

	<p>
		<i>Rating: {{ $review->rating }} Stars</i> <br>
		<strong>{{ $review->message }}</strong>
	</p>

	<p>
		<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">View Item</a>
	</p>


@endsection