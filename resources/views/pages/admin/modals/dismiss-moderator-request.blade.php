<div class="modal fade" id="dismiss-moderator-request-{{ $moderator_request->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.moderator-request.dismiss', ['id' => $moderator_request->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Dismiss request to be moderator?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Cancel request from <strong>{{ $moderator_request->user->name }}</strong> to become a moderator ? <br> <br>

                <div class="form-group">
                  <label for="">Reason</label>  
                  <textarea name="reason" id="" rows="10" class="form-control" required=""></textarea>
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Cancel Request</button>
        </div>
      </form>
    </div>
  </div>
</div>