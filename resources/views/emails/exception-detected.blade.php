@extends('layouts.email')

@section('content')
	<p>Developer,</p>
	
	<h3>Action needed</h3>

	<p>{{ $e->getMessage() }}</p>

	<p>{!! clean($e) !!}</p>
	
@endsection