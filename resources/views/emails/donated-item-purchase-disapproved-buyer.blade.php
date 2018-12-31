@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->buyer->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased has not approved for delivery. You have been refunded the Simba Coins deducted upon purchase.
	</p>

	<p><strong>Resaon for not approving</strong></p>

	<p>
		<i>
			{{ $donated_item->disapproved_reason }}
		</i>
	</p>

@endsection