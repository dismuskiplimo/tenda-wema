@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->donor->fname }},</p>

	<p>
		{{  $donated_item->name }} has been verified, it is now available in the Community Shop.
	</p>

	<p><a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">View Item</a></p>


@endsection