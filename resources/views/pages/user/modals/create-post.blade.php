<div class="modal fade" id="create-post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-body">
			<form action="{{ route('posts') }}" method="POST">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Create Post</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="username">Title</label>
									<input type="title" name="title" id="title" class="form-control required" placeholder="post title" required="" value="{{ old('title') }}" />
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<label for="password">Content</label>
									<textarea name="content" id="content" rows="10" class="form-control" required="" placeholder="post content">{{ old('content') }}</textarea>
								</div>
							</div>

							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="button button-black pull-left" data-dismiss="modal">CLOSE</button>
						<button type="submit" class="button button-green submit">CREATE</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>