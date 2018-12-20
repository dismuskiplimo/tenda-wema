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
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="col-sm-12">	
						@if(auth()->check())
							@if(!auth()->user()->is_admin())
								<p class="">
									<a href="" data-toggle = "modal" data-target = "#create-post" class="button button-green  button-3d pull-right"><i class="fa fa-comment"></i> CREATE POST</a>
								</p>
								
								@include('pages.user.modals.create-post')

							@endif
						@else
							<p>
								<a href="" data-toggle = "modal" data-target = "#login-modal"  class="button button-black  button-3d pull-right"><i class="fa fa-comment"></i> LOG IN TO POST</a>
							</p>

							@include('pages.user.modals.login')
															
						@endif
					</div>


				</div>

				<hr>

				<div class="row">
					<div class="col-sm-12">
						@if($posts->total())
							@foreach($posts as $post)
								<div class="panel">
									<div class="panel-body">
									    <h4 class="">
									    	<a href="{{ route('post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
									    </h4>
									    
									    <p>
									    	{{ characters($post->content, 550) }} <br><br>
									    	<a href="{{ route('post', ['slug' => $post->slug]) }}" class="pull-right">Read More</a>
									    </p>
										
										<p class="text-muted nobottommargin text-right">
											<small>
												Posted by 
												<a href="{{ route('user.show', ['username' => $post->user->username]) }}">
													
													{{ $post->user->name }}
												</a> | {{ simple_datetime($post->created_at) }} | Comments({{ number_format(count($post->comments)) }})
											</small>
										</p>

									</div>


								</div>
								  
							@endforeach
							
							{{ $posts->links() }}
						@else
							<p>No Posts</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
		

		

@endsection