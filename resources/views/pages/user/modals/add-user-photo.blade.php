<div class="modal fade" id="add-user-photo-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-body">
			<form action="{{ route('user.photos.add', ['username' => $user->username]) }}" method="POST" class="" enctype="multipart/form-data">

				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Add Photo</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="user-photo">Photo</label>

									<input type="file" class="" required="" name="image" id="user-photo">
									
									
								</div>
							</div>

							

							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="button button-black pull-left" data-dismiss="modal">CLOSE</button>
						<button type="submit" class="button button-green submit"><i class="fa fa-plus"></i> ADD PHOTO </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

