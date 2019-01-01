@extends('layouts.user-plain')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>My Profile</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="">Account</li>
				<li class="active">Settings</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h4>ACCOUNT</h4>

						<form action="{{ route('user.account.update') }}" class="" method="POST">
							@csrf
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="fname">First Name</label>
										<input type="text" name="fname" id="fname" class="form-control" required="" placeholder="First name" value="{{ $user->fname }}">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="lname">Last Name</label>
										<input type="text" name="lname" id="lname" class="form-control" required="" placeholder="Last name" value="{{ $user->lname }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" name="username" id="username" class="form-control" required="" placeholder="username" value="{{ $user->username }}">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="dob">Date of Birth</label>
										<input type="text" name="dob" id="dob" class="form-control dob" required="" placeholder="Date of Birth" readonly="" value="{{ $user->dob }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label for="email">Email</label>
										<input type="text" name="email" id="email" class="form-control" required="" placeholder="Email address" value="{{ $user->email }}">
									</div>
								</div>
							</div>

							<button class="btn btn-info" type="submit">Update</button>
						</form>
					</div>
				</div>
				

			</div>

			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h4>PASSWORD</h4>

						<form action="{{ route('user.password.update') }}" class="" method="POST">
							@csrf

							<div class="form-group">
								<label for="old_password">Old Password</label>
								<input type="password" name="old_password" id="old_password" class="form-control" required="" placeholder="Old password">
							</div>
							
							<div class="form-group">
								<label for="new_password">New Password</label>
								<input type="password" name="new_password" id="new_password" class="form-control" required="" placeholder="New password">
							</div>

							<div class="form-group">
								<label for="new_password_confirmation">Retype Pew Password</label>
								<input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required="" placeholder="retype new password">
							</div>

							<button class="btn btn-info" type="submit">Change Password</button>
						</form>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
		

		

@endsection