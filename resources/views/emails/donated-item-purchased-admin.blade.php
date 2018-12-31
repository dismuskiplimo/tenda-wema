@extends('layouts.email')

@section('content')
	<p>Dear Admin,</p>

	<p>
		{{  $donated_item->buyer->name }} has purchased <strong>{{ $donated_item->name }}</strong> on <strong>{{ simple_datetime($donated_item->bought_at) }}</strong>. Your attention is required to approve or disapprove the purchase.
	</p>

	<p><a href="{{ route('admin.donated-item', ['id' => $donated_item->id]) }}">Click here to view</a></p>

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection