@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{  $donated_item->buyer->name }} has purchased <strong>{{ $donated_item->name }}</strong> on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>. Your attention is required to deliver the purchase.
	</p>

	<p><a href="{{ route('admin.donated-item', ['id' => $donated_item->id]) }}">View Item</a></p>

@endsection