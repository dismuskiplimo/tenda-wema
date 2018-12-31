@extends('layouts.email')

@section('content')
	<p>Dear {{ $user->fname }},</p>

	<p>Welcome to {{ config('app.name') }},</p>

	
@endsection