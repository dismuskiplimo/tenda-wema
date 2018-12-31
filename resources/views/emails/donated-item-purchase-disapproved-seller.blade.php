@extends('layouts.email')

@section('content')
	<p>Dear {{ $donated_item->donor->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> purchased was not approved for delivery.
	</p>

	<p><strong>Resaon for not approving</strong></p>

	<p>
		<i>
			{{ $donated_item->disapproved_reason }}
		</i>
	</p>

@endsection