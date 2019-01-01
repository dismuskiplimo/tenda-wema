@extends('layouts.email')

@section('content')
	<p>Dear Admin,</p>

	<p>
		{{  $user->name }} is requesting to become a moderator.
	</p>

	<p>
		  Your attention is required to approve or dismiss the cancel request.
	</p>

	<p><a href="{{ route('admin.user', ['id' => $user->id]) }}">Click here to view</a></p>

@endsection