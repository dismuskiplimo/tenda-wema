@extends('layouts.email')

@section('content')
	<p>Dear ,</p>

	

	<p><small class="text-muted">This is a system generated message, please do not reply.</small></p> <br>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection