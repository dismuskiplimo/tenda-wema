<div class="modal fade" id="update-user-email">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('auth.email.update') }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update Email</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="email">Email</label>
                <input type = "email" name="email" id="email" required="" class="form-control" value="{{ $user->email }}" />
              </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Email</button>
        </div>
      </form>
    </div>
  </div>
</div>