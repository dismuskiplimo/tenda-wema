@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
			<span>Donate to support more good deeds and economic opportunity.</span>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 py-50">

				<p>
					Help tendawema.com deliver the most robust social platform that engage, inspire and empower people to uplift their lives and improve the community they live in by making a gift today.
				</p>

				<p>
					With your support we can:
				</p>

				<ul>
					<li>Inspire a culture of doing good deeds. </li>
					<li>Provide an additional source of essential products. </li>
					<li>Encourage donation of items to the Community. </li>
					<li>Promote prosperity and sustainability in our Community.</li>
				</ul>

				<form action="" method="POST">
					@csrf
					
					<h4>Gift Information</h4>
					
					<div class="form-group">
						<label for="">Amount you wish to donate in KES (Min: KES 1,000/=)</label>
						<input type="number" name="amount" min="1000" class="form-control" placeholder="Amount you wish to donate" required="">
					</div>

					<h4>Donor Information</h4>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">First Name</label>
								<input type="text" name="fname" class="form-control" placeholder="First Name" required="">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Last Name</label>
								<input type="text" name="lname" class="form-control" placeholder="Last Name" required="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Country</label>
								<select name="country" id="" class="form-control" required="">
									<option value="">-- Select Country --</option>
									@if(count($countries))
										@foreach($countries as $country)
											<option value="{{ $country->name }}">{{ $country->name }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Organization(Optional)</label>
								<input type="text" name="organization" class="form-control" placeholder="Organization">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Phone Number</label>
								<input type="text" name="phone" class="form-control" placeholder="Phone Number" required="">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Email Address</label>
								<input type="email" name="email" class="form-control" placeholder="Email Address" required="">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="">Donating As</label>
						<select name="donating_as" id="" class="form-control" required="">
							<option value="Individual">Individual</option>
							<option value="Group">Group</option>
							<option value="Company">Company</option>
							<option value="Organization">Organization</option>
						</select>
					</div>

					<div class="form-group">
						<label for="">How Do you wish to donate</label>
						<select name="method" id="" class="form-control" required="">
							<option value="Cash">Cash</option>
							<option value="Mobile Money">Mobile Money(MPESA, Airtel Money, TKash)</option>
							<option value="EFT">EFT (Direct Bank Transfer)</option>>

							<option value="Cheque">Cheque</option>						
						</select>
					</div>

					<p>
						Upon submitting, you will be contacted on how the donations will be delivered. 
					</p>

					<button type="submit" class="btn btn-success">Submit</button>

				</form>

				<div class="row">
					<div class="col-sm-12">
						<br><h3>OTHER WAYS TO SUPPORT THE CAUSE</h3>

						<h4>Mail</h4>
						<p>
							We welcome donations by cheque. Please use the following address for donations and correspondence:
						</p>

						<p>
							tendawema.com <br>
							P. O. Box 24721-00100 Nairobi

						</p>

						<p>
							Include your email address when sending mail to receive an electronic acknowledgment letter. We will not share your information. Personal email addresses are strongly preferred to work addresses.
						</p>

						<br><h4>In Kind</h4>

						<p>
							We welcome donations of clothing, dry food stuff, toiletries and books. We support children homes and orphanages with all donations received in kind. 
						</p>

						<p>
							Please contact us to know how to submit your donation. We will normally respond within one week. 
						</p>

						<br><h4>Corporate Partnership</h4>
						<p>
							We work with a small number of corporate partners who share our mission, on relationships of meaningful size. 
						</p>

						<p>
							To explore a corporate partnership, please <a href="{{ route('contact-us') }}">contact us</a>.
						</p>

					</div>
				</div>
				
			</div>
		</div>
	</div>
		

		

@endsection