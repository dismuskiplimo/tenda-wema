@extends('layouts.user-plain')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>My Profile</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="">Account</li>
				<li class="active">My Profile</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-3">
				<img src="{{ $user->profile_picture() }}" alt="" class="img-responsive img-rounded mb-30 profile-picture"title="Click to update">

				<form action="{{ route('user.profile-picture.update') }}" class="hidden profile-picture-form" method="POST" enctype="multipart/form-data">
					@csrf

					<input type="file" class="profile-picture-file" name="image" accept="image/*" />
				</form>

				<table class="table table-striped">
					<tr>
						<th>NAME</th>
						<td>{{ $user->fname . ' ' . $user->lname }}</td>
					</tr>

					<tr>
						<th>USERNAME</th>
						<td>{{ $user->username }}</td>
					</tr>

					<tr>
						<th>EMAIL</th>
						<td>{{ $user->email }}</td>
					</tr>

					<tr>
						<th>DATE OF BIRTH</th>
						<td>{{ simple_date($user->dob) }}</td>
					</tr>

					
				</table>
			</div>

			<div class="col-sm-9">
				
			</div>
		</div>
	</div>
		

		

@endsection