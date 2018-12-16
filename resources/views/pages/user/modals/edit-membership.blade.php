<div class="modal fade" id="edit-membership-{{ $membership->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.membership.update', ['id' => $membership->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Membership</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <label for="name-{{ $membership->id }}">Membership</label>
                  <input type="text" name="name" id="name-{{ $membership->id }}" value="{{ $membership->name }}" class="form-control">
                </div> 
            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>