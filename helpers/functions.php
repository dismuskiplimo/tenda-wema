<?php

	function custom_asset($asset){
		if(config('app.https') == true){
			return secure_asset($asset);
		}

		return asset($asset);
	}

	function logo($type = 'full'){
		return custom_asset('images/logo.png');
	}

	function logo_absolute($type = 'full'){
		return base_path(config('app.public_path') . '/images/logo.png');
	}

	function word_count($string){
		$words = explode(' ', $string);

		return count($words);
	}

	function my_asset($asset){
		return custom_asset($asset);
	}

	function simba_coin(){
		return custom_asset('images/simba-coin.png');
	}

	function mpesa_date($date){
		$year = substr($date, 0 ,4);
		$month = substr($date, 4 ,2);
		$day = substr($date, 6 ,2);

		$hour = substr($date,8 ,2);
		$min = substr($date,10 ,2);
		$second = substr($date,12 ,2);

		return $day .'/' . $month . '/' . $year . ' at ' . $hour . ':' . $min . ':' . $second;
	}

	function simple_date($date){
		return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('jS F, Y');
	}

	function simple_datetime($date){
		return \Carbon\Carbon::parse($date)->format('jS M Y, ') . ' ' . \Carbon\Carbon::parse($date)->format('g:i A');
	}

	function fancy_date($date){
		$date = \Carbon\Carbon::parse($date);
		$diff = $date->diffForHumans();

		return $diff;
	}

	function social_badge($level, $type = 'web'){
		$path = '';

		if(strtolower($level) == strtolower('MWANZO')){
			$path = 'images/badges/mwanzo.png';
		}

		elseif(strtolower($level) == strtolower('UUNGANO')){
			$path = 'images/badges/uungano.png';
		}

		elseif(strtolower($level) == strtolower('STAHIMILI')){
			$path = 'images/badges/stahimili.png';
		}

		elseif(strtolower($level) == strtolower('SHUPAVU')){
			$path = 'images/badges/shupavu.png';
		}

		elseif(strtolower($level) == strtolower('HODARI')){
			$path = 'images/badges/hodari.png';
		}

		elseif(strtolower($level) == strtolower('SHUJAA')){
			$path = 'images/badges/shujaa.png';
		}

		elseif(strtolower($level) == strtolower('BINGWA')){
			$path = 'images/badges/bingwa.png';
		}

		else{
			$path = 'images/badges/mwanzo.png';
		}

		if($type == 'web'){
			return custom_asset($path);
		}else{
			return base_path(config('app.public_path') . '/' . $path);
		}
		
	}

	function award($award){
		if(strtolower($award) == strtolower('most-active')){
			return custom_asset('images/badges/most-active-member.png');
		}

		elseif(strtolower($award) == strtolower('community-member')){
			return custom_asset('images/badges/community-member-award.png');
		}

		else{
			return custom_asset('images/badges/most-active-member.png');
		}
	}

	function profile_picture(App\User $user){
		$path = base_path() . '/' . config('app.public_path') . '/' . 'images/uploads/';

		$image 	= $user->image;

		$file = $path . $image;

		if($image){
			if(file_exists($file)){
				return custom_asset('images/uploads/' . $image);
			}else{
				return custom_asset('images/default-user.png');	
			}
		}else{
			return custom_asset('images/default-user.png');
		}
	}	

	function profile_thumbnail(App\User $user){
		$path 		= base_path() . '/' . config('app.public_path') . '/' . 'images/uploads/thumbnails/';
		
		$thumbnail 	= $user->thumbnail;

		$file = $path . $thumbnail;

		if($thumbnail){
			if(file_exists($file)){
				return custom_asset('images/uploads/thumbnails/' . $thumbnail);
			}else{
				return custom_asset('images/default-user.png');	
			}
		}else{
			return custom_asset('images/default-user.png');
		}
	}


	function good_deed_image($good_deed = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/good_deeds/images/';
		
		if($good_deed){
			$image 	= $good_deed->image;

			$file = $path . $image;


		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/good_deeds/images/' . $image);
			}else{
				return custom_asset('images/product.png');	
			}
		}else{
			return custom_asset('images/product.png');
		}
	}

	function good_deed_thumbnail($good_deed = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/good_deeds/thumbnails/';
		
		if($good_deed){
			$image 	= $good_deed->image;

			$file = $path . $image;


		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/good_deeds/thumbnails/' . $image);
			}else{
				return custom_asset('images/product.png');	
			}
		}else{
			return custom_asset('images/product.png');
		}
	}

	function item_image($item = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/donated_items/images/';
		
		if($item){
			$image 	= $item->image;

			$file = $path . $image;


		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/donated_items/images/' . $image);
			}else{
				return custom_asset('images/product.png');	
			}
		}else{
			return custom_asset('images/product.png');
		}
	}

	function item_banner($item = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/donated_items/banners/';
		
		if($item){
			$image 	= $item->banner;

			$file = $path . $image;

		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/donated_items/banners/' . $image);
			}else{
				return custom_asset('images/product.png');	
			}
		}else{
			return custom_asset('images/product.png');
		}
	}

	function item_thumbnail($item = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/donated_items/thumbnails/';
		
		if($item){
			$image 	= $item->thumbnail;

			$file = $path . $image;
		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/donated_items/thumbnails/' . $image);
			}else{
				return custom_asset('images/product-1.png');	
			}
		}else{
			return custom_asset('images/product-1.png');
		}
	}

	function item_slide($item = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/donated_items/slides/';
		
		if($item){
			$image 	= $item->slide;

			$file = $path . $image;
		}

		if(isset($image)){
			if(file_exists($file)){
				return custom_asset('images/uploads/donated_items/slides/' . $image);
			}else{
				return custom_asset('images/slideshow.png');	
			}
		}else{
			return custom_asset('images/slideshow.png');
		}
	}

	function user_photo($filename = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/user_photos/images/';

		$file = $path . $filename;

		if(file_exists($file)){
			return custom_asset('images/uploads/user_photos/images/' . $filename);
		}else{
			return custom_asset('images/slideshow.png');	
		}
		
	}

	function user_thumbnail($filename = ''){
		$path 		= base_path() . '/' . config('app.public_path')  . '/images/uploads/user_photos/thumbnails/';

		$file = $path . $filename;

		if(file_exists($file)){
			return custom_asset('images/uploads/user_photos/thumbnails/' . $filename);
		}else{
			return custom_asset('images/slideshow.png');	
		}
		
	}

	if (! function_exists('words')) {
	    /**
	     * Limit the number of words in a string.
	     *
	     * @param  string  $value
	     * @param  int     $words
	     * @param  string  $end
	     * @return string
	     */
	    function words($value, $words = 100, $end = '...'){
	        return \Illuminate\Support\Str::words($value, $words, $end);
	    }
	}


	if (! function_exists('characters')) {
	    /**
	     * Limit the number of words in a string.
	     *
	     * @param  string  $value
	     * @param  int     $words
	     * @param  string  $end
	     * @return string
	     */
	    function characters($value, $characters = 100, $end = '...'){
	        return \Illuminate\Support\Str::limit($value, $characters, $end);
	    }
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	function ordinal_suffix($number){
		$ends = ['th','st','nd','rd','th','th','th','th','th','th'];
		
		if (($number %100) >= 11 && ($number%100) <= 13){
		   $abbreviation = $number. 'th';
		}

		else{
		   $abbreviation = $number. $ends[$number % 10];
		}

		return $abbreviation;
	}