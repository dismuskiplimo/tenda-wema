@extends('layouts.email')

@section('content')
	<p>{{ $donated_item->donor->fname }},</p>

	<p>
		<strong>{{  $donated_item->name }}</strong> has been removed from the community shop by the admin staff.
	</p>

	<p><strong>Resaon for removing the item</strong></p>

	<p>
		<i>
			{{ $donated_item->deleted_reason }}
		</i>
	</p>

@endsection