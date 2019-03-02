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
				<h4>OUR STORY</h4> 

				<p>
					Just over a year ago, we became fascinated by the idea of creating value from less used items that lie idle in boxes, cupboards, wardrobes, drawers, attics, garages and basements in homes and offices. What if you could derive value from a computer laptop or an academic text book that another person was not using anymore? Or help someone else derive value from your sports shoes or scooter bike you do not use anymore? The possibilities are endless and the impact of value co-creation immense.

				</p>

				<p>
					We then embarked on creating a platform that would enable individuals give their idle items to others who need them and likewise get items they need given by others. In essence creating value from previously inherent idle items and facilitating exchange without consideration. Our innovation as a result of the creative process to actualize this idea is {{ config('app.name') }}: The Simba Coin Community of good deeds. Tim Maber Limited is principally a transformative social enterprise creating a socio-economic community that care, give and do good.
				</p>

				<h4>VISION</h4>

				<p>
					The most impactful and transformative social enterprise in communities.
				</p>

				<h4>MISSION</h4> 

				<p>
					Harnessing the power of technology and social good to inspire individuals to care, give and do good uplifting their lives and transforming communities.
				</p>

				<h4>CORE VALUES</h4> 

				<p>
					These five core values embody our culture, spirit and dedication to doing what’s right. They keep us aligned to our vision and define our actions including donations we accept and partners we engage with.
				</p>

				<ul style="list-style-type: circle; margin-left: 20px">
					<li><i>Efficiency</i> : Deliver what you've committed to faster and better than what is expected.</li>
					<li><i>Innovativeness</i> : Create solutions that add value to the company and the community.</li>
					<li><i>Impactful</i> : Leave people and communities better than you found them.</li>
					<li><i>Transformative</i> : Create a ripple effect of lasting change in people and communities.  </li>
					<li><i>Sustainability</i> : Make decisions that have a positive effect on your environment and last longer than you will.</li>
				</ul>

				

				<h4>OBJECTIVES</h4>

				<p>
					These four objectives define our company strategy and determine our key strategic initiatives. They help us align our activities to our mission and in the long run to our vision.

					
				</p> 

				<ul style="list-style-type: circle; margin-left: 20px">
					<li>
						<i>To inspire a culture of doing good:</i> No matter how big or small, good deeds carry a double punch, people make a positive impact and they feel great at the same time. 
					</li>
					
					<li>
						<i>To provide a source of essential items:</i> People can obtain many of the things they need using Simba Coins giving them purchasing power not dependent on availability of money. 
					</li>
					
					<li>
						<i>To encourage donation of items:</i> People can donate their idle and less used items to the community for others to purchase and draw value from them. 
					</li>
					
					<li>
						<i>To promote prosperity and sustainability:</i> Unlike money, which leaves communities when it is spent, Simba Coins circulate in the Community promoting consumption within.
					</li>
				</ul>

				
					

				

				<h4>CONTACTS</h4>

				<address>
					
					Director <br>

					{{ config('app.company') }} <br>

					P. O. Box 24721-00100

				</address> 				


			</div>
		</div>
	</div>
		

		

@endsection