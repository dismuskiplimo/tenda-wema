@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{  $donated_item->donor->name }} has donated<strong>{{ $donated_item->name }}</strong> on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>.
	</p>

	<p>
		  Your attention is required to approve or dismiss the donated item.
	</p>

	<p><a href="{{ route('admin.donated-item', ['id' => $donated_item->id]) }}">View Item</a></p>

@endsection