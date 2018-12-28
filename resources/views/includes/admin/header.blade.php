<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <!-- Favicon icon -->

    <link rel="icon" href="{{ custom_asset('favicon.ico') }}">

    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ custom_asset('css/admin/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ custom_asset('css/admin//bootstrap-extension.css') }}" rel="stylesheet">
    <!-- This is Sidebar menu CSS -->
    <link href="{{ custom_asset('css/admin/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- This is a Animation CSS -->
    <link href="{{ custom_asset('css/admin/animate.css') }}" rel="stylesheet">
    <!-- This is a Custom CSS -->
    <link href="{{ custom_asset('css/admin/style.min.css') }}" rel="stylesheet">
    <link href="{{ custom_asset('css/admin/morris.css') }}" rel="stylesheet">
    <link href="{{ custom_asset('css/admin/admin.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ custom_asset('css/user/jquery.fancybox.min.css') }}" type="text/css" />
                              
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-gray-dark (gray-dark.css) for this starter
         page. However, you can choose any other skin from folder css / colors .
         -->
    <link href="{{ custom_asset('css/admin/colors/megna.css') }}" id="theme" rel="stylesheet">

   {{--  <link href="{{ custom_asset('css/tenda-wema.css') }}" id="theme" rel="stylesheet"> --}}

    <script src="{{ custom_asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ custom_asset('js/admin/raphael.min.js') }}"></script>
    <script src="{{ custom_asset('js/admin/morris.min.js') }}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

    <div id="wrapper">
        @include('includes.admin.top-nav')
        
        @include('includes.admin.left-sidebar')
        

        <!-- Page Content -->
        <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row bg-title">
                    <!-- .page title -->
                    <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12">
                        <h4 class="page-title">@yield('title')
                            
                        </h4> 
                    </div>

                    
                    <!-- /.page title -->
                </div>
                <!-- .row -->
                

                
