@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->buyer->fname }},</p>

	<p>
		{{  $donated_item->name }} has been approved for delivery. The admin team will liase with you and the donor on how the item will be delivered.
	</p>

	<p><a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">Click here to view item</a></p>


@endsection