<div class="card">
	<div class="card-body">
		@if(auth()->check() && auth()->user()->id == $user->id)
			<img src="{{ $user->profile_picture() }}" alt="" class="img-responsive mb-30 profile-picture img-circle" title="Click to update">

			<form action="{{ route('user.profile-picture.update') }}" class="hidden profile-picture-form" method="POST" enctype="multipart/form-data">
				@csrf

				<input type="file" class="profile-picture-file" name="image" accept="image/*" />
			</form>	
		@else
			<img src="{{ $user->profile_picture() }}" alt="{{ $user->name }}" class="img-responsive img-circle mb-30">
		@endif

		<h5 class=" text-center" {!! $user->verified ? 'title = "Verified"' : '' !!}>{{ $user->name }} {!! $user->verified ? '<i class = "fa fa-check text-success" title = "Verified"></i>' : '' !!}</h5>
		
		<p class=" text-center">
			<img src="{{ $user->badge() }}" alt="{{ $user->name }} Badge" class="size-30"> <br>
			{{ $user->social_status() }}
		</p>

		<p class="text-center">
			@if(auth()->check())
				@if((auth()->user()->id != $user->id) && !auth()->user()->is_admin())
					<a href="{{ route('user.message', ['username' => $user->username]) }}" class="btn btn-xs btn-info"><i class="fa fa-envelope"></i> Send Message</a>
				@endif
			@else
				<a href="" class="btn btn-xs btn-info"><i class="fa fa-sign-in"></i> Log in to message</a>
			@endif
		</p>

		<hr>

		<p class="text-muted">
			<small>
				<strong>Joined</strong>	 <br> {{ simple_datetime($user->created_at) }}
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