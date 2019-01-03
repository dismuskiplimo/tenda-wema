@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->donor->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased was disputed.
	</p>

	<p><strong>Resaon for disputing the purchase</strong></p>

	<p>
		<i>
			{{ $donated_item->disputed_reason }}
		</i>
	</p>

@endsection