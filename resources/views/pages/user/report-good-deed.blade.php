@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>Report a good deed</h1>
			<span>Report a good deed that impacts the society in a positive way</span>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">Report a good deed </li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1">
				<form action="{{ route('report-a-good-deed') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="deed-name">What did you do?</label>
								<input type="text" id="deed-name" name="name" required="" class="form-control required" placeholder="what did you do" value="{{ old('name') }}" />
							</div>
						</div>

						
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="deed-location">Where did you do the good deed? (i.e Location)</label>
								<input type="text" id="deed-location" name="location" required="" class="form-control required" placeholder="location" value="{{ old('location') }}" />
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="deed-time">When did you do the good deed?</label>
								<input type="text" id="deed-time" name="performed_at" required="" class="form-control required datepicker" readonly="" placeholder="when did you do it" value="{{ old('performed_at') }}" />
							</div>
						</div>
					</div>

					

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="deed-description">Explain in detail</label>
								<textarea id="deed-description" name="description" required="" class="form-control required" placeholder="description" rows="10">{{ old('description') }}</textarea>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="contacts">Contacts for whoever can verify your good deed (if any)</label>
								<textarea id="contacts" name="contacts" class="form-control" placeholder="contacts" rows="5">{{ old('contacts') }}</textarea>
							</div>
						</div>

					</div>

					<div class="row mb-20">
						<div class="col-sm-8 buttons">
                             <label for="">EVIDENCE (Only images accepted | maximum size allowed per image : 4MB)</label>           
                            <div class="button-wrapper file-button"></div>

                            <button class="btn add-file-button btn-sm btn-success" type="button">
                            	<i class="fa fa-plus"></i> Add Evidence
                            </button>
   
                    	</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							@if(auth()->check())
								<button class="button button-black button-3d nomargin" type="submit">REPORT</button>
							@else
								<a href="" class="button button-green button-3d nomargin" data-toggle="modal" data-target="#login-modal">PLEASE LOG IN TO REPORT GOOD DEED</a>

								
							@endif

							
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
		

@if(!auth()->check())
	@include('pages.user.modals.login')
@endif
		

@endsection