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
								

								

								<div style="background: url('images/world-map.png') no-repeat center center; background-size: 100%;">
									<address>
										<strong>tendawema.com</strong><br>
										P.o Box 24721-00100<br>
										Nairobi, Kenya<br>
									</address>
									
									<abbr title="Email Address"><strong>email:</strong></abbr> <a href="mailto:info@tendawema.com">info@tendawema.com</a>
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
									
									
									
								</ul>

							</div>

						</div>

						<div class="col_one_third col_last">

							<div class="widget clearfix">
								<h4>Recent Posts</h4>

								<div id="post-list-footer">
									<div class="spost clearfix">
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
											</div>
											<ul class="entry-meta">
												<li>10th July 2014</li>
											</ul>
										</div>
									</div>

									<div class="spost clearfix">
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
											</div>
											<ul class="entry-meta">
												<li>10th July 2014</li>
											</ul>
										</div>
									</div>

									
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
									<div class="counter counter-small"><span data-from="0" data-to="{{ App\User::count() }}" data-refresh-interval="50" data-speed="2000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Registered Users</h5>
								</div>

							</div>

						</div>

						

						<div class="widget clearfix" style="margin-bottom: -20px;">

							<div class="row">

								<div class="col-md-6 clearfix bottommargin-sm">
									<a href="#" class="social-icon si-dark si-colored si-facebook nobottommargin" style="margin-right: 10px;">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
									<a href="#"><small style="display: block; margin-top: 3px;"><strong>Like us</strong><br>on Facebook</small></a>
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
						Copyrights &copy; {{ date('Y') }} All Rights Reserved by tendawema.com<br>
						<div class="copyright-links"><a href="{{ route('terms-and-conditions') }}">Terms and Condiions</a> / <a href="{{ route('privacy-policy') }}">Privacy Policy</a></div>
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>



							<a href="#" class="social-icon si-small si-borderless si-linkedin">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>
						</div>

						<div class="clear"></div>

						<i class="icon-envelope2"></i> info@tendawema.com
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
	<script type="text/javascript" src="{{ custom_asset('js/tenda-wema.js') }}"></script>
	@if(auth()->check())
		<input type="hidden" id="message_count" value="{{ route('messages.count') }}">
		<input type="hidden" id="notification_count" value="{{ route('notifications.count') }}">

		<script type="text/javascript" src="{{ custom_asset('js/chat.js') }}"></script>
	@endif

</body>
</html>