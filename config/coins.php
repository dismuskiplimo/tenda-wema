<?php

return [
	'donated_item' =>[
		'price'		=> 100,
	],

	'earn' => [
		'join_community' 			=> 30,
		'complete_profile' 			=> 20,
		'reviewing_item' 			=> 10,
		'rating_member' 			=> 10,
		'donating_item' 			=> 100,
		'good_deed' 				=> 100,
		'annual_most_active_member' => 100,
		'annual_community_member'	=> 200,
		'mwanzo_uungano'			=> 100,
		'uungano_stahimili'			=> 200,
		'stahimili_shupavu'			=> 300,
		'shupavu_hodari'			=> 350,
		'hodari_shujaa'				=> 400,
		'shujaa_bingwa'				=> 500,
	],

	'lose' => [
		'post_flagged'	=> [
			'first_instance'	=> 20,
			'second_instance'	=> 30,
			'third_instance'	=> 50,
			'forth_instance'	=> 100,
		],

		'media_flagged'	=> [
			'first_instance'	=> 20,
			'second_instance'	=> 30,
			'third_instance'	=> 50,
			'forth_instance'	=> 100,
		],

		'inappropriate_language'=> [
			'first_instance'	=> 20,
			'second_instance'	=> 30,
			'third_instance'	=> 50,
			'forth_instance'	=> 100,
		],

		'inappropriate_conduct'=> [
			'first_instance'	=> 20,
			'second_instance'	=> 30,
			'third_instance'	=> 50,
			'forth_instance'	=> 100,
		],

		'disrupts_community'=> [
			'first_instance'	=> 20,
			'second_instance'	=> 30,
			'third_instance'	=> 50,
			'forth_instance'	=> 100,
		],

		'malicious_reporting'=> [
			'first_instance'	=> 100,
			'second_instance'	=> 300,
		],

		'non_adherence_to _principles'=> [
			'first_instance'	=> 500,
		],
	],

	'social_levels' =>[
		'mwanzo'		=> 0,
		'uungano'		=> 3000,
		'stahimili'		=> 6000,
		'shupavu'		=> 10000,
		'hodari'		=> 15000,
		'shujaa'		=> 20000,
		'bingwa'		=> 30000,
	],

	'limit'			=>[
		'purchase_coins'	=> 200,
	],
];