<?php

	function custom_asset($asset){
		if(config('app.https') == true){
			return secure_asset($asset);
		}

		return asset($asset);
	}

	function my_asset($asset){
		return custom_asset($asset);
	}

	function simba_coin(){
		return custom_asset('images/simba-coin.png');
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

		// if(strtolower($diff) == strtolower('Today') || strtolower($diff) == strtolower('Yesterday')){
		// 	return $diff . ' at ' . $date->format('g:i A');
		// }

		return $diff;
	}

	function social_badge($level){
		if(strtolower($level) == strtolower('MWANZO')){
			return custom_asset('images/badges/mwanzo.png');
		}

		elseif(strtolower($level) == strtolower('UUNGANO')){
			return custom_asset('images/badges/uungano.png');
		}

		elseif(strtolower($level) == strtolower('STAHIMILI')){
			return custom_asset('images/badges/stahimili.png');
		}

		elseif(strtolower($level) == strtolower('SHUPAVU')){
			return custom_asset('images/badges/shupavu.png');
		}

		elseif(strtolower($level) == strtolower('HODARI')){
			return custom_asset('images/badges/hodari.png');
		}

		elseif(strtolower($level) == strtolower('SHUJAA')){
			return custom_asset('images/badges/shujaa.png');
		}

		elseif(strtolower($level) == strtolower('BINGWA')){
			return custom_asset('images/badges/bingwa.png');
		}

		else{
			return custom_asset('images/badges/mwanzo.png');
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
				return custom_asset('images/product.png');	
			}
		}else{
			return custom_asset('images/product.png');
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