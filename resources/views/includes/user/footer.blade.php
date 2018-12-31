<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">

			<div class="container">

				<!-- Footer Widgets
				============================================= -->
				<div class="footer-widgets-wrap clearfix">

					<div class="col_two_third">

						<div class="col_one_third">

							<div class="widget clearfix">

								<div class="text-center">
									<a href="{{ route('homepage') }}">
										<img src="{{ custom_asset('images/og-logo.png') }}" alt="" class="footer-logo">	
									</a>
									
								</div>
								

								

								<div style="background: url({{ custom_asset('images/world-map.png') }}) no-repeat center center; background-size: 100%;">
									<address>
										<strong>{{ config('app.name') }}</strong><br>
										View Park Towers, Utalii Street <br><br>
										P.o Box 24721-00100<br>
										Nairobi, Kenya<br>
									</address>
									
									<abbr title="Email Address"><strong>email:</strong></abbr> <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a>
								</div>

							</div>

						</div>

						<div class="col_one_third">

							<div class="widget widget_links clearfix">

								<h4>Useful links</h4>

								<ul>
									<li><a href="{{ route('support-the-cause') }}">Support the Cause</a></li>
									<li><a href="{{ route('about-us') }}">About Us</a></li>
									<li><a href="{{ route('contact-us') }}">Contact Us</a></li>
									<li><a href="{{ route('how-it-works') }}">How it Works</a></li>
									<li><a href="{{ route('registered-members') }}">Registered Members</a></li>
									
									
									
								</ul>

							</div>

						</div>

						<div class="col_one_third col_last">

							<div class="widget clearfix">
								{{-- <h4>Latest Posts</h4>

								@php
									$posts = \App\Post::orderBy('created_at','DESC')->limit(3)->get();
								@endphp

								@if(count($posts))
									<div id="post-list-footer">
										@foreach($posts as $post)
											<div class="spost clearfix">
												<div class="entry-c">
													<div class="entry-title">
														<h4><a href="{{ route('post', ['slug' => $post->slug]) }}">{{ characters($post->title, '30') }}</a></h4>
													</div>
													<ul class="entry-meta">
														<li>{{ simple_datetime($post->created_at) }}</li>
													</ul>
												</div>
											</div>
										@endforeach
											
									</div>

									<br><p>
										<a href="{{ route('posts') }}">See all posts</a>
									</p>
									
								@else
									<p>No Recent Posts</p>
								@endif --}}

								<div class="col-md-12 bottommargin-sm">
									<div class="counter counter-small"><span data-from="0" data-to="{{ App\GoodDeed::where('approved', 1)->count() }}" data-refresh-interval="80" data-speed="3000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Good Deeds</h5>
								</div>

								
							</div>

						</div>

					</div>

					<div class="col_one_third col_last">

						<div class="widget clearfix" style="margin-bottom: -20px;">

							<div class="row">

								<div class="col-md-6 bottommargin-sm">
									<div class="counter counter-small"><span data-from="0" data-to="{{ App\DonatedItem::count() }}" data-refresh-interval="80" data-speed="3000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Items Donated</h5>
								</div>

								<div class="col-md-6 bottommargin-sm">
									<div class="counter counter-small"><span data-from="0" data-to="{{ App\User::where('usertype', 'USER')->count() }}" data-refresh-interval="50" data-speed="2000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Registered Users</h5>
								</div>

							</div>

						</div>

						

						<div class="widget clearfix" style="margin-bottom: -20px;">

							<div class="row">

								<div class="col-md-6 clearfix bottommargin-sm">
									<small>
										<ul>
											<li>
												<a href="https://www.facebook.com/tendawemacommunity/"  target="_blank"><i class="fa fa-facebook" style="margin-right: 9px"></i> Like us on Facebook</a>
											</li>

											<li>
												<a href="https://twitter.com/tendawema_com"  target="_blank"><i class="fa fa-twitter mr-5"></i> Follow us on Twitter</a>
											</li>

											<li>
												<a href="https://www.instagram.com/tendawema_com"  target="_blank"><i class="fa fa-instagram mr-5"></i> Follow us on Instagram</a>
											</li>
										</ul>


									</small>



									


								</div>
								

							</div>

						</div>

					</div>

				</div><!-- .footer-widgets-wrap end -->

			</div>

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_half">
						Copyright &copy; {{ date('Y') }} All Rights Reserved by {{ config('app.domain') }}<br>
						<div class="copyright-links"><a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a> / <a href="{{ route('privacy-policy') }}">Privacy Policy</a></div>
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="https://www.facebook.com/tendawemacommunity/" target="_blank" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="https://twitter.com/tendawema_com"  target="_blank" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>



							<a href="https://www.instagram.com/tendawema_com"  target="_blank" class="social-icon si-small si-borderless si-instagram">
								<i class="icon-instagram"></i>
								<i class="icon-instagram"></i>
							</a>
						</div>

						<div class="clear"></div>

						<i class="icon-envelope2"></i> {{ config('app.contact_email') }}
					</div>

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="{{ custom_asset('js/jquery-2.1.4.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/plugins.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/jquery.fancybox.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/remodal.min.js') }}"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="{{ custom_asset('js/user/functions.js') }}"></script>

	<script type="text/javascript" src="{{ custom_asset('js/cropper.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/jquery.cropit.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/jquery.color.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/jquery.Jcrop.min.js') }}"></script>

	<script type="text/javascript" src="{{ custom_asset('js/exif.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/croppie.min.js') }}"></script>

	<script type="text/javascript" src="{{ custom_asset('js/sweetalert-2.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/remodal.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/tenda-wema.js') }}"></script>
	
	@if(auth()->check())
		<input type="hidden" id="message_count" value="{{ route('messages.count') }}">
		<input type="hidden" id="notification_count" value="{{ route('notifications.count') }}">

		<script type="text/javascript" src="{{ custom_asset('js/chat.js') }}"></script>
	@endif

</body>
</html>