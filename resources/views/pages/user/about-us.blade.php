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
		<div class="row  my-50">
			<div class="col-sm-10 col-sm-offset-1">
				<h4>INTRODUCTION</h4> 

				<p>
					{{ config('app.name') }} is a social group where members earn Simba Coins for doing good deeds that positively impact their own local communities. Members can then use the Simba Coins (virtual social currency) earned to buy items donated by members to the Community instead of money. Members advance social levels and maintain their social status in the Community by accumulating Simba Coins earned for performing even more good deeds.
				</p>

				<h4>MISSION STATEMENT</h4>

				<p>
					Harnessing the power of technology and community to deliver the most robust social platform that engage, inspire and empower people to uplift their lives and improve the community they live in.
				</p>

				<h4>VISION STATEMENT</h4> 

				<p>
					Celebrating the transformative power of {{ config('app.name') }} in the lives of individuals, families, organizations and communities.
				</p>

				

				<h4>OBJECTIVES</h4>

				<p>
					The overall objective of {{ config('app.name') }} is to harness the power and benefits of acting positively and helping others in our communities. Specific objectives of {{ config('app.name') }} are: 
				</p> 

				<ul style="list-style-type: circle; margin-left: 20px">
					<li>
						To inspire a culture among members of doing good deeds. No matter how big or small, good deeds carry a double punch – members make a positive impact and they feel great at the same time. 
					</li>

					<li>
						To provide an additional source of essential products. Members can obtain many of the things they need using Simba Coins giving them purchasing power not dependent on availability of money.
					</li>

					<li>
						To encourage donation of items by members to the community. Members can donate their idle and less used items to the community for other members to purchase and draw value from them. 
					</li>

					<li>
						To promote prosperity and sustainability in our Community. Unlike money, which leaves communities when it is spent, Simba Coin can be used only within {{ config('app.name') }}, always circulating among members and promoting consumption within the Community.
					</li>
				</ul>

				

				<h4>WHAT IS SIMBA COIN? </h4>
				<p>
					Simba Coins are rewards that members receive for donating items to {{ config('app.name') }}, for doing good deeds and for participating in social programmes and community projects. Simba Coins can be used by members to acquire items donated to the Community. By accumulating Simba Coins, members can advance social levels within the Community, unlocking more Simba Coins and benefits along the way. Members can also lose Simba Coins by engaging in prohibited behavior. 
				</p>

				<p>
					Simba Coin is valuable only because all members of {{ config('app.name') }} agree to accept it as a reward for doing good deeds and for purchases within the Community. Simba Coin has no inherent value and is not convertible into real money or pegged to any real currency or commodity. Simba Coin does not exist in paper or coin form.
				</p>

				<h4>CHARGES</h4>

				<p>
					{{ config('app.name') }} is a social community that is free to use for individuals, families, businesses and organizations. {{ config('app.name') }} only sells Simba Coin to members wishing to increase their Simba Coin balance so as to purchase an item in the Community Shop. Simba Coins SHALL not be sold to members to accelerate their movement through social levels within the Community. {{ config('app.name') }} relies on funds received from donors and well-wishers to meet its administrative and operational costs.
				</p>


				

				

				

				 

				


			</div>
		</div>
	</div>
		

		

@endsection