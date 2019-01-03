@extends('layouts.email')

@section('content')
	<p>{{ $user->fname }},</p>

	<h4>Welcome to {{ config('app.name') }}</h4>

	<p>
		{{ config('app.name') }} is a social group where members earn Simba Coins for doing good deeds that positively impact their own local communities. Members can then use the Simba Coins (virtual social currency) earned to buy items donated by members to the Community instead of money. Members advance social levels and maintain their social status in the Community by accumulating Simba Coins earned for performing even more good deeds.
	</p>

	<h4>MISSION STATEMENT</h4>

	<p>
		Harnessing the power of technology and community to deliver the most robust social platform that engage, inspire and empower people to uplift their lives and improve the community they live in.
	</p>

	<h4>VISION STATEMENT</h4>

	<p>
		Celebrating the transformative power of Tenda Wema in the lives of individuals, families, organizations and communities.

	</p>

	<h4>OBJECTIVES</h4>

	<p>
		The overall objective of {{ config('app.name') }} is to harness the power and benefits of acting positively and helping others in our communities.
	</p>

	
@endsection