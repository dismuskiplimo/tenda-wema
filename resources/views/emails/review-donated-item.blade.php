@extends('layouts.email')

@section('content')
	<p>Dear {{ $item->donor->fname }},</p>

	<p>{{ $review->user->name }} reviewed your donated item <strong>{{ $item->name }}</strong>.</p>

	<p>
		<i>Rating: {{ $review->rating }} Stars</i> <br>
		<strong>{{ $review->message }}</strong>
	</p>

	<p>
		<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">Click here to view</a>
	</p>

	

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection