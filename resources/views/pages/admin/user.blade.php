@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }}</h3>

	            @if(!$user->closed && !$me)
		            <p class="text-right mb-0">
		          		@if(!$user->verified)
							<a href="" data-toggle="modal" data-target="#verify-user-{{ $user->id }}" class="btn btn-xs btn-success">
			          			<i class="fa fa-certificate"></i> Verify User
			          		</a>
		          		@endif

		          		<a href="" data-toggle="modal" data-target="#close-account-{{ $user->id }}" class="btn btn-xs btn-danger">
		          			<i class="fa fa-times"></i> Close Account
		          		</a>
		            </p>

		            @include('pages.admin.modals.close-account')

		            @if(!$user->verified && !$me)
						@include('pages.admin.modals.verify-user')
	          		@endif
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection