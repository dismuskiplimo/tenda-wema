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
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1 text-justify">
				<h4>THE COMMUNITY</h4>

				<p>
					<strong>{{ config('app.domain') }}</strong> is the Simba Coin Community of good deeds. It’s an online social community where members earn Simba Coins for doing good deeds that positively impact their own local communities and for participating in social programmes and community projects.  <strong>{{ config('app.company') }}</strong> seeks to harness the power and benefits of acting positively and helping others in our communities. 
				</p>

				<h4>HOW THE COMMUNITY WORKS</h4>
				<p>
					<strong>{{ config('app.domain') }}</strong> encourages members to do good deeds earning Simba Coins that provide purchasing power and advancement through social levels within the Community. For example, Kellen joins the Community and is immediately awarded 30 Simba Coins and additional 20 Simba Coins for completing her profile. She then donates a laptop and a book to the Community earning 200 Simba Coins bringing her total Simba Coins to 250. She later participates in a fund raising drive earning 100 Simba Coins, volunteers in a charity programme earning 100 Simba Coins and donates blood earning 100 Simba Coins. Now with a total of 550 Simba Coins, she purchases a handbag donated to the Community for 100 Simba Coins leaving her with a balance of 450 Simba Coins. Over time, Kellen continues to do good deeds earning additional Simba Coins and moving from one social level to the next with the ultimate goal of reaching the highest social level within the Community.
				</p>

				<h4>DONATING ITEMS TO THE COMMUNITY</h4>

				<p>
					A member can donate an item to the Community for purchase by other members. A member making the donation should complete and submit the <a href="{{ route('donate-item') }}">DONATE ITEM</a>  form. A member who donates an item to the Community is awarded Simba Coins to gain additional purchasing power and to help them move toward reaching the next social level.  
				</p>

				<h4>REPORTING A GOOD DEED</h4>

				<p>
					A member can report their acts of good deeds including participation in a sustainable social program, corporate social responsibility activity or community project initiative either individually or as teams.  A member who does a good deed should complete and submit the <a href="{{ route('report-a-good-deed') }}">GOOD DEED REPORT</a> form. A member whose submission is approved is awarded Simba Coins to gain additional purchasing power and to help them move toward reaching the next social level.
				</p>

				<h4>PURCHASING FROM THE COMMUNITY SHOP</h4>
				<p>
					Members seeking to purchase items in the Community Shop should accumulate Simba Coins equivalent to the purchase price assigned to the item. To make a purchase, a member should visit the <a href="{{ route('community-shop') }}">COMMUNITY SHOP</a> and purchase the item and the Administrator will be alerted to facilitate the process. The member buying the item will be deducted an equivalent amount of Simba Coins from their Simba Coins total and advised on how to get the purchased item.
				</p>

				<h4>SIMBA COINS</h4>
				<p>
					Simba Coins are rewards that members receive for donating items to {{ config('app.name') }}, for doing good deeds and for participating in social programmes and community projects. Simba Coins can be used by members to acquire items donated to the Community. By accumulating Simba Coins, members can advance social levels within the Community, unlocking more Simba Coins and benefits along the way. Members can also lose Simba Coins by engaging in prohibited behavior.
	
				</p>

				<p>
					Simba Coin is valuable only because all members of {{ config('app.name') }} agree to accept it as a reward for doing good deeds and for purchases within the Community. Simba Coin has no inherent value and is not convertible into real money or pegged to any real currency or commodity. Simba Coin does not exist in paper or coin form. A member earns Simba Coins increasing their spending power and advancing social levels as indicated below: 
				</p>

				<table class="table table-striped">
					<thead>
						<tr class="bg-theme">
							<th>Deed</th>
							<th class="text-right">Simba Coins Earned</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>Joining the Community</td>
							<td class="text-right">{{ config('coins.earn.join_community') }}</td>
						</tr>

						<tr>
							<td>Completing Profile</td>
							<td class="text-right">{{ config('coins.earn.complete_profile') }}</td>
						</tr>

						<tr>
							<td>Reviewing an Item in the Community Shop</td>
							<td class="text-right">{{ config('coins.earn.reviewing_item') }}</td>
						</tr>

						<tr>
							<td>Rating another member in the Community</td>
							<td class="text-right">{{ config('coins.earn.rating_member') }}</td>
						</tr>

						<tr>
							<td>Donating an Item to the Community</td>
							<td class="text-right">{{ config('coins.earn.donating_item') }}</td>
						</tr>

						<tr>
							<td>Doing a Good Deed that positively impact the Society</td>
							<td class="text-right">{{ config('coins.earn.good_deed') }}</td>
						</tr>

						<tr>
							<td>Receive the Annual Most Active Member Award </td>
							<td class="text-right">{{ config('coins.earn.annual_most_active_member') }}</td>
						</tr>

						<tr>
							<td>Receive the Annual Community Member Award</td>
							<td class="text-right">{{ config('coins.earn.annual_community_member') }}</td>
						</tr>

						<tr>
							<td>Advancement from Mwanzo to Uungano Social Level</td>
							<td class="text-right">{{ config('coins.earn.mwanzo_uungano') }}</td>
						</tr>

						<tr>
							<td>Advancement from Uungano to Stahimili Social Level</td>
							<td class="text-right">{{ config('coins.earn.uungano_stahimili') }}</td>
						</tr>

						<tr>
							<td>Advancement from Stahimili to Shupavu Social Level</td>
							<td class="text-right">{{ config('coins.earn.stahimili_shupavu') }}</td>
						</tr>

						<tr>
							<td>Advancement from Shupavu to Hodari Social Level</td>
							<td class="text-right">{{ config('coins.earn.shupavu_hodari') }}</td>
						</tr>

						<tr>
							<td>Advancement from Hodari to Shujaa Social Level</td>
							<td class="text-right">{{ config('coins.earn.hodari_shujaa') }}</td>
						</tr>

						<tr>
							<td>Advancement from Shujaa to Bingwa Social Level</td>
							<td class="text-right">{{ config('coins.earn.shujaa_bingwa') }}</td>
						</tr>
					</tbody>
				</table>

				<h4>SOCIAL LEVEL</h4>

				<p>
					A badge is displayed on every member’s profile indicating his or her social level. The social levels are Mwanzo, Uungano, Stahimili, Shupavu, Hodari, Shujaa and Bingwa. Badges reflect a member’s experience in the Community, as well as that member’s level of achievement and positive engagement within the Community. To advance to the next social level a member must accumulate a certain number of Simba Coins
				</p>

				<h4>Badges</h4>

				<div class="row text-center">
					<div class="col-sm-3">
						<img src="{{ social_badge('MWANZO') }}" alt="" class="h-100 w-auto mb-20">
						<p>Mwanzo Social Level</p>
					</div>

					<div class="col-sm-3">
						<img src="{{ social_badge('UUNGANO') }}" alt="" class="h-100 w-auto mb-20">
						<p>Uungano Social Level</p>
					</div>

					<div class="col-sm-3">
						<img src="{{ social_badge('STAHIMILI') }}" alt="" class="h-100 w-auto mb-20">
						<p>Stahimili Social Level</p>
					</div>

					<div class="col-sm-3">
						<img src="{{ social_badge('SHUPAVU') }}" alt="" class="h-100 w-auto mb-20">
						<p>Shupavu Social Level</p>
					</div>
				</div>

				<div class="row text-center">

					<div class="col-sm-3">
						<img src="{{ social_badge('HODARI') }}" alt="" class="h-100 w-auto mb-20">
						<p>Hodari Social Level</p>
					</div>

					<div class="col-sm-3">
						<img src="{{ social_badge('SHUJAA') }}" alt="" class="h-100 w-auto mb-20">
						<p>Shujaa Social Level</p>
					</div>

					<div class="col-sm-3">
						<img src="{{ social_badge('BINGWA') }}" alt="" class="h-100 w-auto mb-20">
						<p>Bingwa Social Level</p>
					</div>
				</div>

				<h4>CHARGES</h4>
				<p>
					<strong>{{ config('app.domain') }}</strong> is free to use for individuals, families, businesses and organizations. <strong>{{ config('app.company') }}</strong> only sells Simba Coin (Kshs. 10 for each Simba Coin bought) to members wishing to increase their Simba Coin balance so as to purchase an item in the Community Shop.  Simba Coins SHALL not be sold to members to accelerate their movement through social levels within the Community. <strong>{{ config('app.company') }}</strong> relies on funds received from donors and well-wishers to meet its administrative and operational costs. 
				</p>



			</div>
		</div>
	</div>
		

		

@endsection