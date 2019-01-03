@extends('layouts.email')

@section('content')
	<p>{{ $user->fname }},</p>

	<p>
		Your account has been carefully checked and your details meet the verification requirements. Your account is now verified and your profile will display a green "tick" icon next to your name. This will build trust among your coleagues.
	</p>

@endsection