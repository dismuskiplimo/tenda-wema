@extends('layouts.email')

@section('content')
	<p>Dear Admin,</p>

	<p>
		{{  $good_deed->user->name }} has reported a good deed <strong>{{ $good_deed->name }}</strong> on <strong>{{ simple_datetime($good_deed->created_at) }}</strong>.
	</p>

	<p>
		<strong>Description:</strong> <br>
		{{ $good_deed->description }}
	</p>

	<p>
		Your attention is required to verify and approve or dismiss the deed reported.
	</p>

	<p><a href="{{ route('admin.deed', ['id' => $good_deed->id]) }}">Click here to view</a></p>

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection