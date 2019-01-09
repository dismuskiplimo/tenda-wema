@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->donor->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> donation was not approved.
	</p>

	<p><strong>Resaon for not approving</strong></p>

	<p>
		<i>
			{{ $donated_item->disapproved_reason }}
		</i>
	</p>

@endsection