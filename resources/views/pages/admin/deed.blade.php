@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <div class="row">
	            	<div class="col-sm-12">
	            		<h3 class="box-title">
	            			{{ $title }}

	            			<a href="{{ route('admin.deeds', ['type' => 'pending-approval']) }}" class="btn btn-xs pull-right btn-info"><i class="fa fa-arrow-left"></i> BACK</a>
	            		</h3>


	            	</div>
	            </div>
	            

	            <p class="text-right">
	            	@if($deed->approved)
						<a href=""  data-toggle = "modal" data-target = "#deed-disapprove-{{ $deed->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times" title="Disapprove Deed"></i> Disapprove Deed</a>

						@include('pages.admin.modals.disapprove-deed')
					@else
						@if($deed->disapproved)
							<a href="" data-toggle = "modal" data-target = "#deed-approve-{{ $deed->id }}"  class="btn btn-xs btn-success"><i class="fa fa-check" title="Approve Deed"></i> Approve Deed</a>
						@else
							<a href="" data-toggle = "modal" data-target = "#deed-approve-{{ $deed->id }}"  class="btn btn-xs btn-success"><i class="fa fa-check" title="Approve Deed"></i> Approve Deed</a>

							<a href="" data-toggle = "modal" data-target = "#deed-disapprove-{{ $deed->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times" title="Disapprove Deed"></i> Disapprove Deed</a>

							@include('pages.admin.modals.disapprove-deed')
						@endif

						@include('pages.admin.modals.approve-deed')
						

					@endif
	            </p>

	            <hr>


	            <div class="row">
					<div class="col-sm-6 border-right">
						<h4 class="text-muted">GOOD DEED</h4> 
						<h5> {{ $deed->name }} <br>  <br>
							
							<small class="text-muted">{{ simple_datetime($deed->created_at) }}</small>
						</h5>

						<hr>

						<h4 class="mb-0 text-muted">LOCATION</h4>
						<p>{{ $deed->location }}</p>

						<hr>

						<h4 class="mb-0 text-muted">DESCRIPTION</h4>
						{!! clean(nl2br($deed->description)) !!}

						<hr>
						
						<h4 class="mb-0 text-muted">CONTACTS TO THOSE WHO CAN TESTIFY</h4>
						{!! clean(nl2br($deed->contacts)) !!}
						
					</div>

					<div class="col-sm-6">
						@php
							if($deed->disapproved){
								$color = 'red';
								$text = 'NOT APPROVED';
							}else{
								$color = $deed->approved ? 'green' : 'orange';
								$text = $deed->approved ? 'APPROVED' : 'PENDING APPROVAL';
							}
							

							

						@endphp

						<h4 class="mb-10">DONE BY <span class="pull-right" style ="color:{{ $color }}">{{ $text }}</span> </h4>
						<p>
							<a href="{{ route('admin.user', ['id' => $deed->user->id]) }}">
								<img src="{{ $deed->user ? $deed->user->profile_thumbnail() : '' }}" alt="{{ $deed->user ? $deed->user->name : '' }}" class="size-30 mr-10 img-circle"> 

								<i class="mt-10">
									{{ $deed->user ? $deed->user->name : '' }}	
								</i>
								
							</a>
						</p>
						
						<h4 class="mb-5">EVIDENCE ({{ count($deed->images) }})</h4>
						@if(count($deed->images))
							<div class="row">
								@php
									$count = 0;
								@endphp

								@foreach($deed->images()->orderBy('created_at', 'DESC')->get() as $image)
									@php
										$count++;
									@endphp
									<div class="col-sm-4">
										<a data-fancybox="gallery" href="{{ $image->image() }}">
											<img src="{{ $image->thumbnail() }}" alt="{{ $image->user ? $image->user->name : '' }}" class="img-responsive img-rounded">
										</a>
									</div>

									@if($count % 3 == 0)
										</div>
										<div class="row mb-20">
									@endif
								@endforeach	
							</div>
							
						@else
							<p class="text-muted mb-0">No evidence attached</p>
						@endif
					</div>
				</div>
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection