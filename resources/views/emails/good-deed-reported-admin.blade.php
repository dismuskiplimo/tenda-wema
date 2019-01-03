@extends('layouts.email')

@section('content')
	<p>Admin,</p>

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

	<p><a href="{{ route('admin.deed', ['id' => $good_deed->id]) }}">View Deed</a></p>

@endsection