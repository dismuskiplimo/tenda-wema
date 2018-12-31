@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->donor->fname }},</p>

	<p>
		{{  $donated_item->buyer->name }} has marked the donated item purchased <strong>{{ $donated_item->name }}</strong> as received on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>. You have been credited {{ number_format($donated_item->price) }} Simba Coins to your account.
	</p>

	<p><a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">Click here to view</a></p>


@endsection