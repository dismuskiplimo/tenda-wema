@extends('layouts.email')

@section('content')
	<p>Dear {{ $donation->fname }},</p>

	<p>Thank you for your donation. We highly appreciate your support for {{ config('app.name') }}. Together we can do more.</p>


@endsection