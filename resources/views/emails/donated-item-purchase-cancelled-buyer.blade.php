@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->buyer->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased was cancelled. The item has been returned to the community shop. You have been refunded the Simba Coins used to purchase.
	</p>

	<p>
		<a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">View Item</a>
	</p>

	

@endsection