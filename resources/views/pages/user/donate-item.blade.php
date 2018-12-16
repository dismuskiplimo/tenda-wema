@extends('layouts.user')

@section('content')
	<!-- Page Title
	============================================= -->
	<section id="page-title">

		<div class="container clearfix">
			<h1>Donate Item</h1>
			<span>Donate Item to the Community</span>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li class="active">Donate Item</li>
			</ol>
		</div>

	</section><!-- #page-title end -->

	<div class="container">
		<div class="row content-wrap">
			<div class="col-sm-10 col-sm-offset-1">
				<form action="{{ route('donate-item') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="item-name">Item Name</label>
								<input type="text" id="item-name" name="name" required="" class="form-control required" placeholder="item name" value="{{ old('name') }}" />
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="type">Type</label>
								<select name="type" id="type" class="form-control required" required="" />
									<option value="">--Select Item Type --</option>
									<option value="PRODUCT"{{ old('type') == 'PRODUCT' ? ' selected' : '' }}>Product</option>
									<option value="SERVICE"{{ old('type') == 'SERVICE' ? ' selected' : '' }}>Service</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="condition">Condition</label>
								<select name="condition" id="condition" class="form-control required" required="" />
									<option value="">--Select Item Condition --</option>
									<option value="NEW"{{ old('condition') == 'NEW' ? ' selected' : '' }}>New</option>
									<option value="USED"{{ old('condition') == 'USED' ? ' selected' : '' }}>Used</option>
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="category_id">Category</label>
								<select name="category_id" id="category_id" class="form-control required" required="" />
									<option value=""> -- Select Item Category --</option>
									@if(count($categories))
										@foreach($categories as $category)
											<option value="{{ $category->id }}"{{ old('category_id') == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
										@endforeach
									@endif
																		
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="item-description">Description</label>
								<textarea id="item-description" name="description" required="" class="form-control required" placeholder="item description" rows="10">{{ old('description') }}</textarea>
							</div>
						</div>

					</div>

					<div class="row mb-20">
						<div class="col-sm-8 buttons">
                             <label for="">IMAGES (Only images accepted | maximum size allowed per image : 4MB)</label>           
                            <div class="button-wrapper file-button"></div>

                            <button class="btn add-file-button btn-sm btn-success" type="button">
                            	<i class="fa fa-plus"></i> Add Image
                            </button>
   
                    	</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							@if(auth()->check())
								<button class="button button-black button-3d nomargin" type="submit">DONATE</button>
							@else
								<a href="" class="button button-green button-3d nomargin" data-toggle="modal" data-target="#login-modal">PLEASE LOG IN TO DONATE</a>

								
							@endif

							
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
		

@if(!auth()->check())
	@include('pages.user.modals.login')
@endif

@endsection