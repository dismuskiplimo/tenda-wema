@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="col-sm-8 border-right">
						<h4>Write Us a Message</h4>
						<form action="" method="POST">
							@csrf
							
							<div class="form-group">
								<label for="">Name</label>
								<input type="text" name="name" class="form-control" placeholder="your name" required="">
							</div>						

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" name="email" class="form-control" placeholder="your email address" required="">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Phone Number (Optional) </label>
										<input type="text" name="phone" class="form-control" placeholder="your phone number" required="">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="">Subject</label>
								<input type="text" name="subject" class="form-control" placeholder="subject" required="">
							</div>

							<div class="form-group">
								<label for="">Message</label>
								<textarea name="message" class="form-control" id="" rows="10"></textarea>
								
							</div>

							<button type="submit" class="btn btn-success">Send Message</button>

						</form>
					</div>

					<div class="col-sm-4">
						<h4>Contact Information</h4>

						<p>
							<strong><i class="fa fa-map"></i> Location:</strong> <br>
							View Park Towers, Utalii Street

						</p>

						<p>
							<strong><i class="fa fa-phone"></i> Phone:</strong> <br>
							+254 735 663 734

						</p>

						<p>
							<strong><i class="fa fa-send"></i> Email:</strong> <br>
							<a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a>

						</p>

						<p>
							<strong><i class="fa fa-envelope"></i> Postal Address:</strong> <br>
							{{ config('app.company') }} <br>
							P. O. Box 24721-00100 <br> 
							Nairobi, Kenya

						</p>
						
						<img src="{{ custom_asset('images/tenda-wema/print-0.png') }}" alt="{{ config('app.name') }} Logo" class="img-responsive">
					</div>

				</div>

				<div class="row mt-50">
					<div class="col-sm-12">
						<h4>Map</h4>

						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8176212340572!2d36.81626920510648!3d-1.283281414073657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d23eb49bbb%3A0xf5ebdd7d189417a1!2sView+Park+Towers!5e0!3m2!1sen!2ske!4v1546018468040" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
		

		

@endsection