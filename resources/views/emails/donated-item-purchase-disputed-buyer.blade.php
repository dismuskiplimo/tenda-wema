@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->buyer->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased was disputed. You have been refunded the Simba Coins deducted upon purchase.
	</p>

	<p><strong>Reason for disputing</strong></p>

	<p>
		<i>
			{{ $donated_item->disputed_reason }}
		</i>
	</p>

@endsection