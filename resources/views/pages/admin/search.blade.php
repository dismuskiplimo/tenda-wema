@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title mb-0">
	            	
					@if(!$empty)
						SEARCH RESULTS FOR <strong>{{  strtoupper($request->q) }}  ({{ number_format($total) }})</strong>
					@else
						<span class="text-right">
							SEARCH SOMETHING
						</span>
					@endif
	            </h3>

	            <form action="{{ route('admin.search') }}" method="GET">
					<div class="row">
						<div class="col-sm-6 col-offset-3">
							<div class="input-group">
								<input type="text" class="form-control" value="{{ $empty ? '' : $request->q }}" placeholder="type here" name="q">
								<span class="input-group-btn">
									<button class="btn btn-info" style="height: 34px "><i class="fa fa-search"></i></button>
								</span>
							</div>
								
						</div>
					</div>
					
				</form>
	            
	        </div> 

	        @if(!$empty)
	        	@if($total)
					<div class="row">
						<div class="col-lg-12 mt-20">
							<div>

							  <!-- Nav tabs -->
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users ({{ number_format($users->total()) }})</a></li>
							    <li role="presentation"><a href="#donated-items" aria-controls="donated-items" role="tab" data-toggle="tab">Donated Items ({{ number_format($donated_items->total()) }})</a></li>
							   
							  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
							    <div role="tabpanel" class="tab-pane fade in active" id="users">
							    	<br>

							    	@if($users->total())
							    		
										@foreach($users as $user)
											<div class="panel panel-default mb-20">
												<div class="panel-body">
													<div class="row">
														<div class="col-sm-12">
															<div style="width:50px; float: left">
																<a href="{{ route('admin.user', ['id' => $user->id]) }}">
																	<img class="size-50 img-circle" src="{{ $user->thumbnail() }}" alt="{{ $user->name }}">
																</a>
																
															</div>

															<div style="width:calc(100% - 70px); float: left; padding-left: 20px;">
																<a href="{{ route('admin.user', ['id' => $user->id]) }}">
																	<h4 class="nobottommargin">{{ $user->name }}, {!! $user->stars() !!}</h4>
																</a>
																<p class="nobottommargin">{{ characters($user->about_me,200) }}</p>
															</div>		
														</div>
													</div>
													
												</div>
											</div>
										@endforeach
							    	@else
										<p>No users matching <strong>{{ $request->q }}</strong></p>
							    	@endif

									{{ $users->links() }}
							    </div>

							    <div role="tabpanel" class="tab-pan fade" id="donated-items">
							    	<br>

							    	@if($donated_items->total())
										@foreach($donated_items as $item)
											<div class="panel panel-default mb-20">
												<div class="panel-body">
													<div class="row">
														@php
															
															$thumbnail = item_thumbnail();

															if($item->images){
																$donated_item_image = $item->images()->first();

																if($donated_item_image){
																	$thumbnail 		= $donated_item_image->thumbnail();
																}
													
															}
														@endphp

														<div class="col-sm-4">
															<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">
																<img src="{{ $thumbnail }}" alt="{{ $item->name }}" class="img-responsive">	
															</a>	
															
														</div>

														<div class="col-sm-8">
															<h4>Donated Item</h4>
															<h5 class="mt-10 nobottommargin">
																<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">{{characters($item->name, 20)}}</a>	
															</h5>

															<small class="text-muted nobottommargin">{{ $item->category ? $item->category->name : '' }}</small>
														</div>
													</div>
												</div>
											</div>
										@endforeach
							    	@else
										<p>No donated items matching <strong>{{ $request->q }}</strong></p>
							    	@endif

									{{ $donated_items->links() }}
							    </div>
							   
							  </div>

							</div>
						</div>
					</div>
	        	@else
					<p>No results matching <strong>{{ $request->q }}</strong></p>
	        	@endif

	        @else
				<p>Type to search</p>
	        @endif


	        
	    </div>

	    
	</div>


	

	
@endsection