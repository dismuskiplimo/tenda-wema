@extends('layouts.user')

@section('content')
		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Community Shop</h1>
				<span>Purchase Donated Items</span>
				<ol class="breadcrumb">
					<li><a href="{{ route('homepage') }}">Home</a></li>
					<li class="active">Shop</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Shop
					============================================= -->
					<div id="shop" class="shop grid-container clearfix" data-layout="fitRows">

						@if($donated_items->total())
							@foreach($donated_items as $item)
								@php
									$banner = item_banner();

									if($item->images){
										$donated_item_image = $item->images()->first();

										if($donated_item_image){
											$banner 		= $donated_item_image->banner();
										}
										
									}
								@endphp

								<div class="product clearfix">
									<div class="product-image"   style="box-shadow: 0px 0px 12px #ccc">
										<a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">
											<img src="{{ $banner }}" alt="{{ $item->name }}">
										</a>
										
									</div>
									<div class="product-desc"  style="box-shadow: 0px 0px 12px #ccc">
										<div style="padding-left:10px">
												<div class="product-title mb-0"><h3><a href="{{ route('donated-item.show', ['slug' => $item->slug]) }}">{{characters($item->name, 20)}}</a></h3></div>
											
											<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
											
											<div class="product-price mt-5">
												
												<ins>
													<img src="{{ custom_asset('images/simba-coin.png') }}" alt="" class="size-25 mtn-3"> 
														{{ $item->price }} <small class="lato">Simba Coins</small>
												</ins>
											</div>	
										</div>
										
										
									</div>
								</div>		
							@endforeach
						@else
							<h3 class="">No Items Available</h3>
						@endif

						

					</div><!-- #shop end -->

				</div>

			</div>

		</section><!-- #content end -->

@endsection