<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-body">
			<form action="{{ route('auth.login') }}" method="POST" class="custom-auth-form">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Login</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="username">Username/Email</label>
									<input type="text" name="username" id="username" class="form-control required" placeholder="username/email" required="" />
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control required" placeholder="password" required="" />
								</div>
							</div>

							<div class="col-sm-12">
								<div class="checkbox">
									<label for="remember" class="checkbox-inline">
										<input type="checkbox" name="remember" id="remember"> Remember Me
									</label>
								</div>

								<span class="feedback"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="button button-black pull-left" data-dismiss="modal">CLOSE</button>
						<button type="submit" class="button button-green submit">LOGIN</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>