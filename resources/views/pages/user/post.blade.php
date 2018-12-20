@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ characters($title, 20) }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('posts') }}">Posts</a></li>
				<li class="active">{{ characters($title, 20) }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row py-50">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="panel panel-info">
					<div class="panel-body">
					    <div class="row">
					    	<div class="col-sm-9">
					    		<h4 class="nobottommargin">
									<a href="{{ route('user.show', ['username' => $post->user->username]) }}">
										<img src="{{ $post->user->thumbnail() }}" alt="" class="size-50 mr-10 pull-left"> 
										{{ $post->user->name }} <br>
										<small class="text-muted">
											 {{ simple_datetime($post->created_at) }}
										</small>
										
									</a>
								</h4>
					    	</div>

					    	<div class="col-sm-3 text-right">
					    		@if(auth()->check() && !auth()->user()->is_admin())
									@if(!$mine)
										<a href="" data-toggle="modal" data-target="#report-post-{{ $post->id }}" title="report post" class="btn btn-danger"><i class="fa fa-bullhorn"></i></a>

										@include('pages.user.modals.report-post')
									@else
										<a href="" data-toggle="modal" data-target="#edit-post-{{ $post->id }}" title="edit post" class="btn btn-warning"><i class="fa fa-edit"></i></a>

										<a href="" data-toggle="modal" data-target="#delete-post-{{ $post->id }}" title="delete post" class="btn btn-danger"><i class="fa fa-trash"></i></a>

										@include('pages.user.modals.edit-post')
										@include('pages.user.modals.delete-post')
									@endif
									
								@else
									<a href="" data-toggle="modal" data-target="#login-modal" title="login to comment" class="btn text-success btn-xs"><i class="fa fa-login"></i></a>
								@endif
					    	</div>
					    </div>

					    <hr>

					    <h3 class="">
					    	<a href="{{ route('post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
					    </h3>
					    
					    
					    	{!! clean(nl2br($post->content)) !!}
					    	
					    
						
						<p class="text-muted nobottommargin text-right">
							<small>
								Posted by 
								<a href="{{ route('user.show', ['username' => $post->user->username]) }}">
									
									{{ $post->user->name }}
								</a> | {{ simple_datetime($post->created_at) }} | Comments({{ number_format(count($comments)) }})
							</small>
						</p>

					</div>
				</div>

				<h4 class="nobottommargin">Comments({{ number_format(count($comments)) }})</h4>

				

				@if(count($post->comments))
					@foreach($comments as $comment)
						<div class="panel" id = "comment-{{ $comment->id }}">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-10">
										<p class="nobottommargin">
											<a href="{{ route('user.show', ['username' => $comment->user->username]) }}">
												<img src="{{ $comment->user->thumbnail() }}" alt="" class="size-20 mtn-5 mr-10"> 
												{{ $comment->user->name }},
												<small class="text-muted">
													 {{ simple_datetime($comment->created_at) }}
												</small>
												
											</a>
										</p>
									</div>
									
									<div class="col-sm-2 text-right">
										@if(auth()->check() && !auth()->user()->is_admin())
											@if(auth()->user()->id != $comment->user_id)
												<a href="" data-toggle="modal" data-target="#report-comment-{{ $comment->id }}" title="report comment" class="btn text-danger btn-xs"><i class="fa fa-bullhorn"></i></a>

												@include('pages.user.modals.report-comment')
											@else
												<a href="" data-toggle="modal" data-target="#edit-comment-{{ $comment->id }}" title="edit comment" class="btn text-warning btn-xs"><i class="fa fa-edit"></i></a>

												<a href="" data-toggle="modal" data-target="#delete-comment-{{ $comment->id }}" title="delete comment" class="btn text-danger btn-xs"><i class="fa fa-trash"></i></a>

												@include('pages.user.modals.edit-comment')
												@include('pages.user.modals.delete-comment')
											@endif
											
										@endif
										
									</div>
								</div>
								

								<hr>

								<p class="nobottommargin">{{ $comment->content }}</p>
							</div>
						</div>
					@endforeach
				@else
					<p class="">No Comments for this post</p>
				@endif

				@if(auth()->check() && !auth()->user()->is_admin())
					<div class="panel panel-primary">
						<div class="panel-body">
							<form action="{{ route('post.comment', ['slug' => $post->slug]) }}" method = "POST">
								@csrf

								<div class="form-group">
									<label for="">Write Comment</label>
									<textarea name="content" id="" rows="4" class="form-control" required=""></textarea>
								</div>

								<button class="button button-green button-3d nobottommargin pull-right" type="submit"><i class="fa fa-comment"></i> COMMENT</button>
							</form>
						</div>
					</div>

				@else
					<p>
						<a href="" data-toggle="modal" data-target="#login-modal" title="login to comment" class="btn text-success btn-xs"><i class="fa fa-login"></i> Login To Comment</a>
					</p>
					
				@endif

			</div>
		</div>
	</div>

	@if(!auth()->check())
		@include('pages.user.modals.login')
	@else
		@if(!$mine)
			
		@endif
	@endif
		

		

@endsection