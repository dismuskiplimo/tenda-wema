@extends('layouts.email')

@section('content')
	<p>Admin,</p>

	<p>
		{{  $donated_item->buyer->name }} is requesting to cancel donated item purchased <strong>{{ $donated_item->name }}</strong> on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>. Reason: <strong>{{ $cancel_order->reason }}</strong>.
	</p>

	<p>
		  Your attention is required to approve or dismiss the cancel request.
	</p>

	<p><a href="{{ route('admin.order-cancellation', ['id' => $cancel_order->id]) }}">View Request</a></p>

@endsection