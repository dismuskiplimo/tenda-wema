@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->buyer->fname }},</p>

	<p>
		You marked the donated item purchased <strong>{{ $donated_item->name }}</strong> as received on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>. Thank you for using {{ config('app.name') }}.
	</p>

	<p><a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">View Item</a></p>


@endsection