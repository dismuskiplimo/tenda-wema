@extends('layouts.email')

@section('content')
	<p>{{ $deed->user->fname }},</p>

	<p>Your good deed <strong>{{ $deed->name }}</strong> was approved. You have been awarded {{ config('coins.earn.good_deed') }} Simba Coins.</p>

	<p>
		<a href="{{ route('good-deed.show', ['slug' => $deed->slug]) }}">View Deed</a>
	</p>

	
@endsection