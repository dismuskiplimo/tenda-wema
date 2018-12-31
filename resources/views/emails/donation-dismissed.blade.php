@extends('layouts.email')

@section('content')
	<p>Dear {{ $donation->fname }},</p>

	<p>Thank you for your donation request. We however have dismissed the request.</p>

	<p><strong>Reason for dismissing</strong></p>
	
	<p><i>{{ $donation->dismissed_reason }}</i></p>


@endsection