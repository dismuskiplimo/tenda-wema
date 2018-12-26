@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $user->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('registered-members') }}">Registered Members</a></li>
				<li class="active">{{ $user->name }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row my-50">
			<div class="col-sm-3">
				@include('includes.user.profile-sidebar')
			</div>

			<div class="col-sm-9">
				<h4>ABOUT {{ strtoupper($user->fname) }}</h4>

				<h5>
					About:

					@if($me)
						<a href="" data-toggle="modal" data-target="#about-me" class="btn btn-xs btn-info pull-right">Edit</a>
					@endif
				</h5>
                <hr class = "mtn-5">
                {!! clean(nl2br($user->about_me ? : 'No Details')) !!}

                <br>

                <h5>
                    My Interests:
                    
                    @php
                        $my_interest = $user->interests()->orderBy('created_at', 'DESC')->first();
                    @endphp

                    @if($me && !$my_interest)
                        <a href="" data-toggle="modal" data-target="#add-my-interests" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Interests</a>
                    @endif

                    @if($my_interest && $me)
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-my-interests-{{ $my_interest->id }}"  title="edit {{ $my_interest->content }}">
                                <i class="fa fa-edit"></i>
                            </button> 

                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-my-interests-{{ $my_interest->id }}" title="delete {{ $my_interest->content }}">
                                <i class="fa fa-trash"></i>
                            </button> 
                        </span>
                    @endif
                </h5>
                <hr class = "mtn-5">
                
                @if($my_interest)
                    
                    <p class="ml-20"> 

                        {!! clean(nl2br($my_interest->content)) !!}

                        @if($me)
                            @include('pages.user.modals.edit-my-interest')
                            @include('pages.user.modals.delete-my-interest')
                        @endif
                           
                    </p>

                @else
                    <p class="ml-20">No Interests</p>
                @endif

                <br>

            	<h5>
            		5 Quotes I Love:
                    
                    @php
                        $quotes_i_love = $user->quotes_i_love()->orderBy('created_at', 'DESC')->first();
                    @endphp

					@if($me && !$quotes_i_love)
						<a href="" data-toggle="modal" data-target="#add-quotes-i-love" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Quotes I Love</a>
					@endif

                    @if($quotes_i_love && $me)
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-quotes-i-love-{{ $quotes_i_love->id }}"  title="edit {{ $quotes_i_love->content }}">
                                <i class="fa fa-edit"></i>
                            </button> 

                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-quotes-i-love-{{ $quotes_i_love->id }}" title="delete {{ $quotes_i_love->content }}">
                                <i class="fa fa-trash"></i>
                            </button> 
                        </span>
                    @endif
            	</h5>
                <hr class = "mtn-5">
                
                @if($quotes_i_love)
                    
                    <p class="ml-20"> 

                    	{!! clean(nl2br($quotes_i_love->content)) !!}

						@if($me)
                            @include('pages.user.modals.edit-quotes-i-love')
                            @include('pages.user.modals.delete-quotes-i-love')
						@endif
                           
                    </p>

                @else
                    <p class="ml-20">No quotes</p>
                @endif

                <br>


                <h5>
                    3 Books You Should Read :
                    
                    @php
                        $books_you_should_read = $user->books_you_should_read()->orderBy('created_at', 'DESC')->first();
                    @endphp

                    @if($me && !$books_you_should_read)
                        <a href="" data-toggle="modal" data-target="#add-books-you-should-read" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Books You Should Read</a>
                    @endif

                    @if($books_you_should_read && $me)
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-books-you-should-read-{{ $books_you_should_read->id }}"  title="edit {{ $books_you_should_read->content }}">
                                <i class="fa fa-edit"></i>
                            </button> 

                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-books-you-should-read-{{ $books_you_should_read->id }}" title="delete {{ $books_you_should_read->content }}">
                                <i class="fa fa-trash"></i>
                            </button> 
                        </span>
                    @endif
                </h5>
                <hr class = "mtn-5">
                
                @if($books_you_should_read)
                    
                    <p class="ml-20"> 

                        {!! clean(nl2br($books_you_should_read->content)) !!}

                        @if($me)
                            @include('pages.user.modals.edit-books-you-should-read')
                            @include('pages.user.modals.delete-books-you-should-read')
                        @endif
                           
                    </p>

                @else
                    <p class="ml-20">No Books</p>
                @endif

                <br>

                <h5>
                    The World I Desire to See :
                    
                    @php
                        $world_i_desire = $user->world_i_desire()->orderBy('created_at', 'DESC')->first();
                    @endphp

                    @if($me && !$world_i_desire)
                        <a href="" data-toggle="modal" data-target="#add-world-i-desire" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Message</a>
                    @endif

                    @if($world_i_desire && $me)
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-world-i-desire-{{ $world_i_desire->id }}"  title="edit {{ $world_i_desire->content }}">
                                <i class="fa fa-edit"></i>
                            </button> 

                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-world-i-desire-{{ $world_i_desire->id }}" title="delete {{ $world_i_desire->content }}">
                                <i class="fa fa-trash"></i>
                            </button> 
                        </span>
                    @endif
                </h5>
                <hr class = "mtn-5">
                
                @if($world_i_desire)
                    
                    <p class="ml-20"> 

                        {!! clean(nl2br($world_i_desire->content)) !!}

                        @if($me)
                            @include('pages.user.modals.edit-world-i-desire')
                            @include('pages.user.modals.delete-world-i-desire')
                        @endif
                           
                    </p>

                @else
                    <p class="ml-20">No Message</p>
                @endif

                <br>

                <h5>
                    My Hobbies :
                    
                    @php
                        $hobby = $user->hobbies()->orderBy('created_at', 'DESC')->first();
                    @endphp

                    @if($me && !$hobby)
                        <a href="" data-toggle="modal" data-target="#add-hobby" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Hobby</a>
                    @endif

                    @if($hobby && $me)
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-hobby-{{ $hobby->id }}"  title="edit {{ $hobby->content }}">
                                <i class="fa fa-edit"></i>
                            </button> 

                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-hobby-{{ $hobby->id }}" title="delete {{ $hobby->content }}">
                                <i class="fa fa-trash"></i>
                            </button> 
                        </span>
                    @endif
                </h5>
                <hr class = "mtn-5">
                
                @if($hobby)
                    
                    <p class="ml-20"> 

                        {!! clean(nl2br($hobby->content)) !!}

                        @if($me)
                            @include('pages.user.modals.edit-hobby')
                            @include('pages.user.modals.delete-hobby')
                        @endif
                           
                    </p>

                @else
                    <p class="ml-20">No Hobbies</p>
                @endif
                

                
 
			</div>
		</div>
	</div>
		

@if($me)
	@include('pages.user.modals.about-me')
	@include('pages.user.modals.add-membership')
    @include('pages.user.modals.add-award')
    @include('pages.user.modals.add-hobby')
    @include('pages.user.modals.add-achievement')
    @include('pages.user.modals.add-education')
    @include('pages.user.modals.add-work-experience')
    @include('pages.user.modals.add-skill')

    @include('pages.user.modals.add-my-interest')
    @include('pages.user.modals.add-quotes-i-love')
    @include('pages.user.modals.add-books-you-should-read')
    @include('pages.user.modals.add-world-i-desire')
   
@endif
		

@endsection