		<!-- Header ============================================= -->
		<header id="header" class="full-header">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="{{ route('homepage') }}" class="standard-logo" data-dark-logo="{{ custom_asset('images/logo.png') }}">
							<img src="{{ custom_asset('images/logo.png') }}" alt="Canvas Logo">
						</a>

						<a href="{{ route('homepage') }}" class="retina-logo" data-dark-logo="{{ custom_asset('images/logo.png') }}">
							<img src="{{ custom_asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo">
						</a>
					</div><!-- #logo end -->

					@if(auth()->check())
						<div id="top-account" class="dropdown">
							<a href="#" class="btn btn-default dropdown-toggle mtn-7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="{{ auth()->user()->profile_picture() }}" alt="" class="img-circle size-35 mr-10">
								 <span class="mt-8">
								 	<small>{{ auth()->user()->fname }} </small>

								 	<i class="icon-angle-down"></i>
								 </span>
								 
								</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
								@if(!auth()->user()->is_admin())
								<li><a href="{{ route('user.donated-items.show', ['username' => auth()->user()->username]) }}">My Donated Items</a></li>
								<li><a href="{{ route('user.good-deeds.show', ['username' => auth()->user()->username]) }}">My Good Deeds</a></li>
								<li><a href="{{ route('user.show', ['username' => auth()->user()->username]) }}">My Profile</a></li>
								<li><a href="{{ route('user.items-bought.show', ['username' => auth()->user()->username]) }}">Items Bought</a></li>
								<li><a href="{{ route('user.settings') }}">Settings</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="{{ route('user.message', ['username' => auth()->user()->username, 'support' => 'true']) }}">Contact Admin</a></li>
								<li role="separator" class="divider"></li>
								@else
									<li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
								@endif


								<li><a href="{{ route('auth.logout') }}">Logout <i class="icon-signout"></i></a></li>
							</ul>
						</div>
					@endif

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu">
						
						<ul>
							<li>
								<a href="{{ route('homepage') }}">
									<small>Home</small>
								</a>
							</li>

							<li>
								<a href="{{ route('donate-item') }}">
									<small>Donate</small>
								</a>
							</li>

							

							<li>
								<a href="{{ route('community-shop') }}">
									<small>Community Shop</small>
								</a>
							</li>

							<li>
								<a href="{{ route('good-deeds') }}">
									<small>Good Deeds</small>
								</a>
							</li>

							@if(!auth()->check())
								<li>
									<a href="{{ route('auth.signup') }}">
										<small>Sign Up</small>
									</a>
								</li>

								<li>
									<a href="{{ route('auth.login') }}">
										<small>Login</small>
									</a>
								</li>

							@elseif(!auth()->user()->is_admin())
								<li>
									<a href="{{ route('user.balance') }}" title="Simba Coins">
										<img src="{{ simba_coin() }}" alt="Simba Coin" class="size-20">
										{{ number_format(auth()->user()->coins) }}
									</a>
								</li>

								<li>
									<a href="{{ route('user.messages') }}" class="user-messages" title="messages">
										<i class="fa fa-envelope h-15"></i>
										<small class="badge mtn-20 mrn-10">{{ auth()->user()->message_notifications()->where('read',0)->count() ? : '' }}</small>
									</a>
								</li>

								<li>
									<a href="{{ route('user.notifications') }}" class="user-notifications" title="notifications">
										<i class="fa fa-globe"></i>
										<small class="badge mtn-20 mrn-10">{{ auth()->user()->notifications()->where('read',0)->count() ? : '' }}</small>
									</a>
								</li>
							@endif

							

						</ul>

						

						

						<!-- Top Search
						============================================= -->

						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="search.html" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
							</form>
						</div><!-- #top-search end -->

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->