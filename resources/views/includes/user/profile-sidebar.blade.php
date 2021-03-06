<div class="card">
	<div class="card-body">

		@if(auth()->check() && auth()->user()->id == $user->id)
			{{-- <a href="" data-toggle = "modal" data-target="#edit-profile-pic"> --}}
				<img src="{{ $user->profile_picture() }}" alt="" class="img-responsive mb-30 profile-picture img-circle" title="Click to update">
			{{-- </a> --}}



			{{-- @include('pages.user.modals.edit-profile-pic') --}}
			

			<form action="{{ route('user.profile-picture.update') }}" class="hidden profile-picture-form" method="POST" enctype="multipart/form-data">
				@csrf

				<input type="file" class="profile-picture-file" name="image" accept="image/*" />

				<div class="cropper">
					<img src="" alt="">
				</div>
			</form>	
		@else
			<img src="{{ $user->profile_picture() }}" alt="{{ $user->name }}" class="img-responsive img-circle mb-30">
		@endif

		<h5 class=" text-center nobottommargin" {!! $user->verified ? 'title = "Verified"' : '' !!}>{{ $user->name }} {!! $user->verified ? '<i class = "fa fa-check text-success" title = "Verified"></i>' : '' !!}</h5>

		@php
			$user->check_profile();

			$stars = $user->reviews ? ($user->rating / $user->reviews) : 0;

			$stars = $stars == 5 ? 5 : floor($stars);
			
			$profile = $user->profile;

			$profile_elements = $user->elements();
            
            $profile_sum = $user->sections_complete();

			$profile_percent = ($profile_sum / $profile_elements) * 100;

			$profile_percent = floor($profile_percent);

			$last_community_member_award = $user->community_member_awards()->where('revoked', 0)->orderBy('award_year', 'desc')->first();
        	
        	$last_most_active_member_award = $user->most_active_member_awards()->where('revoked', 0)->orderBy('award_year', 'desc')->first();

        	$date = \Carbon\Carbon::now();
		@endphp

		<p class="text-center">
			{!! $user->stars() !!}
		</p>
		
		<div class="row">
			<div class="col-sm-4 text-center">
				<img src="{{ $user->badge() }}" alt="{{ $user->name }} Badge" class="h-75"> <br>
				<small class="tiny nobottommargin">{{ strtoupper($user->social_status()) }}</small>
			</div>

			
			@if($last_most_active_member_award)
				@if($date->lte($last_most_active_member_award->valid_until))
					
					<div class="col-sm-4 text-center">
						
						<img src="{{ most_active_member_award_badge() }}" alt="" class="h-75">

						<small class="tiny nobottommargin">MOST ACTIVE MEMBER {{ $last_most_active_member_award->award_year }}</small>

					</div>

				@endif
			@endif


			@if($last_community_member_award)
				@if($date->lte($last_community_member_award->valid_until))
					<div class="col-sm-4 text-center">

						<img src="{{ community_member_award_badge() }}" alt="" class="h-75">

						
						
						<small class="tiny nobottommargin">COMMUNITY MEMBER {{ $last_community_member_award->award_year }}</small>

					</div>
					
				@endif
			@endif
			
		</div>

		

		<div class="progress my-20">
		  <div class="progress-bar" role="progressbar" aria-valuenow="{{ $profile_percent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $profile_percent }}%;">
		    {{ $profile_percent }}% Complete
		  </div>
		</div>

		<p class="text-center mb-0">
			<small>Profile Completion ({{ $profile_percent }}%)</small>
		</p>

		<p class="text-center">
			@if(auth()->check())
				@if((auth()->user()->id != $user->id) && !auth()->user()->is_admin())
					<a href="{{ route('user.message', ['username' => $user->username]) }}" class="btn btn-xs btn-info"><i class="fa fa-envelope"></i> Send Message</a> <br> <br>

					<a href = "" data-toggle = "modal" data-target = "#report-user" class="btn btn-xs btn-danger"><i class="fa fa-bullhorn"></i> Report User</a>

					@include('pages.user.modals.report-user')
				@endif
			@else
				<a href="" data-toggle = "modal" data-target = "#login-modal" class="btn btn-xs btn-info"><i class="fa fa-sign-in"></i> Log in to message</a> 

				@include('pages.user.modals.login')
			@endif
		</p>

		<hr>

		<p class="text-muted nobottommargin">
			<small>
				<strong>Joined</strong>	 <span class="pull-right"> <small>{{ simple_datetime($user->created_at) }}</small></span>
			</small>
		</p>

		<hr>

		<p class="text-muted nobottommargin">
			<small>
				<strong>Views</strong>	 <span class="pull-right"> <small>{{ number_format($user->views) }}</small></span>
			</small>
		</p>

		<hr>

		<ul class="nav nav-stacked nav-pills ctext-left">
			<li class="{{ isset($nav) && $nav == 'user-timeline' ? ' active' : '' }}">
				<a href="{{ route('user.show', ['username' => $user->username]) }}"><i class="fa fa-list"></i> Timeline</a>
			</li>

			<li class="{{ isset($nav) && $nav == 'user-about' ? ' active' : '' }}">
				<a href="{{ route('user.about-me.show', ['username' => $user->username]) }}"><i class="fa fa-info-circle"></i> About {{ $user->fname }}</a>
			</li>

			<li class="{{ isset($nav) && $nav == 'user-donated-items' ? ' active' : '' }}">
				<a href="{{ route('user.donated-items.show', ['username' => $user->username]) }}"><i class="fa fa-gift"></i> Donated Items</a>
			</li>

			<li class="{{ isset($nav) && $nav == 'user-good-deeds' ? ' active' : '' }}">
				<a href="{{ route('user.good-deeds.show', ['username' => $user->username]) }}"><i class="fa fa-smile-o"></i> Good Deeds</a>
			</li>

			<li class="{{ isset($nav) && $nav == 'user-photos' ? ' active' : '' }}">
				<a href="{{ route('user.photos.show', ['username' => $user->username]) }}"><i class="fa fa-file-image-o"></i> Photos</a>
			</li>

			<li class="{{ isset($nav) && $nav == 'user-reviews' ? ' active' : '' }}">
				<a href="{{ route('user.reviews.show', ['username' => $user->username]) }}"><i class="fa fa-star"></i> Reviews</a>
			</li>
		</ul>

	</div>
</div>