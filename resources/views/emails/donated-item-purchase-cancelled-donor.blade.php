@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->donor->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased was cancelled by the admin staff. The item has been returned to the community shop.
	</p>

	<p>
		<a href="{{ route('donated-item.show', ['slug' => $donated_item->slug]) }}">Click here to view</a>
	</p>

	

@endsection