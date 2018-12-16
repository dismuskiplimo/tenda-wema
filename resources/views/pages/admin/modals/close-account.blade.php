<div class="modal fade" id="close-account-{{ $user->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.user.close-account', ['id' => $user->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Close Account?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Close Account for <strong>{{ $user->name }}</strong> ? This Action Cannot be undone <br><br>

                <div class="form-group">
                  <label for="">Reason</label>
                  <textarea name="reason" id="" rows="5" required="" class="form-control"></textarea>
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Close Account</button>
        </div>
      </form>
    </div>
  </div>
</div>