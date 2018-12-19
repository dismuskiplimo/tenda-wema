@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title full-width">
	            	{{ $title }} 
	            	<a href="{{ url()->previous() }}" class="btn btn-info btn-xs margin-right">
	            		<i class="fa fa-arrow-left"></i> BACK
	            	</a>
	            </h3>
					
				@if(count($bought_items->total()))
					<div class="row">
						@foreach($bought_items as $item)
						
							@php
								$banner = item_banner();

								if($item->images){
									$donated_item_image = $item->images()->first();

									if($donated_item_image){
										$banner 		= $donated_item_image->banner();
									}
									
								}
							@endphp

							<div class="col-sm-4 mb-20">
								<div class="">
									<div class="">
										<div class="row">
											<div class="col-sm-4">
												<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">
													<img src="{{ $banner }}" alt="{{ $item->name }}" class="img-responsive">
												</a>
											</div>

											<div class="col-sm-8">
												<h4 class="mt-10">
													<a href="{{ route('admin.donated-item', ['id' => $item->id]) }}">{{characters($item->name, 20)}}</a>	
												</h4>

												<small class="text-muted">{{ $item->category ? $item->category->name : '' }}</small>
											</div>
										</div>
										

										
									</div>
								</div>
							</div>

						@endforeach
												
					</div>

					{{ $bought_items->links() }}
	
				@else
					<i>No items bought</i>
				@endif
	        </div>
            
        </div> 
	       
	</div>
	
@endsection