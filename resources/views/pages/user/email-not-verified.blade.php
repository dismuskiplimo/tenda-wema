@extends('layouts.user')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 text-center my-100">
				<h3>{{ $title }}</h3>
				<h4>Verification message sent to {{ $user->email }}</h4>

				<p>You need to verify your email before you can access most of {{ config('app.name') }}'s Features. Please check your email inbox for an email verification message from {{ config('app.name') }}. If you have not received an email, please <a href="{{ route('auth.email.verification.resend') }}">click here</a> to resend the mail.</p>

				<p>If you wish to change your email address, please <a href="" data-toggle="modal" data-target="#update-user-email">click here</a></p>

				@include('pages.user.modals.update-user-email')
			</div>
		</div>
	</div>
		

		

@endsection