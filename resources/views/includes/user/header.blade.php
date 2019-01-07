
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Dismus Kiplimo (dismuskiplimo@gmail.com)" />

	<meta name = "csrf-token" content="{{ csrf_token() }}">
	<meta name = "description" content="{{ config('app.name') }} | The Simba Coin Community for Good Deeds">

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<link rel="stylesheet" href="{{ custom_asset('css/user/bootstrap.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/style.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/swiper.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/dark.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/magnific-popup.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/responsive.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/font-awesome.min.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/jquery.fancybox.min.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/bootstrap-datepicker.min.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ custom_asset('css/cropper.min.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/jquery.Jcrop.min.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/croppie.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ custom_asset('css/remodal-default-theme.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/remodal.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/tenda-wema.css') }}" type="text/css" />
	
	
	<link rel="stylesheet" href="{{ custom_asset('css/user/remodal-default-theme.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ custom_asset('css/user/remodal.css') }}" type="text/css" />

	<link rel="icon" href="{{ custom_asset('favicon.ico') }}">	
	
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>{{ isset($title) ? $title : '' }} | {{ config('app.name') }}</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		