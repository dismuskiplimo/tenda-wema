<div class="modal fade" id="review-item-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-body">
			<form action="{{ route('user.donated-item.review', ['slug' => $item->slug]) }}" method="POST" class="">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Review Item</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="username">Rating</label>
									
									<div class="radio">
										<label for="rating-1" class="radio-inline">
											<input type="radio" name = "rating" value="1" id="rating-1"> 
											<i class="fa fa-star text-warning"></i> (Poor) 
										</label>

										<label for="rating-2" class="radio-inline">
											<input type="radio" name = "rating" value="2" id="rating-2"> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> (Okay) 
										</label>

										<label for="rating-3" class="radio-inline">
											<input type="radio" name = "rating" value="3" id="rating-3" checked=""> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> (Average) 
										</label>

										<label for="rating-4" class="radio-inline">
											<input type="radio" name = "rating" value="4" id="rating-4"> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> (Good) 
										</label>

										<label for="rating-5" class="radio-inline">
											<input type="radio" name = "rating" value="5" id="rating-5"> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> 
											<i class="fa fa-star text-warning"></i> (Very Good) 
										</label>
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<label for="password">Comment</label>
									<textarea name="message" class="form-control required" placeholder="comment" required="" rows="3">{{ old('message') }}</textarea>
								</div>
							</div>

							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="button button-black pull-left" data-dismiss="modal">CLOSE</button>
						<button type="submit" class="button button-green submit">REVIEW {{ $item->name }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>