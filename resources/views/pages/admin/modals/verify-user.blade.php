<div class="modal fade" id="verify-user-{{ $user->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.user.verify', ['id' => $user->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Verify User?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Verify <strong>{{ $user->name }}</strong> ?
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Verify</button>
        </div>
      </form>
    </div>
  </div>
</div>