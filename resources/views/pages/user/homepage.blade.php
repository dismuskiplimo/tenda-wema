@extends('layouts.user')

@section('content')
	<section id="slider" class="slider-parallax swiper_wrapper clearfix">

			<div class="slider-parallax-inner">

				<div class="swiper-container swiper-parent">
					<div class="swiper-wrapper">
						<div class="swiper-slide dark" style="background-image: url('{{ custom_asset('images/slider/swiper/4.jpg') }}');">
							<div class="container clearfix">
								<div class="slider-caption slider-caption-center">
									<h2 data-caption-animate="fadeInUp">{{ config('app.name') }}</h2>
									<p data-caption-animate="fadeInUp" data-caption-delay="200">The Simba Coin Community of good deeds.</p>
								</div>
							</div>
						</div>

						<div class="swiper-slide dark" style="background-image: url('{{ custom_asset('images/slider/swiper/1.jpg') }}');">
							<div class="container clearfix">
								<div class="slider-caption slider-caption-center">
									<h2 data-caption-animate="fadeInUp">{{ config('app.name') }}</h2>
									<p data-caption-animate="fadeInUp" data-caption-delay="200">Where you can donate items to the community.</p>
								</div>
							</div>
						</div>



						

						<div class="swiper-slide dark" style="background-image: url('{{ custom_asset('images/slider/swiper/3.jpg') }}'); background-position: center top;">
							<div class="container clearfix">
								<div class="slider-caption  slider-caption-center">
									<h2 data-caption-animate="fadeInUp">{{ config('app.name') }}</h2>
									<p data-caption-animate="fadeInUp" data-caption-delay="200">Where you report the good deeds you have done that have had a positive impact to the community.</p>
								</div>
							</div>
						</div>
					</div>
					<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
					<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
					<div id="slide-number"><div id="slide-number-current"></div><span>/</span><div id="slide-number-total"></div></div>
				</div>

			</div>

		</section>

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="promo promo-light promo-full bottommargin-lg header-stick notopborder">
					<div class="container clearfix">
						<h3>Donate to support more good deeds and economic opportunity.</h3>
						
						<a href="{{ route('support-the-cause') }}" class="button button-dark button-xlarge button-rounded">Support the cause</a>
					</div>
				</div>

				<div class="container clearfix">

					<div class="col_one_fourth nobottommargin">
						<div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
							<div class="fbox-icon">
								<a href="#"><i class="i-alt noborder icon-shop"></i></a>
							</div>
							<h3>Donate Items<span class="subtitle">Donate items to the community</span></h3>
						</div>
					</div>

					<div class="col_one_fourth nobottommargin">
						<div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
							<div class="fbox-icon">
								<a href="#"><i class="i-alt noborder icon-megaphone"></i></a>
							</div>
							<h3>Report Good Deeds<span class="subtitle">Report good deeds you performed</span></h3>
						</div>
					</div>

					<div class="col_one_fourth nobottommargin">
						<div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
							<div class="fbox-icon">
								<a href="#"><i class="i-alt noborder icon-wallet"></i></a>
							</div>
							<h3>Buy Donated Items<span class="subtitle">Purchase donated items from the community shop</span></h3>
						</div>
					</div>

					<div class="col_one_fourth nobottommargin col_last">
						<div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
							<div class="fbox-icon">
								<a href="#"><i class="i-alt noborder icon-comment"></i></a>
							</div>
							<h3>Discuss<span class="subtitle">Participate in the community discussions</span></h3>
						</div>
					</div>

					

					<div class="clear"></div><div class="line bottommargin-lg"></div>

					<div class="col_two_fifth nobottommargin">
						<img src="{{ custom_asset('images/tenda-wema/6.jpg') }}" class="img-responsive" alt="">

						
					</div>

					<div class="col_three_fifth nobottommargin col_last">

						<div class="heading-block">
							<h2>Why was {{ config('app.name') }} formed? </h2>
						</div>

						

						<div class="nobottommargin">
							<ul class="iconlist iconlist-color nobottommargin">
								<li><i class="icon-caret-right"></i> To give users a chance to donate their less frequently used items</li>
								<li><i class="icon-caret-right"></i> To give users ability to access  donated items</li>
								<li><i class="icon-caret-right"></i> To give users the ability to state the good deeds they have done that have positively impacted the society</li>
								<li><i class="icon-caret-right"></i> To provide a platform where well wishers can communicate</li>
								<li><i class="icon-caret-right"></i> To create a community for social good.</li>
							</ul>
						</div>

						

					</div>

					<div class="clear"></div>

				</div>

				<div class="section topmargin-lg">
					<div class="container clearfix">

						<div class="heading-block center">
							<h2>{{ config('app.name') }} Features</h2>
							<span>{{ config('app.name') }} comes with a variety of features that you will love.</span>
						</div>

						<div class="clear bottommargin-sm"></div>

						<div class="col_one_third">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn">
								<div class="fbox-icon">
									<a href="#"><i class="icon-phone"></i></a>
								</div>
								<h3>Donate items to the community</h3>
								<p>{{ config('app.name') }} allows you to donate items to the community.</p>
							</div>
						</div>

						<div class="col_one_third">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="200">
								<div class="fbox-icon">
									<a href="#"><i class="icon-cart"></i></a>
								</div>
								<h3>Purchase items from the community</h3>
								<p>{{ config('app.name') }} allows you to purchase items donated to the community using Simba Coins.</p>
							</div>
						</div>

						<div class="col_one_third col_last">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="400">
								<div class="fbox-icon">
									<a href="#"><i class="icon-comment"></i></a>
								</div>
								<h3>Community discussion</h3>
								<p>Members can participate in discussions and also post upcoming events.</p>
							</div>
						</div>

						<div class="clear"></div>

						<div class="col_one_third">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="600">
								<div class="fbox-icon">
									<a href="#"><i class="icon-user"></i></a>
								</div>
								<h3>Social Levels</h3>
								<p>{{ config('app.name') }} uses social levels to showcase the position of a member in the society through the good deeds done.</p>
							</div>
						</div>

						<div class="col_one_third">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="800">
								<div class="fbox-icon">
									<a href="#"><i class="icon-money"></i></a>
								</div>
								<h3>MPESA Support</h3>
								<p>{{ config('app.name') }} allows purchase of Simba Coins through  MPESA in case you have insufficient Simba Coins to purchase an item.</p>
							</div>
						</div>

						<div class="col_one_third col_last">
							<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1000">
								<div class="fbox-icon">
									<a href="#"><i class="icon-email"></i></a>
								</div>
								<h3>Email Notifications</h3>
								<p>{{ config('app.name') }} uses email notifications to alert you whenever changes are made.</p>
							</div>
						</div>

						

						<div class="clear"></div>

					</div>
				</div>

				{{-- <div class="container clearfix">

					<div class="heading-block center">
						<h3>Some of our <span>Featured</span> Works</h3>
						<span>We have worked on some Awesome Projects that are worth boasting of.</span>
					</div>

					<div id="oc-portfolio" class="owl-carousel portfolio-carousel portfolio-nomargin carousel-widget" data-margin="1" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-xs="2" data-items-sm="3" data-items-lg="4">

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/1.jpg" alt="Open Imagination">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/1.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Open Imagination</a></h3>
									<span><a href="#">Media</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/2.jpg" alt="Locked Steel Gate">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/2.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Locked Steel Gate</a></h3>
									<span><a href="#">Illustrations</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="#">
										<img src="images/portfolio/4/3.jpg" alt="Mac Sunglasses">
									</a>
									<div class="portfolio-overlay">
										<a href="http://vimeo.com/89396394" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Mac Sunglasses</a></h3>
									<span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/5.jpg" alt="Console Activity">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/5.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Console Activity</a></h3>
									<span><a href="#">UI Elements</a>, <a href="#">Media</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single-video.html">
										<img src="images/portfolio/4/7.jpg" alt="Backpack Contents">
									</a>
									<div class="portfolio-overlay">
										<a href="http://www.youtube.com/watch?v=kuceVNBTJio" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Backpack Contents</a></h3>
									<span><a href="#">UI Elements</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/8.jpg" alt="Sunset Bulb Glow">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/8.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Sunset Bulb Glow</a></h3>
									<span><a href="#">Graphics</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single-video.html">
										<img src="images/portfolio/4/10.jpg" alt="Study Table">
									</a>
									<div class="portfolio-overlay">
										<a href="http://vimeo.com/91973305" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Study Table</a></h3>
									<span><a href="#">Graphics</a>, <a href="#">Media</a></span>
								</div>
							</div>
						</div>

						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/11.jpg" alt="Workspace Stuff">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/11.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Workspace Stuff</a></h3>
									<span><a href="#">Media</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="section topmargin-sm nobottommargin">

					<div class="container clearfix">

						<div class="heading-block center">
							<h3>Testimonials</h3>
							<span>Check out some of our Client Reviews</span>
						</div>

						<ul class="testimonials-grid grid-3 clearfix nobottommargin">
							<li>
								<div class="testimonial">
									<div class="testi-image">
										<a href="#"><img src="images/testimonials/1.jpg" alt="Customer Testimonails"></a>
									</div>
									<div class="testi-content">
										<p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum repellendus!</p>
										<div class="testi-meta">
											John Doe
											<span>XYZ Inc.</span>
										</div>
									</div>
								</div>
							</li>
							
							<li>
								<div class="testimonial">
									<div class="testi-image">
										<a href="#"><img src="images/testimonials/2.jpg" alt="Customer Testimonails"></a>
									</div>
									<div class="testi-content">
										<p>Natus voluptatum enim quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
										<div class="testi-meta">
											Collis Ta'eed
											<span>Envato Inc.</span>
										</div>
									</div>
								</div>
							</li>
							
							<li>
								<div class="testimonial">
									<div class="testi-image">
										<a href="#"><img src="images/testimonials/7.jpg" alt="Customer Testimonails"></a>
									</div>
									<div class="testi-content">
										<p>Fugit officia dolor sed harum excepturi ex iusto magnam asperiores molestiae qui natus obcaecati facere sint amet.</p>
										<div class="testi-meta">
											Mary Jane
											<span>Google Inc.</span>
										</div>
									</div>
								</div>
							</li>
							
							

						</ul>

					</div>

				</div> --}}

				<div class="container clearfix">

					<div id="oc-clients" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="30" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xxs="2" data-items-xs="3" data-items-sm="4" data-items-md="5" data-items-lg="6" style="padding: 20px 0;">

						<div class="oc-item">
							<a href="#">
								<img src="{{ custom_asset('images/tenda-wema/1.png') }}" alt="Partners"></a>
							</div>
						
						

					</div>

				</div>

				<a class="button button-full center tright footer-stick" href="{{ route('how-it-works') }}">
					<div class="container clearfix">
						See How {{ config('app.name') }} <strong>Works</strong> <i class="icon-caret-right" style="top:4px;"></i>
					</div>
				</a>

			</div>

		</section>
@endsection